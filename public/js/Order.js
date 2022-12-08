var vSuggestion;
var vAddress;

$(function () {

    $('.details-comment__textarea').on("input", function (ev) {
        $(this).next('label').html('Комментарий к заказу ' + $(this).val().length + '/250');
    });

    $('#user__name').on("input", function (ev) {
        $(this).next('label').html('Имя ' + $(this).val().length + '/150');
    });

    $('#user__surname').on("input", function (ev) {
        $(this).next('label').html('Фамилия ' + $(this).val().length + '/150');
    });

    $('#user__login').click(function () {
        event.preventDefault();
        setCookie('referrer', 'order');
        location.href = '/login';
    });

    $('#user__settings').click(function () {
        event.preventDefault();
        setCookie('referrer', 'order');
        location.href = '/settings';
    });

    $('#delivery-mail__calculation').click(function () {
        setDeliveryCalculation();
    });

    $('#order__checkout').click(function () {
        checkoutOrder();
    });

    $('#details-bonus__checkbox').click(function () {
        setBonusOrder();
    });

    $('input[name="delivery-type__radio"]').click(function () {
        setDeliveryType();
    });

    $('input[name="delivery-courier__radio"]').click(function () {
        setDeliveryCourier();
    });

    $('input[name="payment-method__radio"]').click(function () {
        setPaymentMethod();
    });

    $('input[name="delivery-variant__radio"]').click(function () {
        setDeliveryVariant();
    });

});

function setBonusOrder() {
    let vars = new Object();
    vars['token2'] = token2;

    $.ajax({
        type: "POST",
        url: "/order/set-bonus",
        data: vars
    }).done(function (bonus) {

        numberAnimation("#details-bonus__amount", bonus);
        updateOrder();

    });
}

function setDeliveryCalculation() {
    let deliveryAddress = $('#user__address').val();

    if (vSuggestion && deliveryAddress) {
        let words = vSuggestion['value'].split(',');

        if (words.length > 2) {
            resetDelivery();

            $('#delivery-mail__calculation').prop('disabled', true);
            $('[name="delivery-variant__radio"]').prop('checked', false);

            $('.details-delivery__service>span').html('транспортной компанией');
            $('.details-delivery__address').addClass('d-none');
            $('.details-delivery__price').addClass('d-none');
            $('.details-delivery__days').addClass('d-none');

            calculationDelivery();
        } else {
            $('#user__address').addClass('is-invalid');
        }
    } else {
        $('#user__address').addClass('is-invalid');
    }
}

function setDeliveryCourier() {
    let deliveryAddress = $('input[name="delivery-courier__radio"]:checked').val();

    $('.details-delivery__address').removeClass('d-none');
    $('.details-delivery__address>span').html(deliveryAddress);
    $('.details-delivery__service>span').html('курьером');

    updateOrder();
}

function setDeliveryType() {
    resetDelivery();

    let deliveryType = $('input[name="delivery-type__radio"]:checked').val();

    if (deliveryType == 'courier') {
        $('#delivery-courier__sochi').attr('checked', true);

        $('.delivery-variant').addClass('d-none');
        $('.delivery-mail').addClass('d-none');
        $('.delivery-courier').removeClass('d-none');

        let deliveryAddress = $('input[name="delivery-courier__radio"]:checked').val();

        $('.details-delivery__variant').addClass('d-none');
        $('.details-delivery__service>span').html('курьером');
        $('.details-delivery__address').removeClass('d-none');
        $('.details-delivery__address>span').html(deliveryAddress);
        $('.details-delivery__price').removeClass('d-none');
        $('.details-delivery__days').addClass('d-none');

        $('.detail-delivery__service_mail').addClass('d-none');
        $('.detail-delivery__service_courier').removeClass('d-none');

    } else if (deliveryType == 'mail') {
        $("#user__address").val('');

        $('.delivery-courier').addClass('d-none');
        $('.delivery-mail').removeClass('d-none');

        $('.details-delivery__service>span').html('по России');
        $('.details-delivery__address').addClass('d-none');
        $('.details-delivery__price').addClass('d-none');
        $('.details-delivery__days').addClass('d-none');

        $('.detail-delivery__service_courier').addClass('d-none');
        $('.detail-delivery__service_mail').removeClass('d-none');

    }

    updateOrder();
}

function setPaymentMethod() {
    let payment = $('input[name="payment-method__radio"]:checked').val();

    if (payment == 1) {
        paymentText = 'на сайте';
        $('.details-payment__online').removeClass('d-none');

    } else {
        paymentText = 'при получении';
        $('.details-payment__online').addClass('d-none');
    }

    $('.details-payment__method>span').html(paymentText);

    updateOrder();
}

function setDeliveryVariant() {
    let deliveryAddress = $('#user__address').val();
    let element = $('input[name="delivery-variant__radio"]:checked');
    let variant = element.val();
    let price = element.attr('data-price');
    let days = element.attr('data-days');

    if (variant == 'pvz') {
        variant = 'до пункта выдачи заказа';
    } else {
        variant = 'курьером до двери';
    }

    $('.details-delivery__variant>span').html(variant);
    $('.details-delivery__price>span').html(price);
    $('.details-delivery__days>span').html(days);
    $('.details-delivery__address>span').html(deliveryAddress);

    $('.details-delivery__variant').removeClass('d-none');
    $('.details-delivery__price').removeClass('d-none');
    $('.details-delivery__days').removeClass('d-none');
    $('.details-delivery__address').removeClass('d-none');

    if (days == 0) {
        $('.details-delivery__days').addClass('d-none');
    }

    updateOrder();
}

function checkoutOrder() {
    $('.is-invalid').removeClass('is-invalid');

    let button = $('#order__checkout');
    button.prop('disabled', true);

    let vars = new Object();
    vars['token2'] = token2;
    vars['address'] = $('.details-delivery__address>span').html();
    vars['delivery_type'] = $('input[name="delivery-type__radio"]:checked').val();
    vars['delivery_variant'] = $('input[name="delivery-variant__radio"]:checked').val();
    vars['delivery_service'] = $('.details-delivery__service>span').html();
    vars['delivery_price'] = $('.details-delivery__price>span').html();
    vars['delivery_days'] = $('.details-delivery__days>span').html();
    vars['payment'] = $('input[name="payment-method__radio"]:checked').val();
    vars['comment_user'] = $('.details-comment__textarea').val();

    let errors = [];
    let errorHead = '<strong><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;Необходимо ввести:</strong>';
    let errorStr = '';
    let errorLegal = '';
    let errorCalc = '';

    let formFields = ['name', 'surname', 'email', 'phone', 'captcha', 'legal'];

    if ($('#user__login').html() != undefined) {
        for (let key in formFields) {
            if (formFields[key] == 'legal') {
                if ($('#user__legal').is(':checked')) {
                } else {
                    errors.push('legal');
                }
            } else {
                if ($('#user__' + formFields[key]).val() == '') {
                    errors.push(formFields[key]);
                } else {
                    vars[formFields[key]] = $('#user__' + formFields[key]).val();
                }
            }
        }
    }

    if (vars['delivery_service'].replace(/\s/g, '') == 'курьером') {
        vars['delivery_days'] = '';
    } else {
        if ($('#user__address').val() == '') {
            errors.push('address');
        } else if ($('#user__address').val() != vars['address']) {
            errors.push('delivery');
        }

        vars['address'] = $('#user__address').val();
    }

    if (errors.length > 0) {
        for (let key in errors) {
            $('#user__' + errors[key]).addClass('is-invalid');
            let feedback = $('#user__' + errors[key] + ' ~ .feedback-short').html();

            if (errors[key] == 'legal') {
                errorLegal = '<i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;' +
                    'Необходимо принять условия пользовательского соглашения';
            } else if (errors[key] == 'delivery') {
                errorCalc = '<i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;' +
                    'Необходимо рассчитать доставку и выбрать транспортную компанию';
            } else {
                if (feedback != '') {
                    errorStr += '<br>&mdash;&nbsp;&nbsp;' + feedback;
                }
            }
        }

        if (errorStr != '') {
            errorStr = errorHead + errorStr;
        }

        if (errorLegal != '') {
            if (errorStr == '') {
                errorStr = errorLegal;
            } else {
                errorStr += '<br><br>' + errorLegal;
            }
        }

        if (errorCalc != '') {
            if (errorStr == '') {
                errorStr = errorCalc;
            } else {
                errorStr += '<br><br>' + errorCalc;
            }
        }

        $('.toast').addClass('text-bg-danger');
        $('.toast-body').html(errorStr);
        toast.show();
        button.prop('disabled', false);

        return;
    }

    loader();

    $.ajax({
        type: "POST",
        url: "/order/checkout",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        $('.is-invalid').removeClass('is-invalid');

        if (data == 'ok') {
            $('.toast').removeClass('text-bg-danger');
            $('.toast').addClass('text-bg-success');
            $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ оформлен');
            toast.show();

            deleteCookie('orderId');

            setTimeout(function () {
                location.href = "/cabinet";
            }, toastTimeout);
        } else if (data == 'non-unique') {
            $('#user__email').addClass('is-invalid');
            $('.toast').addClass('text-bg-danger');
            $('.toast-body').html('Введите другую электронную почту');
            toast.show();
            button.prop('disabled', false);

            loader(0);
        } else {
            if (data.length > 0) {
                let errorStr = '';

                for (let key in data) {
                    errorStr += '<br>&mdash;&nbsp;&nbsp;' + $('#user__' + data[key] + '~ .feedback-short').html();
                    $('#user__' + data[key]).addClass('is-invalid');
                }

                errorStr = errorHead + errorStr;

                $('.toast').addClass('text-bg-danger');
                $('.toast-body').html(errorStr);
                toast.show();
            }
            button.prop('disabled', false);

            loader(0);
        }

    });
}

function updateOrder() {
    let vars = new Object();
    vars['token2'] = token2;
    vars['address'] = $('.details-delivery__address>span').html();
    vars['delivery_type'] = $('input[name="delivery-type__radio"]:checked').val();
    vars['delivery_variant'] = $('input[name="delivery-variant__radio"]:checked').val();
    vars['delivery_price'] = $('.details-delivery__price>span').html();
    vars['delivery_days'] = $('.details-delivery__days>span').html();
    vars['payment'] = $('input[name="payment-method__radio"]:checked').val();
    vars['comment_user'] = $('.details-comment__textarea').val();

    $.ajax({
        type: "POST",
        url: "/order/update",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        if (data['delivery_type'] == 'courier') {
            $('.details-payment__cod').addClass('d-none');
        } else if (data['delivery_type'] == 'mail') {
            $('.details-payment__cod>span').html(data['cod']);

            if (data['payment'] == 1) {
                $('.details-payment__cod').addClass('d-none');
            } else if (data['payment'] == 2) {
                $('.details-payment__cod').removeClass('d-none');
            }
        }

        numberAnimation(".details-delivery__price>span", data['delivery_price']);
        numberAnimation("#details__sum", data['total_sum']);
    });
}

function resetDelivery() {
    let vars = new Object();
    vars['token2'] = token2;

    $.ajax({
        type: "POST",
        url: "/order/reset-delivery",
        data: vars
    }).done(function () {

        $('.is-invalid').removeClass('is-invalid');

    });
}

function calculationDelivery() {
    let vars = new Object();
    vars['token2'] = token2;
    vars['delivery_type'] = $('input[name="delivery-type__radio"]:checked').val();
    vars['delivery_variant'] = $('input[name="delivery-variant__radio"]:checked').val();
    vars['payment'] = $('input[name="payment-method__radio"]:checked').val();
    vars['comment_user'] = $('.details-comment__textarea').val();
    vars['postcode'] = vAddress['fields'][10]['name'];

    if (vAddress['fields'][0]['type'] == 'г') {
        vars['address'] = vAddress['fields'][0]['name'];
    } else if (vAddress['fields'][2]['st'] == 2) {
        vars['address'] = vAddress['fields'][2]['name'];
    } else {
        let region = '';
        let regionName = vAddress['fields'][0]['name'].replace(/.\(.*\)/gm, '');

        if (regionName == 'Северная Осетия - Алания') {
            region = 'Республика Северная Осетия';
        } else if (regionName == 'Саха /Якутия/') {
            region = 'Республика Саха (Якутия)';
        } else {
            let typeFirst = ["Адыгея", "Дагестан", "Ингушетия", "Башкортостан", "Татарстан", "Алтай", "Бурятия",
                "Хакасия", "Мордовия", "Марий Эл", "Калмыкия", "Коми", "Карелия", "Крым", "Тыва"];

            for (let key in typeFirst) {
                if (regionName == typeFirst[key]) {
                    region = 'Республика ' + typeFirst[key];
                }
            }

            if (region == '') {
                let regionType = ' ' + vAddress['fields'][0]['type'];

                if (vAddress['fields'][0]['type'] == 'обл') {
                    regionType = 'область';
                } else if (vAddress['fields'][0]['type'] == 'Респ') {
                    regionType = 'Республика';
                }

                region = regionName + ' ' + regionType;
            }
        }

        vars['address'] = vAddress['fields'][2]['name'] + ' (' + region + ')';
    }

    if (vars['address'] == undefined) {
        vars['address'] = '';
    }

    $('.delivery-variant').addClass('d-none');
    $('.delivery-spin').removeClass('d-none');

    $.ajax({
        type: "POST",
        url: "/order/calculation-delivery",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        $('.delivery-spin').addClass('d-none');
        $('#delivery-mail__calculation').prop('disabled', true);

        if (data == 'errorDeliveryPrice') {
            $('#user__address').addClass('is-invalid');
            $('.details-delivery__address').addClass('d-none');
            $('.details-delivery__price').addClass('d-none');
            $('.details-delivery__days').addClass('d-none');
        } else {
            $('#user__address').removeClass('is-invalid');
            $('.delivery-variant').removeClass('d-none');

            let pricePvz = data['price'];
            let priceCourier = data['price'] + 200;

            let days = data['minDay'] + '-' + data['maxDay'];
            let dayStr = wordByNumber(data['maxDay'], ['день', 'дня', 'дней']);

            $('.delivery-variant__pvz-price').html(pricePvz + ' ₽, ' + days + ' ' + dayStr);
            $('#delivery-variant__pvz').attr('data-days', days + ' ' + dayStr);
            $('#delivery-variant__pvz').attr('data-price', pricePvz);

            $('.delivery-variant__courier-price').html(priceCourier + ' ₽, ' + days + ' ' + dayStr);
            $('#delivery-variant__courier').attr('data-days', days + ' ' + dayStr);
            $('#delivery-variant__courier').attr('data-price', priceCourier);
        }

    });
}