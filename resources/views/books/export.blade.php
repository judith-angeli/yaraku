<form method="get" action=" {{ route('books.export') }}">
    @csrf
    <input type="hidden" name="search" value="{{ $search }}"/>
    <input type="hidden" name="sort" value="{{ $sort }}"/>

    <select class="custom-select mr-1" name="file">
        <option value="csv">CSV</option>
        <option value="xml">XML</option>
    </select>

    <select class="custom-select mr-1" name="toExport">
        <option value="title_author" selected>Title and author</option>
        <option value="title">Title</option>
        <option value="author">Author</option>
    </select>

    <button type="submit" class="btn btn-secondary">Export</button>
</form>
