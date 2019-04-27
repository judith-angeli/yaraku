<?php

namespace App\Http\Controllers;

use App\Events\BookSaved;
use App\Http\Models\Author;
use App\Http\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ?? '';
        $sort = $request->get('sort') ?? 'title_asc';

        $books = new Book();

        list($sortBy, $sortOrder) = explode('_', $sort);

        $results = $books->getByBookOrAuthor($search);
        $results = $books->sort($results, $sortBy, $sortOrder);
        $results = $results->paginate(self::ITEMS_PER_PAGE);

        return view('books.index', ['books' => $results, 'search' => $search, 'sort' => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'forename' => 'required'
        ]);

        $book = new Book();

        if ($book->addBook($request->input())) {
            return redirect(route('books.index'))->with('success-message', $book->title . ' has been added');
        } else {
            return redirect(route('books.index'))->with('error-message', $book->title . ' already exist');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->authors()->detach();
        $book->delete();

        return redirect(route('books.index'))->with('success-message', $book->title . ' has been deleted');
    }
}