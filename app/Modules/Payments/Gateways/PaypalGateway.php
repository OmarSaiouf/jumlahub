<?php

namespace App\Modules\Payments\Gateways;

use App\Modules\Payment\Abstractions\PaymentAbstraction;
use App\Modules\Payment\DTO\PaymentData;
use App\Modules\Payment\DTO\PaymentResult;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use InvalidArgumentException;

class PaypalGateway extends PaymentAbstraction
{

    private string $clientId;
    private string $clientSecret;
    private int $cacheTtl;


    public function __construct(public array $config)
    {
        $this->liveUrl = (string) $config['live_url'];
        $this->testUrl = (string) $config['test_url'];

        parent::__construct($config);

        $this->clientId = (string) $config['client_id'];
        $this->clientSecret = (string) $config['secret'];
        $this->cacheTtl = (int) $config['cache_ttl'];
        $this->isTest = (bool) $config['is_test'];

        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
        ];
    }

    public function pay(PaymentData $data): PaymentResult
    {
        $returnPath = $this->isTest ? '/payments/return' : '/api/payments/return';

        $paymentData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $data->currency ?? 'USD',
                        'value' => number_format($data->amount, 2, '.', ''),
                    ],
                    'description' => $data->description ?? 'Payment via PayPal',
                ],
            ],
            'application_context' => [
                'return_url' => $this->baseUrl . $returnPath,
                'cancel_url' => $this->baseUrl . $returnPath,
            ],
        ];

        try {
            // sendRequest assumed to be implemented in PaymentAbstraction
            $response = $this->sendRequest('POST', $this->baseUrl . '/v2/checkout/orders', $paymentData);

            return $this->success([
                'id' => $response['id'] ?? null,
                'status' => $response['status'] ?? null,
                'redirect_url' => $this->getApprovalUrl($response),
                'transaction_details' => $response,
            ]);


        } catch (\Exception $e) {
            Log::error('PayPal payment creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            return $this->failed($e->getMessage());
        }

    }
    public function refund(string $paymentId, float $amount): PaymentResult
    {
        if (empty($paymentId)) {
            throw new InvalidArgumentException('Payment ID is required for refund');
        }

        if ($amount <= 0) {
            return $this->failed('Refund amount must be greater than zero');
        }

        $refundData = [
            'amount' => [
                'value' => number_format($amount, 2, '.', ''),
                // 'currency_code' => $currency ?? 'USD',
            ],
        ];

        try {
            $response = $this->sendRequest(
                'POST',
                $this->baseUrl . "/v2/payments/captures/{$paymentId}/refund",
                $refundData
            );

            return $this->success(
                [
                    'id' => $response['id'] ?? null,
                    'status' => $response['status'] ?? null,
                    'amount' => $amount,
                    'original_payment_id' => $paymentId,
                    'processed_at' => now()->toIso8601String(),
                    'raw' => $response,
                ]
            );
        } catch (\Exception $e) {
            Log::error('PayPal refund failed', [
                'error' => $e->getMessage(),
                'payment_id' => $paymentId,
                'amount' => $amount,
            ]);
            return $this->failed($e->getMessage());
        }
    }
    public function getStatus(string $paymentId): PaymentResult
    {

        if (empty($paymentId)) {
            throw new InvalidArgumentException('Payment ID is required');
        }

        try {
            $response = $this->sendRequest(
                'GET',
                $this->baseUrl . "/v2/checkout/orders/{$paymentId}"
            );

            return $this->success(
                [
                    'id' => $response['id'] ?? null,
                    'status' => $response['status'] ?? null,
                    'amount' => $this->extractAmount($response),
                    'customer' => $this->extractCustomer($response),
                    'created_at' => $response['create_time'] ?? null,
                    'failure_reason' => $response['failure_reason'] ?? null,
                    'metadata' => $response,
                ]
            );
        } catch (\Exception $e) {
            Log::error('PayPal status retrieval failed', [
                'error' => $e->getMessage(),
                'payment_id' => $paymentId,
            ]);
            return $this->failed($e->getMessage());
        }

    }
    public function handleCallback(Request $request): PaymentResult
    {
        $data = $request->all();

        if (!$this->validateWebhookSignature($request)) {
            return $this->failed('Invalid webhook signature');
        }

        try {
            $paymentId = $data['resource']['id'] ?? null;
            Cache::put("providerCode_" . $paymentId, "paypal", now()->addMinutes(30));
            $eventType = $data['event_type'] ?? null;


            if ($this->mapPayPalStatus($eventType)) {
                return $this->failed($eventType);
            }

            return $this->success([
                'payment_id' => $paymentId,
                'status' => $eventType,
                'signature_valid' => true,
                'transaction_details' => $data,
                'processed_at' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            Log::error('PayPal callback processing failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            return $this->failed($e->getMessage());
        }



    }
    private function mapPayPalStatus(?string $paypalEvent): bool
    {
        if (!$paypalEvent) {
            return false;
        }

        return match ($paypalEvent) {
            'PAYMENT.CAPTURE.COMPLETED', 'CHECKOUT.ORDER.APPROVED' => false,
            'PAYMENT.CAPTURE.DENIED' => true,
            'PAYMENT.CAPTURE.CANCELLED' => true,
            'CHECKOUT.ORDER.CREATED' => false,
            default => false,
        };
    }

    public function handleReturn(Request $request): PaymentResult
    {
        return $this->success([
            ...$request->all()
        ]);
    }




    private function getAccessToken(): string
    {
        $cacheKey = 'paypal_access_token_' . ($this->isTest ? 'sandbox' : 'live');
        return Cache::remember($cacheKey, $this->cacheTtl, function () {
            if ($this->clientId === '' || $this->clientSecret === '') {
                throw new InvalidArgumentException('PayPal CLIENT_ID/CLIENT_SECRET are not config[red');
            }

            $tokenUrl = $this->baseUrl . '/v1/oauth2/token';

            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->acceptJson()
                ->post($tokenUrl, [
                    'grant_type' => 'client_credentials',
                ]);

            if (!$response->successful()) {
                throw new \Exception(
                    "Failed to obtain PayPal access token: {$response->status()} " . $response->body()
                );
            }

            $json = $response->json();
            $accessToken = (string) ($json['access_token'] ?? '');
            $expiresIn = (int) ($json['expires_in'] ?? 3000);

            if ($accessToken === '') {
                throw new \Exception('PayPal access token missing in response');
            }
            $this->cacheTtl = max(60, $expiresIn - 60);

            return $accessToken;
        });




    }

    private function getApprovalUrl(array $response): ?string
    {
        $links = $response['links'] ?? [];
        foreach ($links as $link) {
            if (($link['rel'] ?? '') === 'approve') {
                return $link['href'] ?? null;
            }
        }
        return null;
    }

    private function extractAmount(array $response): array
    {
        $purchaseUnit = $response['purchase_units'][0] ?? [];
        return $purchaseUnit['amount'] ?? [];
    }
    private function extractCustomer(array $response): array
    {
        return $response['payer'] ?? [];
    }
    private function validateWebhookSignature(Request $request): bool
    {
        $webhookId = (string) $this->config['webhook_id'];
        if ($webhookId === '') {
            Log::warning('PayPal webhook_id is not configred');
            return false;
        }

        $verificationUrl = $this->baseUrl . '/v1/notifications/verify-webhook-signature';

        $payload = $request->getContent();

        // PayPal header names (case-intact):
        $headers = [
            'transmission_id' => $request->header('PayPal-Transmission-Id'),
            'transmission_time' => $request->header('PayPal-Transmission-Time'),
            'cert_url' => $request->header('PayPal-Cert-Url'),
            'auth_algo' => $request->header('PayPal-Auth-Algo'),
            'transmission_sig' => $request->header('PayPal-Transmission-Sig'),
        ];

        // Ensure all required headers exist
        foreach ($headers as $key => $value) {
            if (!is_string($value) || $value === '') {
                Log::warning('Missing PayPal webhook header', ['header' => $key]);
                return false;
            }
        }

        $verificationRequest = [
            'auth_algo' => $headers['auth_algo'],
            'cert_url' => $headers['cert_url'],
            'transmission_id' => $headers['transmission_id'],
            'transmission_sig' => $headers['transmission_sig'],
            'transmission_time' => $headers['transmission_time'],
            'webhook_id' => $webhookId,
            'webhook_event' => json_decode($payload, true),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ])->post($verificationUrl, $verificationRequest);

        if (!$response->successful()) {
            Log::warning('PayPal webhook signature verification API failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }

        $json = $response->json();
        return ($json['verification_status'] ?? '') === 'SUCCESS';
    }



}