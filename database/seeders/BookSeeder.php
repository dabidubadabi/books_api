<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['title' => 'Learning Laravel', 'author' => 'John Smith'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin'],
            ['title' => 'The Pragmatic Programmer', 'author' => 'David Thomas and Andrew Hunt'],
        ] as $book) {
            Book::firstOrCreate($book);
        }
    }
}
