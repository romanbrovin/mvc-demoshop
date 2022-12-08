$(function () {

    var owl = $('.owl-slider');

    owl.owlCarousel({
        dotsSpeed: 500,
        touchDrag: true,
        mouseDrag: false,
        loop: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            },
        }
    });

});