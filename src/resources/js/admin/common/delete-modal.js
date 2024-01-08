var objectDeleteOrder = () => {
    let token = $('meta[name="csrf-token"]').attr('content');

    let deleteObject = () => {
        let deleteUrl;
        let id;
        $('#modal-delete').on('show.bs.modal', function (media) {
            deleteUrl = $(media.relatedTarget).data('deleteUrl');
            destination = $(media.relatedTarget).data('destination');
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
                    if (destination) {
                        window.location.href = destination;
                        return;
                    }
                    if (textStatus == 'success') {
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function (data) {
                    if (destination) {
                        window.location.href = destination;
                        return;
                    }
                    location.reload();
                }
            });
        });
    };

    return {
        listObject: () => deleteObject()
    };
};

objectDeleteOrder().listObject();
