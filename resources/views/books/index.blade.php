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
            <a class="btn btn-primary" href="{{route('books.create')}}" data-toggle="modal" data-target="#addBookModal">Add book</a>
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

        @component('books.listings', ['books' => $books])
        @endcomponent
    </div>

    {{ $books->appends(request()->except('page'))->links() }}

    @component('books.create')
    @endcomponent
@endsection