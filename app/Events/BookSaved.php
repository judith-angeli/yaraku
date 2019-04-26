<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Http\Models\Book;

class BookSaved
{
    use SerializesModels;

    public $book;
    public $authorData;

    /**
     * Create a new event instance.
     *
     * @param Book $book
     * @param array $authorData
     */
    public function __construct(Book $book, $authorData = [])
    {
        $this->book = $book;
        $this->authorData = $authorData;
    }
}
