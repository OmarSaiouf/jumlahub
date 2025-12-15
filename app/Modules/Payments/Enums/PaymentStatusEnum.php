<?php


namespace App\Modules\Payment\Enums;

enum PaymentStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function isFinal(): bool
    {
        return in_array($this, [
            self::PAID,
            self::FAILED,
            self::CANCELLED,
            self::REFUNDED,
        ]);
    }
    public static function values(): array
    {
        return array_map(fn(PaymentStatusEnum $status) => $status->value, self::cases());
    }
}