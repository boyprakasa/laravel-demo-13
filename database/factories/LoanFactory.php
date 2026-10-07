<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
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
            'member_id' => Member::inRandomOrder()->first()->id,
            'book_id' => Book::inRandomOrder()->first()->id,
            'loan_date' => fake()->dateTimeBetween('-8 months', '-2 months'),
            'expected_return_date' => function (array $attributes) {
                return Carbon::parse($attributes['loan_date'])
                    ->addDays(14)
                    ->toDateString();
            },
            'actual_return_date' => function (array $attributes) {
                // 70% kemungkinan telat
                if (rand(1, 10) <= 7) {
                    return Carbon::parse($attributes['expected_return_date'])
                        ->addDays(rand(1, 10))
                        ->toDateString();
                }
                // 30% kemungkinan tepat waktu atau early return
                return Carbon::parse($attributes['expected_return_date'])
                    ->subDays(rand(0, 5))
                    ->toDateString();
            },
            'status' => function (array $attributes) {
                return $attributes['actual_return_date'] === null ? 'on_loan' : 'returned';
            },
        ];
    }

    /**
     * Configure the model factory after creation.
     * Hitung denda berdasarkan logika yang sudah ada di model Loan.
     */
    public function configure()
    {
        return $this->afterMaking(function (Loan $loan) {
            $loan->fine = $loan->calculateFine();
        });
    }
}
