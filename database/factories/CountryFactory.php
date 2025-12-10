<?php

namespace Database\Factories;

use App\Core\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'name' => fake()->country(),
            'code' => fake()->unique()->countryCode(),
        ];
    }
}
