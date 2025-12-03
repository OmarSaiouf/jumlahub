<?php

namespace Database\Factories;

use App\Core\Enums\UserRole;
use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\RecoveryCode;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Users\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countryFactory = Country::factory();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'language_id' => Language::factory(),
            'currency_id' => Currency::factory(),
            'country_id' => $countryFactory,
            'city_id' => City::factory()->for($countryFactory),
            'address' => fake()->address(),
            'role' => UserRole::USER,
            'image' => fake()->imageUrl(300, 300, 'people', true),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Use a specific password (plain text).
     */
    public function withPassword(string $password): static
    {
        return $this->state(fn () => [
            'password' => Hash::make($password),
        ]);
    }

    /**
     * Seed user as an admin account.
     */
    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => UserRole::ADMIN,
        ]);
    }

    /**
     * Seed user with two-factor authentication data (encrypted secret + recovery codes).
     */
    public function withTwoFactor(bool $confirmed = true): static
    {
        return $this->state(function () use ($confirmed) {
            $provider = app(TwoFactorAuthenticationProvider::class);
            $secret = $provider->generateSecretKey();

            $recoveryCodes = collect(range(1, 8))
                ->map(fn () => RecoveryCode::generate())
                ->values()
                ->toJson();

            return [
                'two_factor_secret' => Fortify::currentEncrypter()->encrypt($secret),
                'two_factor_recovery_codes' => Fortify::currentEncrypter()->encrypt($recoveryCodes),
                'two_factor_confirmed_at' => $confirmed ? now() : null,
            ];
        });
    }
}
