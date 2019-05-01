<?php

namespace Tests\Unit;

use App\Models\{Book, Author};
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookModelTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllBooks()
    {
        $this->seed('BooksTableSeeder');
        $book = new Book();
        $this->assertInstanceOf(Builder::class, $book->getByTitleOrAuthor());
        $this->assertEquals(20, $book->getByTitleOrAuthor()->get()->count());
    }

    public function testGetByTitleOrAuthor()
    {
        $book = factory(Book::class)->create(['title' => 'Tom and Jerry']);
        $author = factory(Author::class)->create(['forename' => 'Tom', 'surname' => 'Cat']);
        $book->authors()->attach($author);

        $book = factory(Book::class)->create(['title' => 'Cats just wanna have fun']);
        $author = factory(Author::class)->create(['forename' => 'Tom', 'surname' => 'Cat']);
        $book->authors()->attach($author);

        $book = factory(Book::class)->create(['title' => 'Tom cat stories']);
        $author = factory(Author::class)->create(['forename' => 'Jerry', 'surname' => 'Mouse']);
        $book->authors()->attach($author);

        // should Builder class
        $this->assertInstanceOf(Builder::class, $book->getByTitleOrAuthor('Tom'));

        // should return all 3 data input above
        $resultsTom = $book->getByTitleOrAuthor('Tom')->select('title', 'forename', 'surname')->get()->toArray();
        $this->assertEquals(3, count($resultsTom));
        $this->assertContains(['title' => 'Tom and Jerry', 'forename' => 'Tom', 'surname' => 'Cat'], $resultsTom);
        $this->assertContains(['title' => 'Cats just wanna have fun', 'forename' => 'Tom', 'surname' => 'Cat'], $resultsTom);
        $this->assertContains(['title' => 'Tom cat stories', 'forename' => 'Jerry', 'surname' => 'Mouse'], $resultsTom);

        // should return 2 data input above
        $resultsJerry = $book->getByTitleOrAuthor('Jerry')->select('title', 'forename', 'surname')->get()->toArray();
        $this->assertEquals(2, count($resultsJerry));
        $this->assertContains(['title' => 'Tom and Jerry', 'forename' => 'Tom', 'surname' => 'Cat'], $resultsJerry);
        $this->assertContains(['title' => 'Tom cat stories', 'forename' => 'Jerry', 'surname' => 'Mouse'], $resultsJerry);
        $this->assertNotContains(['title' => 'Cats just wanna have fun', 'forename' => 'Tom', 'surname' => 'Cat'], $resultsJerry);
    }

    public function testBookSortByTitleAsc()
    {
        $this->seed('BooksTableSeeder');

        $builderResult = Book::limit(5)->offset(5);

        $book = new Book();
        $res = $book->sort($builderResult, 'title', 'ASC')->get()->toArray();
        $books = array_column($res, 'title');
        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) <= 0);
        }
    }

    public function testBookSortByTitleDesc()
    {
        $this->seed('BooksTableSeeder');

        $builderResult = Book::limit(5)->offset(5);

        $book = new Book();
        $res = $book->sort($builderResult, 'title', 'DESC')->get()->toArray();
        $books = array_column($res, 'title');

        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) >= 0);
        }
    }

    public function testBookSortByAuthorForenameAsc()
    {
        $this->seed('BooksTableSeeder');

        $book = new Book();
        $builderResult = $book->getByTitleOrAuthor()->limit(5)->offset(5);
        $res = $book->sort($builderResult, 'forename', 'ASC')->get()->toArray();
        $books = array_column($res, 'forename');

        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) <= 0);
        }
    }

    public function testBookSortByAuthorForenameDesc()
    {
        $this->seed('BooksTableSeeder');

        $book = new Book();
        $builderResult = $book->getByTitleOrAuthor()->limit(5)->offset(5);
        $res = $book->sort($builderResult, 'forename', 'DESC')->get()->toArray();
        $books = array_column($res, 'forename');

        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) >= 0);
        }
    }

    public function testBookSortByAuthorSurnameAsc()
    {
        $this->seed('BooksTableSeeder');

        $book = new Book();
        $builderResult = $book->getByTitleOrAuthor()->limit(5)->offset(5);
        $res = $book->sort($builderResult, 'surname', 'ASC')->get()->toArray();
        $books = array_column($res, 'surname');

        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) <= 0);
        }
    }

    public function testBookSortByAuthorSurnameDesc()
    {
        $this->seed('BooksTableSeeder');

        $book = new Book();
        $builderResult = $book->getByTitleOrAuthor()->limit(5)->offset(5);
        $res = $book->sort($builderResult, 'surname', 'DESC')->get()->toArray();
        $books = array_column($res, 'surname');

        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) >= 0);
        }
    }

    public function testBookSortInvalidInputDefaultToTitleASC()
    {
        $this->seed('BooksTableSeeder');

        $builderResult = Book::limit(5)->offset(5);

        $book = new Book();
        $res = $book->sort($builderResult, 'invalid', 'invalid')->get()->toArray();
        $books = array_column($res, 'title');

        for ($i = 0; $i < count($books) - 1; $i++) {
            $this->assertTrue(strcasecmp($books[$i], $books[$i + 1]) <= 0);
        }
    }

    public function testGetFields()
    {
        $book = new Book();

        $this->assertEquals(['title'], $book->getFields('title'));

        $this->assertEquals(['forename', 'surname'], $book->getFields('author'));

        $this->assertEquals(['title', 'forename', 'surname'], $book->getFields('title_author'));

        $this->assertEquals(['books.id', 'book_id', 'author_id', 'title', 'forename', 'surname'],
            $book->getFields('invalid'));

        $this->assertEquals(['books.id', 'book_id', 'author_id', 'title', 'forename', 'surname'],
            $book->getFields());
    }
}
