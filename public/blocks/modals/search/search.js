$(function () {

    $('.search').on('shown.bs.modal', function () {
        $(".search__input").focus();
    });

    $('.search__ico_next').click(function () {
        value = $('.search__input').val();
        if (value) {
            location.href = "/search?s=" + value;
        }
    });

    $('.search__input').keydown(function (e) {
        if (e.keyCode === 13) {
            value = $('.search__input').val();
            if (value) {
                location.href = "/search?s=" + value;
            }
        }
    });

});