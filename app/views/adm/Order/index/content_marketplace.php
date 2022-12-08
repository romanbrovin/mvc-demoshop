<div class="content_marketplace">

    <?php if ($item['marketplace'] == 'adv'): ?>

        <div>
            <?php if ($item['delivery_type'] == 'mail') : ?>
                <span class="badge bg-indigo">
                    <?=($item['delivery_variant'] == 'pvz') ? 'Пункт выдачи заказов' : 'Курьером до двери';?>
                </span>
            <?php elseif ($item['delivery_type'] == 'courier') : ?>
                <span class="badge bg-indigo">
                    Курьером по городу
                </span>
            <?php endif; ?>
        </div>

        <?php if ($item['address'] != '') : ?>
            <div class="mb-1 mt-1">
                <code><?=$item['address']?></code>
            </div>
        <?php endif; ?>

        <?php if ($item['comment_user']) : ?>
            <div class="small">
                <mark><?=$item['comment_user']?></mark>
            </div>
        <?php endif; ?>

    <?php else: ?>

        <div class="d-inline-block me-1">
            <span class="badge bg-teal">
                <?=strtoupper($item['marketplace'])?>
            </span>
        </div>

        <div class="d-inline-block small">
            <?php if ($item['marketplace_order']) : ?>
                <span data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Номер заказа" data-bs-toggle="tooltip">
                    <?=$item['marketplace_order']?>
                </span>

                <?php if ($item['can_cancel'] == 1) : ?>
                    <a class="marketplace-order mx-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                       data-bs-title="Редактировать номер заказа" data-bs-toggle="tooltip"
                       href="#">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                <?php endif; ?>
            <?php else : ?>
                <?php if ($item['can_cancel'] == 1) : ?>
                    <a class="marketplace-order" href="#">
                        <i class="fa-regular fa-square-plus"></i>
                        Номер заказа
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</div>
