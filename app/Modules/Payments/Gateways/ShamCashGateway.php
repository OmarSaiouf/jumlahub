<?php

namespace App\Modules\Payments\Gateways;

use App\Modules\Payments\Abstractions\PaymentAbstraction;
use App\Modules\Payments\DTO\PaymentData;
use App\Modules\Payments\DTO\PaymentResult;
use Illuminate\Http\Request;

class ShamCashGateway extends PaymentAbstraction
{
    public function pay(PaymentData $data): PaymentResult
    {
        // Simulate a successful payment
        return $this->success([]);

    }
    public function refund(string $paymentId, float $amount): PaymentResult
    {
        // Simulate a successful refund
        return $this->success([]);
    }


    public function getStatus(string $paymentId): PaymentResult
    {
        // Simulate checking payment status
        return $this->success(['status' => 'paid']);
    }

    public function handleCallback(Request $request): PaymentResult
    {
        // Simulate handling a callback
        return $this->success([]);
    }

    public function handleReturn(Request $request): PaymentResult
    {
        // Simulate handling a return
        return $this->success([]);
    }
}