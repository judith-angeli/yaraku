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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(self::ITEMS_PER_PAGE);

        return view('books.index', ['books' => $books]);
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

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->get('search') ?? '';
        $sortBy = $request->get('sort')['by'] ?? '';
        $sortOrder = $request->get('sort')['order'] ?? '';

        $books = new Book();

        if ($keyword) {
            $results = $books->searchByBookOrAuthor($keyword, self::ITEMS_PER_PAGE, $sortBy, $sortOrder);

            return view('books.index', ['books' => $results]);
        }

        return $this->index();
    }
}