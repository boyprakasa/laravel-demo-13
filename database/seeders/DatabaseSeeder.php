<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 5 kategori
        Category::factory(5)->create();

        // Buat 10 penulis
        Author::factory(10)->create();

        // Buat 25 buku dan asignakan penulis secara acak
        Book::factory(25)->create()->each(function ($book) {
            // Pilih 1-3 penulis secara acak untuk setiap buku
            $book->authors()->attach(
                Author::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });
    }
}
