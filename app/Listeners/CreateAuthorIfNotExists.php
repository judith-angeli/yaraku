<?php

namespace App\Listeners;

use App\Events\BookSaved;
use App\Models\Author;

class CreateAuthorIfNotExists
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookSaved  $event
     * @return void
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
