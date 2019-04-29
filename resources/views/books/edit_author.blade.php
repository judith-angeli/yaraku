<form method="post" action="{{ route('books.update', $book->id) }}" class="frm-edit-author" style="display:none">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <input type="hidden" name="authorId" value="{{ $author->id }}" />
        <input type="text" name="forename" value="{{ $author->forename }}" placeholder="first name" />
        <input type="text" name="surname" value="{{ $author->surname }}" placeholder="last name" />
    </div>

    <button class="btn btn-primary btn-sm">Save</button>
    <button class="btn btn-outline-dark btn-sm btnCancelEditAuthor" >Cancel</button>
</form>