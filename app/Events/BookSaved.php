<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Book;

class BookSaved
{
    use SerializesModels;

    public $book;
    public $authorData;
    public $authorId;

    /**
     * Create a new event instance.
     *
     * @param Book $book
     * @param array $authorData
     */
    public function __construct(Book $book, $authorForename = '', $authorSurname = '', $authorId = null)
    {
        $this->book = $book;
        $this->authorId = $authorId;
        $this->authorData = [
            'forename' => $authorForename,
            'surname' => $authorSurname
        ];
    }
}
