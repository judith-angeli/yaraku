@extends('layouts.app')
@section('meta-title', 'Book Listings')

@section('javascripts')
    @parent
    <script src="{{ asset('js/book.js') }}"></script>
@endsection

@section('content')

    <div class="row">
        <h1>Books</h1>
    </div>

    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->all()])
    @endif

    @if (\Session::has('success-message'))
        @include('components.alert', ['type' => 'success', 'message' => \Session::get('success-message')])
    @endif

    <div class="row">
        <div class="col">
            @include('components.search', [
                'action' => route('books.index'),
                'placeholder' => 'Search for a book or author',
                'sort' => $sort
            ])
        </div>
        <div class="float-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addBookModal">Add book</button>
        </div>
    </div>

    <hr />

    <div class="row">
        Found {{ $books->total() }} results {{ $search ? ' for ' . $search : '' }}
    </div>

    <div class="row mt-3">
        <div class="d-block w-100">
            <div class="float-left">
                @include('books.sort', ['search' => $search, 'sort' => $sort])
            </div>

            <div class="float-right mr-5">
                <div class="row form-inline ">
                    @include('books.export', ['search' => $search, 'sort' => $sort])
                </div>
            </div>
        </div>

        @include('books.listings', ['books' => $books])
    </div>

    {{ $books->appends(request()->except('page'))->links() }}

    @include('books.create')
@endsection