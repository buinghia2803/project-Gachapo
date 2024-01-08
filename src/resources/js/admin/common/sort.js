var sort = () => {
    let sortData = () => {
        $('.sort-data').on('click', function () {
            let input = $(this).attr('content-value');
            let desc = $(this).attr('desc');
            let typeSort = desc == 'asc' || desc == null ? 'desc' : 'asc';
            $('#input').val(input);
            $('#typeSort').val(typeSort);
            $('#form-sort').submit();
        });
    }
    return {
        sorting: function () {
            sortData();
        },
    };
};

window.sort = sort();

$(function () {
    sort.sorting();
})
