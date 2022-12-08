<div class="content_total">
    <div class="row">

        <?php if ($item['current_status'] != 'canceled') : ?>

            <?php if ($item['marketplace'] == 'adv'
                && $item['current_status'] != 'written_off' && $item['role'] == 'user') : ?>
                <div>
                    Стоимость заказа:
                    <strong>
                        <?=rank($item['order_sum'])?> ₽
                    </strong>
                </div>

                <div>
                    Доставка<?=($item['delivery_days']) ? ' (' . $item['delivery_days'] . '):' : ':';?>
                    <strong>
                        <?=($item['delivery_price'] == 0) ? 'бесплатно' : rank($item['delivery_price']) . ' ₽'?>
                    </strong>
                </div>

                <?php if ($item['cod'] > 0) : ?>
                    <div>
                        «Наложенный платеж»:
                        <strong>
                            <?=rank($item['cod'])?> ₽
                        </strong>
                    </div>
                <?php endif; ?>

                <?php if ($item['bonus'] > 0) : ?>
                    <div>
                        Списано бонусов:
                        <strong>
                            <?=rank($item['bonus'])?> ₽
                        </strong>
                    </div>
                <?php endif; ?>

                <div>
                    Оплата:
                    <strong>
                        <?=($item['payment'] == 1) ? 'на сайте' : 'при получении';?>
                    </strong>
                </div>

            <?php endif; ?>

            <div class="h5 fw-bold1 mt-2">
                Итого: <strong><?=rank($item['total_sum'])?> ₽</strong>
            </div>

            <?php if ($item['current_status'] == 'delivered' || $item['current_status'] == 'written_off') : ?>
                <div class="separator"></div>
                <div>
                    <span data-bs-custom-class="tooltip" data-bs-placement="top"
                          data-bs-title="Включает в себя закупку товара, доставку, наложенный платеж и списанные бонусы"
                          data-bs-toggle="tooltip">
                        Общий расход: <?=rank($item['costs'])?> ₽
                    </span>
                </div>
                <div class="h5 fw-bold mt-1">
                    Прибыль: <?=rank($item['profit'])?> ₽
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</div>
