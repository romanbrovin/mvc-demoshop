$(function () {

    $('.btn__signup').click(function () {
        userAction('signup');
    });

    $('.btn__login').click(function () {
        userAction('login');
    });

    $('.btn__settings').click(function () {
        userAction('settings');
    });

    $('.btn__recovery').click(function () {
        userAction('recovery');
    });

});

function userAction(action) {
    let vars = new Object();
    vars['token2'] = token2;

    $.each($('#form').serializeArray(), function (i, field) {
        vars[field.name] = field.value;
    });

    $('input:checkbox:checked').each(function () {
        vars[$(this).attr('name')] = 1;
    });

    let button = $('.btn__' + action);
    button.prop('disabled', true);

    loader();

    $.ajax({
        type: "POST",
        url: "/" + action,
        data: vars
    }).done(function (response) {

        let data = JSON.parse(response);

        $('.is-invalid').removeClass('is-invalid');

        if (data == 'ok') {
            if (action == 'signup') {
                toastMsg = 'Вы успешно зарегистрированы';
                locationHref = '/cabinet';
            } else if (action == 'settings') {
                toastMsg = 'Настройки сохранены';
                locationHref = '/cabinet';
            } else if (action == 'login') {
                toastMsg = 'Вы успешно авторизованы';
                locationHref = '/login';
            } else if (action == 'recovery') {
                toastMsg = 'Новый пароль отправлен на вашу электронную почту';
                locationHref = '/login';
            }

            if (getCookie('referrer') == '/order') {
                deleteCookie('referrer');
                locationHref = '/order';
            }

            $('.toast').removeClass('text-bg-danger');
            $('.toast').addClass('text-bg-success');
            $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;' + toastMsg);
            toast.show();

            setTimeout(function () {
                location.href = locationHref;
            }, toastTimeout);
        } else {

            if (data.length > 0) {
                if (data == 'auth') {
                    toastMsg = 'Электронная почта или пароль введены неправильно';
                    $('.form-control').addClass('is-invalid');
                } else if (data == 'non-unique' || data == 'non-exist') {
                    toastMsg = 'Введите другую электронную почту';
                    $('#email').addClass('is-invalid');
                } else if (data == 'password') {
                    toastMsg = 'Неправильно введен старый пароль';
                    $('#password').addClass('is-invalid');
                } else {
                    let errorStr = '';

                    for (let key in data) {
                        errorStr += '<br>&mdash;&nbsp;&nbsp;' +
                            $('#' + data[key] + '~ .feedback-short').html();
                        $('#' + data[key]).addClass('is-invalid');
                    }

                    toastMsg = '<strong><i class="fa-solid fa-triangle-exclamation"></i>' +
                        '&nbsp;&nbsp;Необходимо ввести:</strong>' + errorStr;
                }

                $('.toast').addClass('text-bg-danger');
                $('.toast-body').html(toastMsg);
                toast.show();
            }

            button.prop('disabled', false);
            loader(0);
        }

    });
}