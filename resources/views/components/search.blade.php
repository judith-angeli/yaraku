<form method="get" action="{{ $action }}">
    <div class="form-group row">
        <input type="hidden" name="sort" value="{{ $sort }}"/>
        <input class="form-control col-sm-5" type="text" name="search" placeholder="{{ $placeholder }}"/>
        <button type="submit" class="btn btn-secondary ml-1">Search</button>
    </div>
</form>