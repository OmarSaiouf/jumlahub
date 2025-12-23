<?php

namespace App\Core\Enums;

use Illuminate\Database\Eloquent\Builder;
enum FilterStatus: string
{
    case Available = 'available';
    case Finished = 'finished';
    case Discount = 'discount';


    public function get(Builder $query): Builder
    {
        return match ($this) {
            self::Available => $query->where('quantity', '>', 0),
            self::Finished => $query->where('is_quantity_finished', true),
            self::Discount => $query->whereNotNull('discount'),
        };
    }

    public static function getEnum(string $value): self
    {
        return match ($value) {
            FilterStatus::Available->value => FilterStatus::Available,
            FilterStatus::Finished->value => FilterStatus::Finished,
            FilterStatus::Discount->value => FilterStatus::Discount,
        };
    }
    public static function values(): array
    {
        return array_map(fn(FilterStatus $status) => $status->value, self::cases());
    }

    public function getValue(): string
    {
        return match ($this) {
            self::Available => 'available',
            self::Finished => 'finished',
            self::Discount => 'discount',
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