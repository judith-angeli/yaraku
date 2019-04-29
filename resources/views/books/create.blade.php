@extends('components.modal')

@section('modal-title', 'Add book')
@section('modal-id', 'addBookModal')

@section('modal-body')
    <form method="post" action="{{ route('books.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Book title:</label>
            <input class="form-control" type="text" name="title"/>
        </div>

        <div class="form-group">
            <label for="forename">Author first name:</label>
            <input class="form-control" type="text" name="forename"/>
        </div>

        <div class="form-group">
            <label for="surname">Author last name:</label>
            <input class="form-control" type="text" name="surname"/>
        </div>

        <input class="btn btn-primary float-right" type="submit" value="Save" />
    </form>
@endsection