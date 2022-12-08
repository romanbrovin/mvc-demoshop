$(function () {

    $('.s_query').click(function () {
        event.preventDefault();
        q = $(this).attr('data-query');
        s = $('#s').val();
        n = $('#n').val();
        pathname = parseUrl(location.href).pathname;
        location.href = pathname + "?s=" + s + "&q=" + q + "&n=" + n;
    });

    $('.n_query').click(function () {
        event.preventDefault();
        q = $('#q').val();
        s = $('#s').val();
        n = $(this).attr('data-query');
        pathname = parseUrl(location.href).pathname;
        location.href = pathname + "?s=" + s + "&q=" + q + "&n=" + n;
    });

});