const tooltipTriggerList = $('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

const toast = new bootstrap.Toast('.toast');
const offcanvas = new bootstrap.Offcanvas('.offcanvas');

const toastTimeout = 500;

$(function () {

    referrer = '/' + document.referrer.split('/').slice(3).join('/');
    currentUrl = window.location.pathname + window.location.search;

    if (referrer != currentUrl) {
        setCookie('referrer', referrer, {path: '/'});
    }

    token2 = $('#token2').val();

    var iw = window.innerWidth;

    if (iw < 992) {

    }

    $('.logout').click(function () {
        loader();

        deleteCookie('orderId');

        $('.toast').addClass('bg-secondary text-bg-secondary');
        $('.toast-body').html('<i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;&nbsp;Вы вышли из кабинета');
        toast.show();

        setTimeout(function () {
            location.href = "/logout";
        }, toastTimeout);

    });

    $('.notification').on('shown.bs.modal', event => {
        $('.notification').find('input[type=text],input[type=number],textarea,select').filter(':visible:first').focus().select();
    })

    $('.btn__back').click(function () {
        let url = getCookie('referrer');
        let id = $('#id').val();

        if (id) {
            url = url + '#' + id;
        }

        location.href = url;

    });

    $.each($('#form').serializeArray(), function (i, field) {
        $("[name=" + field.name + "]").on("input", function (ev) {
            let placeholder = $(this).attr('placeholder');
            let maxlength = $(this).attr('maxlength');
            let lenght = $(this).val().length;

            if (maxlength && lenght > 0) {
                placeholder = placeholder + ' ' + lenght + '/' + maxlength;
            }

            $(this).next('label').html(placeholder);

            if (field.name == 'phone') {
                this.value = this.value.replace(/[^0-9]/g, '');
            }
        });

    });

});

function getPayLink(orderId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = orderId;

    loader();

    $.ajax({
        type: "POST",
        url: "/paykeeper/get-pay-link",
        data: vars
    }).done(function (payLink) {

        if (payLink) {
            $('.toast').addClass('text-bg-secondary');
            $('.toast-body').html('<i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;' +
                'Переадресация на страницу оплаты');
            toast.show();

            setTimeout(function () {
                location.href = payLink;
            }, toastTimeout);
        }

    });
}