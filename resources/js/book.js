
$( document ).ready(function() {
    $('#sort_by').change(function () {
        $("#form_sort").submit();
    });
});

function deleteBook()
{
    if (confirm("Are you sure?")) {
        $("#form_delete").submit();
    }

    return false;
    event.preventDefault();
}
