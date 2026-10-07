<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 kategori
        Category::factory(5)->create();

        // Buat 10 penulis
        Author::factory(10)->create();

        // Buat 25 buku dan asignkan penulis secara acak
        Book::factory(25)->create()->each(function ($book) {
            $book->authors()->attach(
                Author::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });

        // Buat 15 anggota
        Member::factory(15)->create();
    }
}
