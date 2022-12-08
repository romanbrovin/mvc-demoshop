$(function () {

    var iw = window.innerWidth;

    if (iw > 992) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 200) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });
    }

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    })

});