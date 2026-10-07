<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'book_id' => Book::factory(),
            'loan_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'expected_return_date' => fake()->dateTimeBetween('-5 months', 'now'),
            'actual_return_date' => fake()->optional()->dateTimeBetween('-4 months', 'now'),
            'status' => $this->faker->randomElement(['on_loan', 'returned', 'overdue']),
            'fine' => $this->faker->optional()->randomFloat(2, 0, 50000),
        ];
    }
}
