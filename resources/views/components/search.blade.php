<form method="get" action="{{ route('books.index') }}">
    <label for="search">{{ $label }} </label>
    <input type="text" name="search" placeholder="{{ $placeholder }}"/>
    <input type="hidden" name="sortBy" value="{{ $sort }}"/>
</form>