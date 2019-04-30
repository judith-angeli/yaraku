<?php

namespace App\Listeners;

use App\Events\BookSaved;
use App\Models\Author;

class CreateAuthorIfNotExists
{
    /**
     * Inserts an author if it doesn't exist in authors table
     * then adds/updates `author_book` pivot table to create the relationship
     *
     * @param BookSaved $event
     */
    public function handle(BookSaved $event)
    {
        $author = Author::firstOrCreate([
            'forename' => $event->authorData['forename'],
            'surname' => $event->authorData['surname']
        ]);

        $author->save();

        if ($event->authorId) {
            $event->book->authors()->updateExistingPivot($event->authorId, ['author_id' => $author->id, 'book_id' => $event->book->id]);
        } else {
            $event->book->authors()->attach($author);
        }
    }
}
