<div class="order-details">

    <div class="d-flex mb-3">
        <h2 class="marker">
            <span class="marker_h2">
                Итого: <span id="details__sum"><?=rank($order['total_sum'])?></span> ₽
            </span>
        </h2>
    </div>

    <div>
        <strong>Стоимость заказа:</strong> <?=rank($order['order_sum'])?> ₽
    </div>

    <div>
        <strong>Надежная упаковка заказа:</strong> бесплатно
    </div>

    <div class="details-delivery__service mt-3 mb-3">
        <strong>Доставка:</strong>
        <span><?=($order['delivery_type'] == 'mail') ? 'по России' : 'курьером'?></span>

        <div class="font-14 text-secondary">
            <span class="detail-delivery__service_mail
                <?=($order['delivery_type'] == 'mail') ? '' : 'd-none';?>">
                Транспортную компанию выберет менеджер после подтверждения вашего заказа
            </span>
            <span class="detail-delivery__service_courier
                <?=($order['delivery_type'] == 'courier') ? '' : 'd-none';?>">
                При оформлении заказа до 13:00 по московскому времени доставка курьером осуществляется в тот же день
            </span>
        </div>
    </div>

    <div class="details-delivery__variant
        <?=($order['delivery_variant'] == '') ? 'd-none' : '';?>">
        <strong>Вариант доставки:</strong>
        <span></span>
    </div>

    <div class="details-delivery__address
        <?=($order['address'] == '') ? 'd-none' : '';?>">
        <strong>Адрес доставки:</strong>
        <span><?=$order['address']?></span>
    </div>

    <div class="details-delivery__price
        <?=($order['delivery_price'] == 0 && $order['address'] != 'Район-1') ? 'd-none' : '';?>">
        <strong>Стоимость доставки:</strong>
        <span><?=$order['delivery_price']?></span> ₽
    </div>

    <div class="details-delivery__days
        <?=($order['delivery_type'] == 'courier' || ($order['delivery_type'] == 'mail' &&
            ($order['delivery_price'] == 0 || $order['delivery_days'] == 0))) ? 'd-none' : '';?>">
        <strong>Срок доставки:</strong>
        <span><?=$order['delivery_days']?></span>
    </div>

    <div class="details-payment__method mt-3">
        <strong>Оплата:</strong>
        <span>
            <?=($order['payment'] == 1) ? 'на сайте' : 'при получении';?>
        </span>

        <div class="details-payment__online <?=($order['payment'] == 1) ? '' : 'd-none';?>">
            <div class="linear-wipe fw-bold">
                Максимальная выгода от покупки!
            </div>
            <div class="font-14 mt- text-secondary">
                За оплаченные онлайн заказы начисляются бонусные рубли, которые можно сразу использовать
                для оплаты следующей покупки
            </div>
        </div>
    </div>

    <div class="details-payment__cod
        <?=($order['delivery_type'] == 'courier' || $order['cod'] == 0) ? 'd-none' : '';?>">

        <strong>Услуга «Наложенный платеж»:</strong>
        <span><?=$order['cod']?></span> ₽

        <div class="text-secondary small">
            &laquo;Наложенный платеж&raquo;
            &ndash; это дополнительная плата в размере 4% к стоимости заказа за прием платежей
            транспортной компанией
        </div>
    </div>

    <?php if (isAuth() && ($_SESSION['user']['bonus'] > 0 || $order['bonus'] > 0)) : ?>
        <div class="details-bonus mt-3">
            <strong>Накопленные бонусы</strong>:
            <span id="details-bonus__amount"><?=rank($_SESSION['user']['bonus'])?></span>&nbsp;₽
            <div class="form-check">
                <input class="form-check-input" id="details-bonus__checkbox" type="checkbox"
                    <?=($order['bonus'] > 0) ? 'checked' : '';?>>
                <label class="form-check-label" for="details-bonus__checkbox">
                    Списать бонусные рубли
                </label>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-4 form-floating">
        <textarea class="form-control details-comment__textarea"><?=$order['comment_user']?></textarea>
        <label>Комментарий к заказу</label>
    </div>

    <div class="mt-2 small">
        Доставка осуществляется со склада г. Москва.
    </div>

    <div class="mt-1 small">
        В ближайшее время с вами свяжется менеджер для подтверждения заказа.
    </div>

    <div class="mt-4 order-checkout">
        <button class="btn btn-success" id="order__checkout" type="button">Заказать</button>
    </div>

</div>