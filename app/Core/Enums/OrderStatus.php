<?php

namespace App\Core\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';



    public static function values(): array
    {
        return array_map(fn(OrderStatus $status) => $status->value, self::cases());
    }



    public function getValue(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::PROCESSING => 'processing',
            self::COMPLETED => 'completed',
            self::CANCELLED => 'cancelled',
            self::REFUNDED => 'refunded',
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
