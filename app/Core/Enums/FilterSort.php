<?php

namespace App\Core\Enums;
use Illuminate\Database\Eloquent\Builder;
enum FilterSort: string
{
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case NEWEST = 'newest';
    case OLDEST = 'oldest';


    public function get(Builder $query): Builder
    {
        return match ($this) {
            self::PRICE_ASC => $query->orderBy('price', 'asc'),
            self::PRICE_DESC => $query->orderBy('price', 'desc'),
            self::NEWEST => $query->orderBy('created_at', 'desc'),
            self::OLDEST => $query->orderBy('created_at', 'asc'),
        };
    }

    public static function getEnum(string $value): self
    {
        return match ($value) {
            FilterSort::PRICE_ASC->value => FilterSort::PRICE_ASC,
            FilterSort::PRICE_DESC->value => FilterSort::PRICE_DESC,
            FilterSort::NEWEST->value => FilterSort::NEWEST,
            FilterSort::OLDEST->value => FilterSort::OLDEST,
        };
    }

    public static function values(): array
    {
        return array_map(fn(FilterSort $sort) => $sort->value, self::cases());
    }
    public function getValue(): string
    {
        return match ($this) {
            self::PRICE_ASC => 'price_asc',
            self::PRICE_DESC => 'price_desc',
            self::NEWEST => 'newest',
            self::OLDEST => 'oldest',
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