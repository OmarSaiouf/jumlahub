<?php

namespace App\Modules\Payment\Abstractions;

use Illuminate\Support\Facades\Http;
use App\Modules\Payment\DTO\PaymentData;
use App\Modules\Payment\DTO\PaymentResult;
use App\Modules\Payments\Contracts\PaymentGatewayInterface;

abstract class PaymentAbstraction implements PaymentGatewayInterface
{
    protected array $headers = [];
    protected string $baseUrl;
    protected string $testUrl;
    protected string $liveUrl;
    protected bool $isTest = true;

    public function __construct(public array $config)
    {
        $this->baseUrl = ($this->isTest ? $this->testUrl : $this->liveUrl);
    }

    final protected function sendRequest(
        string $method,
        string $endpoint,
        array $payload = []
    ): array {
        $response = Http::withHeaders($this->headers)
                    ->acceptJson()
                    ->timeout(30)
            ->{$method}(($this->isTest ? $this->testUrl : $this->baseUrl) . $endpoint, $payload);

        if (!$response->successful()) {
            throw new \RuntimeException(
                "Payment gateway error: {$response->body()}"
            );
        }

        return $response->json();
    }

    protected function success(array $data): PaymentResult
    {
        return PaymentResult::success($data);
    }

    protected function failed(string $message): PaymentResult
    {
        return PaymentResult::failed($message);
    }
}
