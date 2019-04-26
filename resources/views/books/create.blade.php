@extends('layouts.app')

@section('meta-title', 'Book Listings')

@section('content')
    <form method="post" action="{{ route('books.store') }}">
        @csrf
        <label for="title">Book title:</label>
        <input type="text" name="title" />

        <label for="forename">Author forename:</label>
        <input type="text" name="forename" />

        <label for="surname">Author surname:</label>
        <input type="text" name="surname" />

        <input type="submit" value="Add" />
    </form>
@endsection