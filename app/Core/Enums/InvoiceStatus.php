<?php

namespace App\Core\Enums;

enum InvoiceStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
    case PENDING = 'pending';

    public static function values(): array
    {
        return array_map(fn(InvoiceStatus $status) => $status->value, self::cases());
    }

    public function getValue(): string
    {
        return match ($this) {
            self::UNPAID => 'unpaid',
            self::PAID => 'paid',
            self::OVERDUE => 'overdue',
            self::PENDING => 'pending',
        };
    }

    public static function getAllKeyValues(): array
    {
        return array_combine(
            array_map(fn($case) => $case->getValue(), self::cases()),
            array_map(fn($case) => __($case->getValue()), self::cases())
        );
    }
}