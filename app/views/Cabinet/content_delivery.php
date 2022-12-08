<div class="mt-2">
    <?php if ($order['delivery_type'] == 'mail'): ?>
        <?php if (!$order['delivery_service']) : ?>
            <strong>Доставка:</strong>
            <span class="dotted" data-bs-custom-class="tooltip" data-bs-placement="top"
                  data-bs-title="Транспортную компанию выберет сотрудник магазина после подтверждения вашего заказа"
                  data-bs-toggle="tooltip">транспортной компанией</span>
        <?php else: ?>
            <?php if ($order['delivery_service'] == 'Boxberry') : ?>
                <img src="/images/boxberry.png" class="img-fluid mb-2" alt="">
            <?php elseif ($order['delivery_service'] == 'СДЭК') : ?>
                <img src="/images/cdek.png" class="img-fluid mb-2" alt="">
            <?php elseif ($order['delivery_service'] == 'Почта России') : ?>
                <img src="/images/russianpost.png" class="img-fluid mb-2" alt="">
            <?php endif; ?>
        <?php endif; ?>
    <?php elseif ($order['delivery_type'] == 'courier'): ?>
        <strong>Доставка:</strong> курьером
    <?php endif; ?>

    <?php if ($order['delivery_track']) : ?>
        <?php $deliveryServiceUrl = getDeliveryServiceUrl($order['delivery_service']) ?>
        <?php $deliveryUrl = $deliveryServiceUrl . $order['delivery_track']; ?>
        <br>
        <strong>Трек-номер:</strong>
        <a href="<?=$deliveryUrl?>" target="_blank">
            <?=$order['delivery_track']?>
        </a>
    <?php endif; ?>

    <?php if ($order['delivery_variant'] == 'pvz') : ?>
        <br>
        <strong>Вариант доставки:</strong> до ПВЗ
    <?php elseif ($order['delivery_variant'] == 'courier') : ?>
        <br>
        <strong>Вариант доставки:</strong> курьером до двери
    <?php endif; ?>

    <?php if ($order['address']) : ?>
        <br>
        <strong>Адрес:</strong> <?=$order['address']?>
    <?php endif; ?>

    <?php if ($order['comment_user']) : ?>
        <br>
        <mark><?=$order['comment_user']?></mark>
    <?php endif; ?>
</div>