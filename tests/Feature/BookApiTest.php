<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_hello_endpoint_returns_the_welcome_json(): void
    {
        $this->getJson('/api/hello')
            ->assertOk()
            ->assertExactJson([
                'message' => 'Welcome to my API',
                'student' => 'DBjhane',
            ]);
    }

    public function test_books_can_be_created_listed_retrieved_updated_and_deleted(): void
    {
        $createdBooks = collect([
            ['title' => 'Learning Laravel', 'author' => 'John Smith'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin'],
            ['title' => 'The Pragmatic Programmer', 'author' => 'David Thomas and Andrew Hunt'],
        ])->map(function (array $book) {
            return $this->postJson('/api/books', $book)
                ->assertCreated()
                ->assertJsonStructure(['id', 'title', 'author', 'created_at', 'updated_at'])
                ->json();
        });

        $this->getJson('/api/books')
            ->assertOk()
            ->assertJsonCount(3);

        $book = $createdBooks->first();

        $this->getJson("/api/books/{$book['id']}")
            ->assertOk()
            ->assertJsonPath('title', 'Learning Laravel');

        $this->putJson("/api/books/{$book['id']}", ['title' => 'Laravel in Practice'])
            ->assertOk()
            ->assertJsonPath('title', 'Laravel in Practice')
            ->assertJsonPath('author', 'John Smith');

        $this->deleteJson("/api/books/{$book['id']}")
            ->assertNoContent();

        $this->getJson("/api/books/{$book['id']}")
            ->assertNotFound()
            ->assertJsonStructure(['message']);
    }

    public function test_create_requires_a_title_and_author(): void
    {
        $this->postJson('/api/books', ['title' => 'Incomplete'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['author']);
    }

    public function test_update_requires_at_least_one_book_field(): void
    {
        $book = Book::create(['title' => 'Learning Laravel', 'author' => 'John Smith']);

        $this->putJson("/api/books/{$book->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('message', 'At least one of title or author is required.');
    }
}
