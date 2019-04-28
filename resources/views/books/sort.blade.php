<form method="get" id="form_sort" class="form-inline ml-3 mb-2" action="{{ route('books.index') }}">
    <div class="form-group row">
        <input type="hidden" name="search" value="{{ $search }}"/>

        <label class="mr-2" >Order by:</label>
        <select class="custom-select" name="sort" id="sort_by">
            <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
            <option value="title_desc" {{ $sort == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
            <option value="forename_asc" {{ $sort == 'forename_asc' ? 'selected' : '' }}>Author A-Z</option>
            <option value="forename_desc" {{ $sort == 'forename_desc' ? 'selected' : '' }}>Author Z-A</option>
        </select>
    </div>
</form>
