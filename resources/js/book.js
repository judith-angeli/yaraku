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

        if (confirm("Are you sure you want to delete this book")) {
            $("#form_delete").submit();

        }

        return false;
    });

});