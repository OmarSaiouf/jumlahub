<?php

namespace Database\Factories;

use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(10, 200);
        $quantitySold = fake()->numberBetween(0, $quantity);
        $countryFactory = Country::factory();

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'unit' => fake()->randomElement(['piece', 'service', 'bundle', 'license']),
            'quantity' => $quantity,
            'quantity_sold' => $quantitySold,
            'discount' => fake()->numberBetween(0, 30),
            'is_quantity_finished' => $quantitySold >= $quantity,
            'category_id' => Category::factory(),
            'language_id' => Language::factory(),
            'image' => fake()->imageUrl(640, 480, 'technics', true),
            'country_id' => $countryFactory,
            'city_id' => City::factory()->for($countryFactory),
            'currency_id' => Currency::factory(),
        ];
    }
}
