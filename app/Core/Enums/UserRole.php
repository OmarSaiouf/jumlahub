<?php

namespace App\Core\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function values(): array
    {
        return array_map(fn(UserRole $role) => $role->value, self::cases());
    }
    public function getValue(): string
    {
        return match ($this) {

            self::ADMIN => 'admin',
            self::USER => 'user',

        };
    }
    public static function labels(): array
    {
        return [
            self::ADMIN->value => 'Administrator',
            self::USER->value => 'User',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value];
    }

    public static function getAllKeyValues(): array
    {
        return array_combine(
            array_map(fn($case) => $case->getValue(), self::cases()),
            array_map(fn($case) => ucfirst($case->getValue()), self::cases())
        );
    }
}
