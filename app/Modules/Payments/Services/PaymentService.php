<?php

namespace App\Modules\Payments\Services;

use App\Core\Enums\OrderStatus;
use App\Modules\Invoices\Models\Invoice;
use App\Modules\Payment\DTO\PaymentData;
use App\Modules\Payment\DTO\PaymentResult;
use App\Modules\Payment\Enums\PaymentStatusEnum;
use App\Modules\Payments\Events\PaymentCompleted;
use App\Modules\Payments\Events\PaymentFailed;
use App\Modules\Payments\Events\RefundCompleted;
use App\Modules\Payments\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function pay(string $providerCode, PaymentData $data): PaymentResult
    {
        try {
            DB::beginTransaction();

            if (!isset($data->meta['providerId'], $data->meta['order_id'], $data->meta['user_id'])) {
                throw new \InvalidArgumentException('Missing required meta information.');
            }
            $payment = Payment::create([
                "user_id" => $data->meta['user_id'],
                'order_id' => $data->meta['order_id'],
                'payment_provider_id' => $data->meta['providerId'],
                'amount' => $data->amount,
                'currency' => $data->currency,
                'reference_id' => $data->referenceId,
                'status' => PaymentStatusEnum::PENDING->value,
            ]);

            $gateway = PaymentGatewayFactory::make($providerCode);
            $pay = $gateway->pay($data);


            if ($pay->status === PaymentStatusEnum::FAILED) {
                DB::rollBack();
                return $pay;
            }

            $payment->update([
                'transaction_id' => $pay->data['transaction_id'] ?? null,
                'metadata' => $pay->data,
            ]);

            DB::commit();

            return $pay;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function refund(string $providerCode, string $paymentId, float $amount): PaymentResult
    {
        if (!$paymentId) {
            throw new \InvalidArgumentException('Payment ID is required for refund.');
        }
        try {
            DB::beginTransaction();

            $payment = Payment::where('id', $paymentId)->with(['order'])->first();

            if (!$payment) {
                throw new \RuntimeException('Payment not found.');
            }

            if ($payment->status !== PaymentStatusEnum::PAID->value) {
                throw new \RuntimeException('Only completed payments can be refunded.');
            }

            if ($amount > $payment->amount) {
                throw new \InvalidArgumentException('Refund amount exceeds original payment amount.');
            }

            $gateway = PaymentGatewayFactory::make($providerCode);
            $refund = $gateway->refund($paymentId, $amount);

            if ($refund->status === PaymentStatusEnum::FAILED) {
                DB::rollBack();
                return $refund;
            }

            $payment->update([
                'status' => PaymentStatusEnum::REFUNDED->value,
                'metadata' => array_merge($payment->metadata ?? [], ['refund' => $refund->data]),
            ]);

            $invoice = Invoice::where('payment_id', $payment->id)->first();
            if ($invoice) {
                $invoice->update([
                    'status' => 'refunded',
                    'meta_data' => array_merge($invoice->meta_data ?? [], ['refund' => $refund->data])
                ]);
            }
            $payment->order->update([
                'status' => OrderStatus::REFUNDED->getValue(),
            ]);
            RefundCompleted::dispatch($payment, $refund);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }



        return $refund;
    }


    public function status(string $providerCode, string $paymentId): PaymentResult
    {
        $gateway = PaymentGatewayFactory::make($providerCode);
        return $gateway->getStatus($paymentId);
    }

    public function processWebhook(Request $result)
    {
        $paymentId = $data['resource']['id'] ?? null;
        $payment = Payment::where('id', $paymentId)->with(['order'])->first();
        if (!$paymentId) {
            Log::error('Payment ID not found in webhook data.');
            return false;
        }
        try {
            DB::beginTransaction();

            $providerCode = Cache::get("providerCode_" . $paymentId);
            $gateway = PaymentGatewayFactory::make($providerCode);
            $gateway = $gateway->handleWebhook($result);
            if ($gateway->status === PaymentStatusEnum::FAILED) {
                Log::error('Payment gateway reported failure for payment ID: ' . $paymentId);
                $payment->order->update([
                    'status' => OrderStatus::CANCELLED->getValue(),
                ]);
                PaymentFailed::dispatch($payment);
                DB::rollBack();
                return false;
            }
            if (!$payment) {
                Log::error('Payment not found for ID: ' . $paymentId);
                return false;
            }
            $payment->update([
                'status' => $gateway->data['status'] ?? $payment->status,
                'metadata' => array_merge($payment->metadata ?? [], $gateway->data),
            ]);

            PaymentCompleted::dispatch($payment);

            $payment->order->update([
                'status' => OrderStatus::PENDING->getValue(),
                'transaction_id' => $paymentId,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            $payment->order->update([
                'status' => OrderStatus::CANCELLED->getValue(),
            ]);
            Log::error('Error processing webhook: ' . $e->getMessage());
            return false;
        }
    }


   
}