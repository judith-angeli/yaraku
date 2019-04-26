<form method="get" action="{{ route('books.search') }}">
    <label for="search">{{ $label }} </label>
    <input type="text" name="search" placeholder="{{ $placeholder }}"/>

</form>