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
                        <span class="authorName">{{ ucfirst($author->forename) }} {{ ucfirst($author->surname) }}</span>
                        @include('books.edit_author', ['book' => $book, 'author' => $author])
                    </div>
                @endforeach
            </td>
            <td class="col-md-2">
                <button class="btn btn-secondary btn-sm btnEditAuthor" data-bookid="{{$book->id}}" data-authorid="{{$author->id}}">
                    Edit
                </button>

                <form method="post" id="form_delete_{{ $book->id }}" class="d-inline" action="{{ route('books.destroy', $book->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm btnDelete" data-bookid="{{ $book->id }}"
                            data-booktitle="{{ $book->title }}">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>