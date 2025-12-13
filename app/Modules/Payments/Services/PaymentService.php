<?php

namespace App\Modules\Payments\Services;

use App\Modules\Payment\DTO\PaymentData;
use App\Modules\Payment\DTO\PaymentResult;
use Illuminate\Http\Request;

class PaymentService
{
    public function pay(string $providerCode, PaymentData $data): PaymentResult
    {
        $gateway = PaymentGatewayFactory::make($providerCode);
        return $gateway->pay($data);
    }

    public function refund(string $providerCode, string $paymentId, float $amount): PaymentResult
    {
        $gateway = PaymentGatewayFactory::make($providerCode);
        return $gateway->refund($paymentId, $amount);
    }


    public function status(string $providerCode, string $paymentId): PaymentResult
    {
        $gateway = PaymentGatewayFactory::make($providerCode);
        return $gateway->getStatus($paymentId);
    }

    public function processWebhook(PaymentResult $result)
    {
        
    }
}