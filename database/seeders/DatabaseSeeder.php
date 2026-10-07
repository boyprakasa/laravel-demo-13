<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 kategori
        // Category::factory(5)->create();

        // Buat 10 penulis
        // Author::factory(10)->create();

        // Buat 25 buku dan asignkan penulis secara acak
        // Book::factory(25)->create()->each(function ($book) {
        //     $book->authors()->attach(
        //         Author::inRandomOrder()->limit(rand(1, 3))->pluck('id')
        //     );
        // });

        // Buat 15 anggota
        // Member::factory(15)->create();

        // Buat 30 pinjaman aktif
        Loan::factory(500)->create()->each(function ($loan) {
            // Set status berdasarkan tanggal
            if (Carbon::parse($loan->expected_return_date)->isPast()) {
                $loan->status = 'returned';
                // Parse tanggal terlebih dahulu ke Carbon sebelum menggunakan copy()
                $expectedReturnDate = Carbon::parse($loan->expected_return_date);
                $loan->actual_return_date = $expectedReturnDate->copy()->addDays(rand(-2, 5));
            }
            // Selalu hitung denda berdasarkan status dan tanggal saat ini
            $loan->fine = $loan->calculateFine();
            $loan->save();
        });

        // Buat 10 pinjaman yang sedang aktif
        Loan::factory(10)->create()->each(function ($loan) {
            $loan->loan_date = Carbon::instance(fake()->dateTimeBetween('-3 months', 'now'));
            $loan->expected_return_date = $loan->loan_date->copy()->addDays(14);
            $loan->actual_return_date = null;
            $loan->status = 'on_loan';
            $loan->fine = 0;
            $loan->save();
        });
    }
}
