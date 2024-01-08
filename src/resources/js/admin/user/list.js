var user = () => {
    let token = $('meta[name="csrf-token"]').attr('content');

    let deleteUser = () => {
        let deleteUrl;
        let id;
        $('#modal-delete').on('show.bs.modal', function (media) {
            deleteUrl = $(media.relatedTarget).data('deleteUrl');
            var parts = deleteUrl.split('/');
            id = parts[parts.length - 1];
            $('.modal-text-delete').text( $(media.relatedTarget).data('content') );
        });
        $('#modal-delete .modal-footer button.delete').on('click', function () {
            $.ajax({
                method: 'DELETE',
                url: deleteUrl,
                data_type: 'json',
                data: {id: id},
                headers: { 'X-CSRF-TOKEN': token },
                success: function(data, textStatus) {
                    if (textStatus == 'success') {
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function (data) {
                    location.reload();
                }
            });
        });
    };

    let sortData = () => {
        $('.sort-data').on('click', function () {
            let input = $(this).attr('content-value');
            let desc = $(this).attr('desc');
            let typeSort = desc == 'asc' || desc == null ? 'desc' : 'asc';
            // return;
            $('#input').val(input);
            $('#typeSort').val(typeSort);
            $('#form-sort').submit();
        });
    }
    return {
        listUser: function () {
            deleteUser();
            sortData();
        },
    };
};

window.user = user();

$(function () {
    user.listUser();
})
