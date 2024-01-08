const confirm = 1;
const approved = 2;
var update = () => {
    let token = $('meta[name="csrf-token"]').attr('content');

    let updateObject = () => {
        let updateUrl;
        let id;
        $('#modal-update').on('show.bs.modal', function (media) {
            updateUrl = $(media.relatedTarget).data('updateUrl');
            var parts = updateUrl.split('/');
            id = parts[parts.length - 1];
            $('.modal-text-delete').text( $(media.relatedTarget).data('content') );
        });
        $('#modal-update .modal-footer button.update').on('click', function () {
            $.ajax({
                method: 'PUT',
                url: updateUrl,
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

    let updateStatusConfirmObject = () => {
        let updateUrl;
        let id;
        $('#modal-update-status-confirm').on('show.bs.modal', function (media) {
            updateUrl = $(media.relatedTarget).data('updateUrl');
            var parts = updateUrl.split('/');
            id = parts[parts.length - 1];
            $('.modal-text-update').text( $(media.relatedTarget).data('content') );
        });
        $('#modal-update-status-confirm .modal-footer button.update').on('click', function () {
            $.ajax({
                method: 'PUT',
                url: updateUrl,
                data_type: 'json',
                data: {cast_confirm: approved},
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
    return {
        listUpdateObject: function () {
            updateObject();
            updateStatusConfirmObject();
        },
    };
};

window.update = update();

$(function () {
    update.listUpdateObject();
});
