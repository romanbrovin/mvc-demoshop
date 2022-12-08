$(function () {

    let arrMarketplace = ['adv', 'dbs', 'ozon', 'wb', 'avito'];
    $.each(arrMarketplace, function (key, name) {
        $('#price_' + name + '_discount').on("input", function (ev) {
            calcPriceWithDiscount(name);
        });

        $('#price_' + name).on("input", function (ev) {
            calcPrice(name);
        });

    });

    $('.btn__set_avatar').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        let photo = $(this).closest('.item__photo').data('photo');
        setAvatarToProduct(itemId, photo);
    });

    $('.btn__set_prices').click(function () {
        event.preventDefault();
        setPrices();
    });

    $('.btn__photo_delete').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        let photo = $(this).closest('.item__photo').data('photo');
        deletePhotoFromProduct(itemId, photo);
    });

});

function calcPriceWithDiscount(marketplace) {
    let price = $('#price_' + marketplace).val();
    let priceDiscount = $('#price_' + marketplace + '_discount').val();
    let priceDiscountSum = '#price_' + marketplace + '_discount_sum';
    let priceDiscountPercent = '#price_' + marketplace + '_discount_percent';

    $('#price_' + marketplace).removeClass('is-invalid');

    if (priceDiscount > 0) {
        $('#price_' + marketplace).val(priceDiscount)
    }

    if (priceDiscount.length === 0) {
        $(priceDiscountSum).html('0');
        $(priceDiscountPercent).html('0');
        $('#price_' + marketplace).val('')
    }
}

function calcPrice(marketplace) {
    let price = $('#price_' + marketplace).val();
    let priceDiscount = $('#price_' + marketplace + '_discount').val();
    let priceDiscountSum = '#price_' + marketplace + '_discount_sum';
    let priceDiscountPercent = '#price_' + marketplace + '_discount_percent';

    if (priceDiscount > 0 && price > 0) {
        let diff = price - priceDiscount;

        $('#price_' + marketplace).removeClass('is-invalid');

        if (diff > 0) {
            let percent = diff / price * 100;

            numberAnimation(priceDiscountSum, diff);
            numberAnimation(priceDiscountPercent, percent);
        }

        if (diff < 0) {
            $('#price_' + marketplace).addClass('is-invalid');
        }
    }

    if (priceDiscount.length === 0 || price.length === 0 || price > priceDiscount) {
        $(priceDiscountSum).html('0');
        $(priceDiscountPercent).html('0');
    }

}

function deletePhotoFromProduct(itemId, photo) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['photo'] = photo;

    $.ajax({
        type: "POST",
        url: "/adm/product/delete-photo",
        data: vars
    }).done(function () {

        $('[data-photo=' + photo + ']').fadeOut();

    });
}

function setAvatarToProduct(itemId, photo) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['photo'] = photo;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/product/set-avatar",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-secondary');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Аватарка установлена');
        toast.show();

        let referrer = getCookie('referrer');
        setTimeout(function () {
            location.href = referrer + '#' + vars['id'];
        }, toastTimeout);

    });
}

function setPrices() {
    let vars = new Object();
    vars['token2'] = token2;

    let errors = [];

    $.each($('#form').serializeArray(), function (i, field) {
        if (field.value < 0) {
            errors.push(field.name)
        }

        vars[field.name] = field.value;
    });

    if (errors.length > 0) {
        $.each(errors, function (key, name) {
            $('#' + name).addClass('is-invalid');
        });

        $('.toast').addClass('text-bg-danger');
        $('.toast-body').html('<i class="fa-solid fa-triangle-exclamation"></i>' +
            '&nbsp;&nbsp;Неправильный формат цены');
        toast.show();

        return false;
    }

    let button = $('.btn__set_prices');
    button.prop('disabled', true);

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/product/set-prices",
        data: vars
    }).done(function (response) {

        let data = JSON.parse(response);

        if (data == 'ok') {
            $('.toast').removeClass('text-bg-danger');
            $('.toast').addClass('text-bg-success');
            $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Цены установлены');
            toast.show();

            redirectUrl = getCookie('referrer') + '#' + vars['id'];

            setTimeout(function () {
                location.href = redirectUrl;
            }, toastTimeout);

        }

    });
}
