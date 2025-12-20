<?php

namespace App\Modules\Payments\DTO;

use InvalidArgumentException;

class PaymentData
{
    public function __construct(
        public float $amount,
        public string $currency,
        public string $referenceId,
        public string $description = '',
        public array $customer = [],
        public array $meta = []
    ) {

        if (!isset($amount) || $amount <= 0) {
            throw new InvalidArgumentException('Valid amount is required');
        }

        if (!isset($currency) || empty($currency)) {
            throw new InvalidArgumentException('Currency is required');
        }
    }
}
