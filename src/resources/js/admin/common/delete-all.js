$(document).ready(function () {
    $('body').on('change', '.check-one', function (e) {
        e.preventDefault();
        table = $(this).closest('table');
        if (table.find('.check-one:checked').length > 0) {
            $('#delete-all').prop('disabled', false);
        } else {
            $('#delete-all').prop('disabled', true);
        }
    });

    $('body').on('change', '.check-all', function (e) {
        e.preventDefault();
        table = $(this).closest('table');
        table.find('.check-one').prop('checked', $(this).prop('checked'));
        $('.check-one').change();
    });

    $('body').on('click', '#delete-all', function (e) {
        e.preventDefault();
        content = $(this).data('content');
        deleteUrl = $(this).data('delete-url');

        deleteAllModal = $('#modal-delete-all');
        deleteAllModal.find('.modal-body').find('.modal-text-delete').html(content);
        deleteAllModal.find('#delete-all-form').attr('action', deleteUrl);

        table = $(this).closest('.card-body').find('table');
        selectedItem = table.find('.check-one:checked');
        $.each(selectedItem, function() {
            id = $(this).val();
            deleteAllModal.find('#delete-all-form').prepend('<input type="hidden" name="ids[]" value="'+id+'">');
        });
    });

    $('body').on('click', '#modal-delete-all button[type=submit]', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        $(this).closest('form').submit();
    });

});