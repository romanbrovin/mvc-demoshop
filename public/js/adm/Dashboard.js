$(function () {

    $('.feed').click(function () {
        event.preventDefault();
        let feed = $(this).closest('li').attr('data-feed');
        setFeed(feed);
    });

    $('.feed-update').click(function () {
        event.preventDefault();
        let feed = $(this).closest('li').attr('data-feed');
        updateFeed(feed);
    });

    $('#sync').click(function () {
        event.preventDefault();
        setSync();
    });

});

function setSync() {
    let vars = new Object();
    vars['token2'] = token2;

    $('#sync__ico').addClass('fa-spin');

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/dashboard/set-sync",
        data: vars
    }).done(function () {

        location.reload();

    });
}

function setFeed(feed) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['feed'] = feed;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/dashboard/set-feed",
        data: vars
    }).done(function () {

        location.reload();

    });
}

function updateFeed(feed) {
    $('#feed-' + feed + '__ico').addClass('fa-spin');

    loader();

    $.ajax({
        type: "GET",
        url: "/feed/" + feed + "?key=1234567890",
    }).done(function () {

        location.reload();

    });
}

