<?php

namespace App\Models;

use App\Events\BookSaved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title'];
    const SORTABLE_FIELDS = ['title', 'forename', 'surname', 'author'];

    /**
    * a book can have multiple authors
    */
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * @param string $keyword
     *
     * @return Illuminate\Database\Eloquent\Builder $results
    * */
    public function getByTitleOrAuthor(string $keyword = '')
    {
        $results = $this->select('books.id', 'book_id', 'author_id', 'title', 'forename', 'surname')
                        ->join('author_book', 'books.id', '=', 'author_book.book_id')
                        ->join('authors', 'authors.id', '=', 'author_book.author_id');

        if ($keyword) {
            $regexpKeyword = str_replace(' ', '|', $keyword);

            $results->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('forename', 'REGEXP', $regexpKeyword)
                ->orWhere('surname', 'REGEXP', $regexpKeyword);
        }

        return $results;
    }

    /**
     * @param Builder $builder
     * @param string $sortBy
     * @param string $sortOrder
     *
     * @return Builder $results
     * */
    public function sort(Builder $builder, $sortBy = 'title', $sortOrder = 'ASC')
    {
        if (!in_array(strtolower($sortBy), self::SORTABLE_FIELDS)) {
            $sortBy = 'title';
        }

        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            $sortOrder = 'ASC';
        }

        return $builder->orderBy($sortBy, $sortOrder);
    }
}
