<?php

namespace Database\Factories;

use App\Core\Models\Language;
use App\Modules\Products\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'parent_id' => null,
            'language_id' => Language::factory(),
            'description' => fake()->sentence(8),
            'image' => fake()->imageUrl(640, 480, 'business', true),
        ];
    }
}
