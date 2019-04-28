<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Book;

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
    public function __construct(Book $book, $authorForename = '', $authorSurname = '')
    {
        $this->book = $book;
        $this->authorData = [
            'forename' => $authorForename,
            'surname' => $authorSurname
        ];
    }
}
