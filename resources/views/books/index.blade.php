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
                    'action' => route('books.search'),
                    'label' => 'Search:',
                    'placeholder' => 'Search for a book or author'
                ]
            )
    @endcomponent



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
    {{ $books->links()  }}
@endsection