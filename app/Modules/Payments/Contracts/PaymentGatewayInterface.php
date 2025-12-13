<?php


namespace App\Modules\Payments\Contracts;

use App\Modules\Payment\DTO\PaymentData;
use App\Modules\Payment\DTO\PaymentResult;
use Illuminate\Support\Facades\Request;

interface PaymentGatewayInterface
{
    
    
    public function pay(PaymentData $data): PaymentResult;

    public function refund(string $paymentId, float $amount): PaymentResult;

    public function getStatus(string $paymentId): PaymentResult;

    public function handleCallback(Request $request): PaymentResult;

    public function handleReturn(Request $request): PaymentResult;
}