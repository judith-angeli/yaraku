<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Book::class, 20)->create();

        factory(\App\Models\Author::class, 10)->create();

        $authors = \App\Models\Author::all();

        App\Models\Book::all()->each(function ($book) use ($authors) {
            $book->authors()->attach(
                $authors->random(1)->pluck('id')->toArray()
            );
        });
    }
}
