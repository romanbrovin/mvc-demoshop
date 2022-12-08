$(function () {

    // Кнопка сохранения на странице редактирования заказа
    $('#order__save').click(function () {
        let itemId = getCookie('itemId');
        saved(itemId);
    });


    $('.order__pay').click(function () {
        let itemId = $(this).closest('.item').attr('id');
        getPayLink(itemId);
    });


    $('.order__edit').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        setCookie('itemId', itemId, {path: '/'});
        location.href = '/adm/order/edit';
    });

    $('.order__confirm').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Подтвердить заказ?</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '    <div class="text-secondary">После подтверждения заказа товар будет списан со склада</div>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="confirmed(' + itemId + ')" class="btn btn-primary btn-sm" type="button">' +
            '       Подтвердить заказ' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.order__transited').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Отправить заказ?</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body text-secondary py-0">' +
            '    <div>' +
            '       Статус заказа изменится на <span class="badge bg-orange">В пути</span>' +
            '    </div>' +
            '    <div>' +
            '       Клиент получит уведомление на электронную почту' +
            '    </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="transited(' + itemId + ')" class="btn btn-primary btn-sm" type="button">' +
            '       Отправить заказ' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.order__delivered').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Заказ доставлен?</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '    <div class="text-secondary">' +
            '       Запись о финансовых операциях по этому заказу будет добавлена в раздел ' +
            '       <a href="/adm/report">Отчет</a>' +
            '    </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="delivered(' + itemId + ')" class="btn btn-success btn-sm" type="button">' +
            '       Заказ доставлен' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.order__cancel').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Отменить заказ?</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '    <div class="text-secondary">' +
            '       Если текущий статус заказа <span class="badge bg-purple">Подтвержден</span> или ' +
            '       <span class="badge bg-orange">В пути</span>' +
            '       то заказ будет отменен, а товар в заказе будет добавлен обратно на склад' +
            '    </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="canceled(' + itemId + ')" class="btn btn-danger btn-sm" type="button">' +
            '       Отменить заказ' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.order__return').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Оформить возврат?</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '    <div class="text-secondary">' +
            '       После оформления возврата весь товар в заказе будет добавлен обратно на склад' +
            '    </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="returned(' + itemId + ')" class="btn btn-danger btn-sm" type="button">' +
            '       Оформить возврат' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.order__status').hover(
        function () {
            let itemId = $(this).closest('.item').attr('id');
            $('.status_' + itemId).fadeIn(200);
        },
        function () {
            let itemId = $(this).closest('.item').attr('id');
            $('.status_' + itemId).fadeOut(200);
        }
    );

    $('.delivery-service').click(function () {
        let itemId = $(this).closest('.item').attr('id');
        let deliveryService = $(this).val();
        setDeliveryService(itemId, deliveryService);
    });

    $('.delivery-track').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        getDeliveryTrack(itemId);
    });

    $('.marketplace-order').click(function () {
        event.preventDefault();
        let itemId = $(this).closest('.item').attr('id');
        getMarketplaceOrder(itemId);
    });


});

function saved(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    $.each($('#form').serializeArray(), function (i, field) {
        vars[field.name] = field.value;
    });

    let button = $('#order__save');
    button.prop('disabled', true);

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/saved",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        $('.is-invalid').removeClass('is-invalid');

        if (data == 'ok') {
            $('.toast').removeClass('text-bg-danger');
            $('.toast').addClass('text-bg-success');
            $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ изменен');
            toast.show();

            setTimeout(function () {
                location.href = '/adm/order#' + itemId;
            }, toastTimeout);
        } else {
            if (data.length > 0) {
                let errorHead = '<strong><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;Необходимо ввести:</strong>';
                let errorStr = '';

                for (let key in data) {
                    let matches = data[key].match(/[A-Z]+[^A-Z]*|[^A-Z]+/g);
                    data[key] = matches[1].toLowerCase();

                    errorStr += '<br>&mdash;&nbsp;&nbsp;' + $('#delivery__' + data[key] + '~ .feedback-short').html();
                    $('#delivery__' + data[key]).addClass('is-invalid');
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

function confirmed(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/confirmed",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ подтвержден');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function delivered(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/delivered",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ доставлен');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function canceled(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/canceled",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-secondary');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ отменен');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function returned(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/returned",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Оформлен возврат товара');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function transited(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/transited",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ отправлен');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function getDeliveryTrack(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    $.ajax({
        type: "POST",
        url: "/adm/order/get-data",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Транспортная компания</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '   <div class="form-floating">' +
            '       <input class="form-control" id="delivery_track" type="text" value="' + data['delivery_track'] + '">' +
            '       <label for="delivery_track">Трек-номер</label>' +
            '   </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0 mt-2">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="setDeliveryTrack(' + itemId + ')" class="btn btn-primary btn-sm" type="button">Сохранить</button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();

        $('#delivery_track').keydown(function (e) {
            if (e.keyCode === 13) {
                setDeliveryTrack(itemId);
            }
        });

    });
}

function setDeliveryTrack(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['delivery_track'] = $('#delivery_track').val();
    vars['delivery_service'] = $('input[name="delivery-service_' + itemId + '"]:checked').val();

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/set-delivery-track",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Трек-номер изменен');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}


function getMarketplaceOrder(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;

    $.ajax({
        type: "POST",
        url: "/adm/order/get-data",
        data: vars
    }).done(function (msg) {

        let data = JSON.parse(msg);

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h4 class="modal-title">Маркетплейс</h4>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '   <div class="form-floating">' +
            '       <input class="form-control" id="marketplace_order" type="text" value="' + data['marketplace_order'] + '">' +
            '       <label for="marketplace_order">Номер заказа</label>' +
            '   </div>' +
            '</div>' +
            '<div class="modal-footer border-top-0 mt-2">' +
            '    <div class="modal-footer-id">Заказ ' + itemId + '</div>' +
            '    <button onclick="setMarketplaceOrder(' + itemId + ')" class="btn btn-primary btn-sm" type="button">Сохранить</button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();

        $('#marketplace_order').keydown(function (e) {
            if (e.keyCode === 13) {
                setMarketplaceOrder(itemId);
            }
        });

    });
}

function setMarketplaceOrder(itemId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['marketplace_order'] = $('#marketplace_order').val();

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/set-marketplace-order",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Номер заказа на маркетплейсе изменен');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}

function setDeliveryService(itemId, deliveryService) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['id'] = itemId;
    vars['delivery_service'] = deliveryService;

    loader();

    $.ajax({
        type: "POST",
        url: "/adm/order/set-delivery-service",
        data: vars
    }).done(function () {

        $('.toast').addClass('text-bg-success');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Транспортная компания изменена');
        toast.show();

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}


