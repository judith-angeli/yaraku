<form method="post" action="{{ route('authors.update', $author->id) }}" class="frm-edit-author" style="display:none">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <input type="text" name="forename" value="{{ $author->forename }}" placeholder="forename" />
        <input type="text" name="surname" value="{{ $author->surname }}" placeholder="surname" />
    </div>

    <button class="btn btn-primary btn-sm">Save</button>
    <button class="btn btn-outline-dark btn-sm btnCancelEditAuthor" >Cancel</button>
</form>