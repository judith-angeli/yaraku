@extends('layouts.app')
@section('meta-title', 'Book Listings')
@section('content')

    <div class="row">
        <h1>Books</h1>
    </div>

    @if (\Session::has('success-message'))
        @component('components.alert', ['type' => 'success', 'message' => \Session::get('success-message')])
        @endcomponent
    @endif

    <div class="row">
        <div class="col">
            @component('components.search', [
                'action' => route('books.index'),
                'placeholder' => 'Search for a book or author',
                'sort' => $sort
            ])
            @endcomponent
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="/books/create" data-toggle="modal" data-target="#addBookModal">Add book</a>
        </div>
    </div>

    <hr />

    <div class="row">
        Found {{ $books->total() }} results {{ $search ? ' for ' . $search : '' }}
    </div>

    <div class="row mt-3">
        <div class="d-block w-100">
            <div class="float-left">
                @component('books.sort', ['search' => $search, 'sort' => $sort])
                @endcomponent
            </div>

            <div class="float-right mr-5">
                <div class="row form-inline ">
                    @component('books.export', ['search' => $search, 'sort' => $sort])
                    @endcomponent
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($books as $book)
                <tr>
                    <td class="col-md-4">{{ $book->title }}</td>
                    <td class="col-md-4">
                        @foreach($book->authors as $author)
                            <div id="b{{$book->id}}_a{{$author->id}}">
                                <span class="authorName">{{ $author->forename }} {{ $author->surname }}</span>
                                @component('books.edit_author', ['book' => $book, 'author' => $author])
                                @endcomponent
                            </div>
                        @endforeach
                    </td>
                    <td class="col-md-2">
                        <button class="btn btn-secondary btn-sm btnEditAuthor" data-bookid="{{$book->id}}" data-authorid="{{$author->id}}">
                            Edit
                        </button>

                        <form method="post" id="form_delete" class="d-inline" action="{{ route('books.destroy', $book->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{ $books->appends(request()->except('page'))->links() }}

    @component('books.create')
    @endcomponent

    <script type="text/javascript">
        $(document).ready(function() {
            $('#sort_by').change(function () {
                $("#form_sort").submit();
            });
        });

        $('.btnEditAuthor').on('click', function() {
            let bookId = $(this).data('bookid');
            let authorId = $(this).data('authorid');
            let editContainer = "#b" + bookId + "_a" + authorId;

            $(".frm-edit-author").hide();
            $(editContainer + " form").show();
            $(editContainer + " span.authorName").hide();
        });

        $('.btnCancelEditAuthor').on('click', function() {
            event.preventDefault();

            $(".frm-edit-author").hide();
            $("span.authorName").show();

            return false;
        });
    </script>

@endsection

