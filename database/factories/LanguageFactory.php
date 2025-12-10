<?php

namespace Database\Factories;

use App\Core\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Language>
 */
class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        $languageName = fake()->randomElement([
            'English',
            'Arabic',
            'French',
            'Spanish',
            'German',
            'Turkish',
            'Indonesian',
            'Hindi',
        ]);

        return [
            'name' => $languageName,
            'code' => fake()->unique()->languageCode(),
        ];
    }
}
