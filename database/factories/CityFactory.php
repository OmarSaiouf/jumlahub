<?php

namespace Database\Factories;

use App\Core\Models\City;
use App\Core\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'name' => fake()->city(),
            'country_id' => Country::factory(),
        ];
    }
}
