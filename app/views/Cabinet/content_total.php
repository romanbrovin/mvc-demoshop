<div class="content_total">

    <div class="text-end">
        Стоимость заказа:
        <strong><?=rank($order['order_sum'])?> ₽</strong>

        <br>
        Доставка<?=($order['delivery_days']) ? ' (' . $order['delivery_days'] . ')' : null;?>:
        <strong><?=($order['delivery_price'] == 0) ? 'бесплатно' : rank($order['delivery_price']) . ' ₽'?></strong>

        <?php if ($order['cod'] > 0) : ?>
            <br>
            «<span class="dotted" data-bs-custom-class="tooltip" data-bs-placement="top"
                   data-bs-title="Дополнительная плата в размере 4% за прием платежей транспортной компанией"
                   data-bs-toggle="tooltip">Наложенный платеж</span>»:
            <strong><?=rank($order['cod'])?> ₽</strong>
        <?php endif; ?>

        <?php if ($order['bonus'] > 0) : ?>
            <br>
            Списано бонусов:
            <strong><?=rank($order['bonus'])?> ₽</strong>
        <?php endif; ?>

        <br>
        Оплата:
        <strong><?=($order['payment'] == 1) ? 'на сайте' : 'при получении'?></strong>
    </div>

    <div class="mt-4 text-end h4 fw-bold">
        Итого: <?=rank($order['total_sum'])?> ₽
    </div>

</div>