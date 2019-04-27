@extends('layouts.app')

@section('meta-title', 'Book Listings')

@section('content')
    @if (\Session::has('success-message'))
        @component('components.alert',
            [
                'type' => 'success',
                'message' => \Session::get('success-message')
            ]
        )
        @endcomponent
    @endif

    <a href="/books/create">Add book</a>

    @component('components.search',
                [
                    'label' => 'Search:',
                    'placeholder' => 'Search for a book or author',
                    'sort' => $sort
                ]
            )
    @endcomponent
    <a href="/books">Reset</a>

    <form method="get" id="form_sort" action="{{ route(Route::currentRouteName()) }}">
        @if (isset($search))
            <input type="hidden" name="search" value="{{ $search }}"/>
        @endif

        <label>Sort by:</label>

        <select name="sort" id="sort_by">
            <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
            <option value="title_desc" {{ $sort == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
            <option value="forename_asc" {{ $sort == 'forename_asc' ? 'selected' : '' }}>Author A-Z</option>
            <option value="forename_desc" {{ $sort == 'forename_desc' ? 'selected' : '' }}>Author Z-A</option>
        </select>
    </form>

    <script type="text/javascript">
        $('#sort_by').change(function () {
            $("#form_sort").submit();
        });
    </script>

    <table>
        <tr>
            <th>Title</th>
            <th>Authors</th>
            <th>Delete</th>
        </tr>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>
                    @foreach($book->authors as $author)
                        {{ $author->forename }} {{ $author->surname }}
                        <form method="post" action="{{ route('authors.update', $author->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="forename" value="{{ $author->forename }}" />
                            <input type="text" name="surname" value="{{ $author->surname }}" />
                            <button>Edit</button>
                        </form>
                        <br />
                    @endforeach
                </td>
                <td>
                    <form method="post" action="{{ route('books.destroy', $book->id) }}">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $books->appends(request()->except('page'))->links() }}

@endsection