<?php

namespace App\Modules\Payments\DTO;

use App\Modules\Payments\Enums\PaymentStatusEnum;

class PaymentResult
{
    private function __construct(
        public PaymentStatusEnum $status,
        public array $data = [],
        public ?string $message = null
    ) {
    }

    public static function success(array $data): self
    {
        return new self(PaymentStatusEnum::PAID, $data);
    }

    public static function failed(string $message): self
    {
        return new self(PaymentStatusEnum::FAILED, [], $message);
    }
}
