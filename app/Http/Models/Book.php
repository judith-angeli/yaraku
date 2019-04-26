<?php

namespace App\Http\Models;

use App\Events\BookSaved;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title'];

    /**
    * a book can have multiple authors
    */
    public function authors()
    {
    	return $this->belongsToMany(Author::class);
    }

    /**
     * @param array $data
     * @return bool
     * */
    public function addBook($data = []) : bool
    {
        if ($this->where('title', $data['title'])->doesntExist()) {

            $this->title = $data['title'];

            $this->save();

            $authorData = [
                'forename' => $data['forename'],
                'surname' => $data['surname']
            ];

            event(new BookSaved($this, $authorData));

            return true;
        }

        return false;
    }

    /**
     * @param string $keyword
     * @param int $pages
     *
     * @return Illuminate\Database\Eloquent\Collection $results
    * */
    public function searchByBookOrAuthor(string $keyword = '', int $pages = 10)
    {
        $regexpKeyword = str_replace(' ', '|', $keyword);

        $results = $this->whereHas('authors', function($query) use ($keyword, $regexpKeyword) {
                        $query->where('forename', 'REGEXP', $regexpKeyword)
                            ->orWhere('surname', 'REGEXP', $regexpKeyword);
                    })->orWhere('title', 'LIKE', '%' . $keyword . '%')->paginate($pages);
        $results->appends(['search' => $keyword]);

        return $results;
    }
}
