$(document).ready(function() {
    $('#sort_by').change(function () {
        $("#form_sort").submit();
    });

    $('.btnEditAuthor').on('click', function() {
        let bookId = $(this).data('bookid');
        let authorId = $(this).data('authorid');
        let editContainer = "#b" + bookId + "_a" + authorId;

        $(".frm-edit-author").hide();
        $(editContainer + " form").show();
        $(editContainer + " span.authorName").hide();
    });

    $('.btnCancelEditAuthor').on('click', function() {
        event.preventDefault();

        $(".frm-edit-author").hide();
        $("span.authorName").show();

        return false;
    });

    $('.btnDelete').on('click', function() {
        event.preventDefault();

        let bookTitle = $(this).data('booktitle');

        if (confirm("Are you sure you want to delete \"" + bookTitle + "\"?")) {
            let bookId = $(this).data('bookid');
            $("#form_delete_" + bookId).submit();

        }

        return false;
    });

});