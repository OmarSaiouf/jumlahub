<?php

namespace App\Core\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public static function values(): array
    {
        return array_map(fn(PaymentStatus $status) => $status->value, self::cases());
    }

    public function getValue(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::COMPLETED => 'completed',
            self::FAILED => 'failed',
        };
    }

    public static function getAllKeyValues(): array
    {
        return array_combine(
            array_map(fn($case) => $case->getValue(), self::cases()),
            array_map(fn($case) => ucfirst($case->getValue()), self::cases())
        );
    }
}
