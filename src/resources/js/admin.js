$(document).ready(function () {
    $('.select2').select2();

    //// menu
    let url_current      = window.location.href;
    let item_menu = $('.admin .nav-treeview .nav-item');
    item_menu.find('a').removeClass('active');
    item_menu.each(function () {
        if (url_current == $(this).children('a').attr('href')) {
            $(this).addClass('active');
        }
    });
});
