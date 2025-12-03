<?php

namespace Database\Factories;

use App\Core\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'US Dollar',
                'Euro',
                'Saudi Riyal',
                'UAE Dirham',
                'Egyptian Pound',
                'British Pound',
            ]),
            'code' => fake()->unique()->currencyCode(),
        ];
    }
}
