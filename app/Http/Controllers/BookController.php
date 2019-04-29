<?php

namespace App\Http\Controllers;

use App\Events\BookSaved;
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
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'title_asc');

        $results = $this->search($search, $sort)
                        ->paginate(self::ITEMS_PER_PAGE);

        return view('books.index', ['books' => $results, 'search' => $search, 'sort' => $sort]);
    }

    /**
     * Stores a book and its author
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
        $book->title = $request->get('title');
        $book->save();

        event(new BookSaved($book, $request->get('forename'), $request->get('surname')));

        return redirect(route('books.index'))->with('success-message', $book->title . ' has been added');
    }

    /**
     * Update a book's author
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'forename' => 'required'
        ]);

        $book = Book::find($id);
        $authorId = $request->get('authorId');

        event(new BookSaved($book, $request->get('forename'), $request->get('surname'), $authorId));

        return redirect(url()->previous())->with('success-message', $book->title . ' has been updated');
    }

    /**
     * Deletes a book
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
     * Search for a book or author
     *
     * @param string $search
     * @param string $sort
     *
     * @return Builder
    */
    public function search(?string $search, string $sort = 'title_asc')
    {
        $books = new Book();

        list($sortBy, $sortOrder) = explode('_', $sort);

        $results = $books->getByTitleOrAuthor($search);

        return $books->sort($results, $sortBy, $sortOrder);
    }

    /**
     * Exports current list to a file (e.g. CSV, XML)
     *
     * @param Request $request
    */
    public function export(Request $request)
    {
        $request->validate([
            'fileType' => 'required',
            'toExport' => 'required'
        ]);

        $fileType = $request->input('fileType');
        $toExport = $request->input('toExport');
        $sort = $request->input('sort', 'title_asc');
        $search = $request->input('search', '');

        $dataBuilder = $this->search($search, $sort);

        $book = new Book();
        $fields = $book->getFields($toExport);
        $data = $dataBuilder->select($fields)
            ->get()
            ->toArray();

        $exportHelper = new ExportFileHelper($fileType, $data, 'books', $fields);
        $exportHelper->export();
    }
}