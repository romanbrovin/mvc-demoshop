$(function () {

    $('.order__cancel').click(function () {
        event.preventDefault();
        let orderId = $(this).closest('.order').attr('id');

        str =
            '<div class="modal-header border-bottom-0">' +
            '    <h5 class="modal-title">Заказ <strong>' + orderId + '</strong></h5>' +
            '    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>' +
            '</div>' +
            '<div class="modal-body py-0">' +
            '    <h4>Отменить заказ?</h4>' +
            '</div>' +
            '<div class="modal-footer border-top-0">' +
            '    <button onclick="cancelOrder(' + orderId + ')" class="btn btn-danger btn-sm" type="button">' +
            '       Да, отменить' +
            '    </button>' +
            '</div>';

        $('.notification .modal-content').html(str);
        new bootstrap.Modal('.notification', {}).show();
    });

    $('.order__pay').click(function () {
        let orderId = $(this).closest('.order').attr('id');
        getPayLink(orderId);
    });

    $('.order__status').hover(
        function () {
            let orderId = $(this).closest('.order').attr('id');
            $('.status_' + orderId).fadeIn(200);
        },
        function () {
            let orderId = $(this).closest('.order').attr('id');
            $('.status_' + orderId).fadeOut(200);
        }
    );

    $('.order__continue').click(function () {
        let orderId = $(this).closest('.order').attr('id');
        setCookie('orderId', orderId);

        loader();

        setTimeout(function () {
            location.href = "/order";
        }, toastTimeout);
    });

});

function cancelOrder(orderId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['orderId'] = orderId;

    loader();

    $.ajax({
        type: "POST",
        url: "/cabinet/cancel",
        data: vars
    }).done(function () {

        $('.notification').hide();
        $('.toast').addClass('text-bg-secondary');
        $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ отменен');
        toast.show();

        deleteCookie('orderId');

        setTimeout(function () {
            location.reload();
        }, toastTimeout);

    });
}