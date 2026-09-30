<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'writer' => fake()->name(),
            'publication_year' => fake()->numberBetween(1990, 2025),
            'description' => fake()->paragraph(),
            'category_id' => Category::factory(),
        ];
    }
}
