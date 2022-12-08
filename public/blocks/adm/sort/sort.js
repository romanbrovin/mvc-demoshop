$(function () {

    pathName = parseUrl(location.href).pathname;

    // Блок поиска на странице
    $('.s_query').click(function () {
        searchGo($(this).attr('data-query'));
    });

    $('#search__form select, #search__form [type="date"]').change(function () {
        searchGo();
    });

    $('#s_find, #search__form [type="checkbox"]').click(function () {
        searchGo();
    });

    $('#s_clear').click(function () {
        location.href = pathName;
    });

});

function searchGo(query) {
    let vars = new Object();

    $.each($('#search__form').serializeArray(), function (i, field) {
        vars[field.name] = field.value;
    });

    $('#search__form [type="checkbox"]:checked').each(function() {
        vars[$(this).attr('name')] = 1;
    });

    let url = pathName + "?" + $.param(vars);

    if (query) {
        url = url + "&s_order=" + query;
    }

    location.href = url;
}
