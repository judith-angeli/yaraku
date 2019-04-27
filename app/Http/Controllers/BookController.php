<?php

namespace App\Http\Controllers;

use App\Helpers\Export\ExportFileHelper;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    /**
     * Display a listing of books and its authors
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ?? '';
        $sort = $request->get('sort') ?? 'title_asc';

        $results = $this->search($search, $sort)
                        ->paginate(self::ITEMS_PER_PAGE);

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

    /**
     * @param string $search
     * @param string $sort
     *
     * @return Builder
    */
    public function search(string $search, string $sort)
    {
        $books = new Book();

        list($sortBy, $sortOrder) = explode('_', $sort);

        $results = $books->getByTitleOrAuthor($search);

        return $books->sort($results, $sortBy, $sortOrder);
    }

    /**
     * @param string $toExport = title_author | title | author
     * @param string $file = csv | xml
     * @param string $sort
     * @param string $search
     *
     * @return
    */
    public function export(string $toExport, string $file, string $sort = 'title_asc', string $search = '')
    {
        if (!$file) {
            return redirect(route('books.index'))->with('error-message', 'No file selected');
        }

        $dataBuilder = $this->search($search, $sort);

        $exportHelper = new ExportFileHelper($file, $toExport, $dataBuilder, 'books');
        $exportHelper->export();

        return redirect(route(Route::currentRouteName()));
    }
}