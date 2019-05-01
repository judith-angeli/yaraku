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
        $response = $this->post('/books', [
            'title' => 'Testing title',
            'forename' => 'Test forename',
            'surname' => 'Test surname'
        ]);

        $this->assertDatabaseHas('books', ['title' => 'Testing title']);
        $this->assertDatabaseHas('authors', ['forename' => 'Test forename', 'surname' => 'Test surname']);
        $this->assertDatabaseHas('author_book', ['book_id' => 1, 'author_id' => 1]);

        $this->post('/books', [
            'title' => 'New title',
            'forename' => 'Test forename',
            'surname' => 'Test surname'
        ]);

        $books = Book::all();
        foreach ($books as $book) {
            foreach ($book->authors as $author) {
                $this->assertEquals(1, $author->id);
                $this->assertDatabaseHas('author_book', ['book_id' => $book->id, 'author_id' => $author->id]);
                $this->assertDatabaseHas('author_book', ['book_id' => $book->id, 'author_id' => $author->id]);
            }
        };

        $response->assertStatus(302);
        $response->assertSessionHas('success-message');
    }

    public function testUpdateBookAuthor()
    {
        $book = factory(Book::class)->create(['title' => 'Tom and Jerry']);
        $author = factory(Author::class)->create(['forename' => 'Tom', 'surname' => 'Cat']);
        $book->authors()->attach($author);

        $response = $this->put('/books/' . $book->id, [
            'forename' => 'Jerry',
            'surname' => 'Mouse',
            'authorId' => $author->id
        ]);

        $updatedBook = Book::find($book->id);

        // test that the pivot table doesn't have the old relationship anymore
        $this->assertDatabaseMissing('author_book', ['book_id' => $book->id, 'author_id' => $author->id]);

        // test that the pivot table stores the new relationship
        $this->assertDatabaseHas('author_book', ['book_id' => $book->id, 'author_id' => $updatedBook->authors()->first()->id]);

        // test that Jerry Mouse is existing in authors table
        $this->assertDatabaseHas('authors', ['forename' => 'Jerry', 'surname' => 'Mouse']);

        $response->assertStatus(302);
        $response->assertSessionHas('success-message');
    }

    public function testDeleteBook()
    {
        $book = factory(Book::class)->create(['title' => 'Tom and Jerry']);
        $author = factory(Author::class)->create(['forename' => 'Tom', 'surname' => 'Cat']);
        $book->authors()->attach($author);

        $response = $this->delete('/books/' . $book->id);

        // test that the book has been deleted in the books table
        $this->assertDatabaseMissing('books', ['title' => 'Tom and Jerry']);

        // test that the relationship is deleted in the pivot table
        $this->assertDatabaseMissing('author_book', ['book_id' => $book->id, 'author_id' => $author->id]);

        // test that author has not been deleted. We are deleting a book and not the author
        $this->assertDatabaseHas('authors', ['forename' => 'Tom', 'surname' => 'Cat']);

        $response->assertStatus(302);
        $response->assertSessionHas('success-message');
    }
}
