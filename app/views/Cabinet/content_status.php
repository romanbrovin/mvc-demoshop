<div class="content_status">
    <div class="order-status status_<?=$order['id']?>">

        <?php if ($order['created_at']) : ?>
            <div class="mb-1">
                <span class="fw-bold">
                    <i class="fa-regular fa-file"></i>
                    Создан
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['created_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['checkouted_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-1 text-warning">
                <span class="fw-bold">
                    <i class="fa-solid fa-pause"></i>
                    <?=($order['payment'] == 1) ? 'Ожидает оплаты' : 'Ожидает подтверждения'?>
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['checkouted_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['confirmed_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-1 text-purple">
                <span class="fw-bold">
                    <i class="fa-solid fa-check"></i>
                    Подтвержден
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['confirmed_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['paid_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-1 text-purple">
                <span class="fw-bold">
                    <i class="fa-solid fa-check"></i>
                    Оплачен
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['paid_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['transited_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-1 text-orange">
                <span class="fw-bold">
                    <i class="fa-solid fa-person-walking"></i>
                    В пути
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['transited_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['delivered_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-1 text-success">
                <span class="fw-bold">
                    <i class="fa-solid fa-check-double"></i>
                    Доставлен
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['delivered_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['returned_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-1 text-secondary">
                <span class="fw-bold">
                    <i class="fa-solid fa-rotate-left"></i>
                    Возврат
                </span>
                <br><small class="text-secondary"><?=dateModify($order['returned_at'])?></small>
            </div>
        <?php endif; ?>

        <?php if ($order['canceled_at'] != '1999-11-11 00:00:00') : ?>
            <div class="mb-2 text-danger">
                <span class="fw-bold">
                    <i class="fas fa-times"></i>
                    Отменен
                </span>
                <br>
                <small class="text-secondary"><?=dateModify($order['canceled_at'])?></small>
            </div>
        <?php endif; ?>

    </div>
</div>