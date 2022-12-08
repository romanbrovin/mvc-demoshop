<div class="item__header row">
    <div class="col-12 d-flex">

        <div class="h4">
            <?=$item['id']?>
        </div>

        <div class="mx-2">
            <?php if ($item['current_status'] == 'new') : ?>
                <span class="badge bg-secondary order__status cursor-help">
                    Новый
                </span>
                <small class="text-secondary"><?=$item['created_at']?></small>
            <?php elseif ($item['current_status'] == 'checkouted') : ?>
                <span class="badge bg-warning order__status cursor-help">
                    <?=($item['payment'] == 1) ? 'Ожидает оплаты' : 'Ожидает подтверждения'?>
                </span>
                <small class="text-secondary"><?=$item['checkouted_at']?></small>
            <?php elseif ($item['current_status'] == 'confirmed') : ?>
                <span class="badge bg-purple order__status cursor-help">
                    Подтвержден
                </span>
                <small class="text-secondary"><?=$item['confirmed_at']?></small>
            <?php elseif ($item['current_status'] == 'paid') : ?>
                <span class="badge bg-purple order__status cursor-help">
                    Оплачен
                </span>
                <small class="text-secondary"><?=$item['paid_at']?></small>
            <?php elseif ($item['current_status'] == 'transited') : ?>
                <span class="badge bg-orange order__status cursor-help">
                    В пути
                </span>
                <small class="text-secondary"><?=$item['transited_at']?></small>
            <?php elseif ($item['current_status'] == 'delivered') : ?>
                <span class="badge bg-success order__status cursor-help">
                    Доставлен
                </span>
                <small class="text-secondary"><?=$item['delivered_at']?></small>
            <?php elseif ($item['current_status'] == 'canceled') : ?>
                <span class="badge bg-danger order__status cursor-help">
                    Отменен
                </span>
                <small class="text-secondary"><?=$item['canceled_at']?></small>
            <?php elseif ($item['current_status'] == 'written_off') : ?>
                <span class="badge bg-dark">
                    Списан
                </span>
                <small class="text-secondary"><?=$item['written_off_at']?></small>
            <?php elseif ($item['current_status'] == 'returned') : ?>
                <?php if ($item['written_off_at'] != '11.11.1999 00:00') : ?>
                    <span class="badge bg-dark">Списан</span>
                <?php elseif ($item['delivered_at'] != '11.11.1999 00:00') : ?>
                    <span class="badge bg-success">Доставлен</span>
                <?php endif; ?>
                <span class="badge bg-secondary order__status cursor-help">
                    Возврат
                </span>
                <small class="text-secondary"><?=$item['returned_at']?></small>
            <?php endif; ?>
        </div>

        <div class="order-status status_<?=$item['id']?>">
            <div class="fw-bold">
                Статус заказа
            </div>

            <div class="mt-2 text-secondary">
                <div class="point border border-secondary"></div>
                <strong>создан</strong>
                <small class="text-secondary"><?=$item['created_at']?></small>
            </div>

            <?php if ($item['checkouted_at'] != '11.11.1999 00:00') : ?>
                <div class="text-warning">
                    <div class="point bg-warning"></div>
                    <strong>
                        <?=($item['payment'] == 1) ? 'ожидает оплаты' : 'ожидает подтверждения'?>
                    </strong>
                    <small class="text-secondary"><?=$item['checkouted_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['confirmed_at'] != '11.11.1999 00:00') : ?>
                <div class="text-purple">
                    <div class="point bg-purple"></div>
                    <strong>подтвержден</strong>
                    <small class="text-secondary"><?=$item['confirmed_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['paid_at'] != '11.11.1999 00:00') : ?>
                <div class="text-purple">
                    <div class="point bg-purple"></div>
                    <strong>оплачен</strong>
                    <small class="text-secondary"><?=$item['paid_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['transited_at'] != '11.11.1999 00:00') : ?>
                <div class="text-orange">
                    <div class="point bg-orange"></div>
                    <strong>в пути</strong>
                    <small class="text-secondary"><?=$item['transited_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['delivered_at'] != '11.11.1999 00:00') : ?>
                <div class="text-success">
                    <div class="point bg-success"></div>
                    <strong>доставлен</strong>
                    <small class="text-secondary"><?=$item['delivered_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['canceled_at'] != '11.11.1999 00:00') : ?>
                <div class="text-danger">
                    <div class="point bg-danger"></div>
                    <strong>отменен</strong>
                    <small class="text-secondary"><?=$item['canceled_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['written_off_at'] != '11.11.1999 00:00') : ?>
                <div class="">
                    <div class="point bg-dark"></div>
                    <strong>списан</strong>
                    <small class="text-secondary"><?=$item['written_off_at']?></small>
                </div>
            <?php endif; ?>

            <?php if ($item['returned_at'] != '11.11.1999 00:00') : ?>
                <div class="text-secondary">
                    <div class="point bg-secondary"></div>
                    <strong>возврат</strong>
                    <small class="text-secondary"><?=$item['returned_at']?></small>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>