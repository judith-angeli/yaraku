<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'forename',
        'surname'
    ];

    /**
     * An author can have multiple books
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

}
