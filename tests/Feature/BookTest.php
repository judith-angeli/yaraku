<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateBook()
    {
        $this->post('/books', [
            'title' => 'Testing title',
            'forename' => 'Test forename',
            'surname' => 'Test surname'
        ]);

        $this->assertDatabaseHas('books', ['title' => 'Testing title']);
        $this->assertDatabaseHas('authors', ['forename' => 'Test forename']);
        $this->assertDatabaseHas('authors', ['surname' => 'Test surname']);
        $this->assertDatabaseHas('author_book', ['book_id' => 1]);
        $this->assertDatabaseHas('author_book', ['author_id' => 1]);
    }
}
