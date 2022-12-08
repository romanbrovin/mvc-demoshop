$(function () {

    $('.nav__search').click(function () {
        event.preventDefault();
        new bootstrap.Modal('.search', {}).show();
    });

    $('.nav__categories').click(function () {
        event.preventDefault();
        new bootstrap.Modal('.categories', {}).show();
    });

    $('.nav__basket').click(function () {
        event.preventDefault();
        showBasket();
    });

    $('.dropdown-menu>li').find('.text-danger').removeClass('text-danger');

});