<div class="row">
    <div class="col-11">
        <h3>
            <?php if ($order['current_status'] == 'new') : ?>
                <i class="fa-regular fa-file"></i>
            <?php elseif ($order['current_status'] == 'checkouted') : ?>
                <i class="fa-solid fa-pause text-warning"></i>
            <?php elseif ($order['current_status'] == 'confirmed') : ?>
                <i class="fa fa-check text-purple"></i>
            <?php elseif ($order['current_status'] == 'paid') : ?>
                <i class="fa fa-check text-purple"></i>
            <?php elseif ($order['current_status'] == 'transited') : ?>
                <i class="fa-solid fa-person-walking text-orange"></i>
            <?php elseif ($order['current_status'] == 'delivered') : ?>
                <i class="fa-solid fa-check-double text-success"></i>
            <?php elseif ($order['current_status'] == 'returned') : ?>
                <i class="fa-solid fa-rotate-left text-secondary"></i>
            <?php elseif ($order['current_status'] == 'canceled') : ?>
                <i class="fa-solid fa-times text-danger"></i>
            <?php endif; ?>

            <span class="marker_h3 order__status dotted mx-1">
                Заказ <?=$order['id']?>
            </span>
        </h3>
    </div>

    <?php if ($order['current_status'] == 'new' || $order['current_status'] == 'checkouted') : ?>
        <div class="col-1 p-0 d-flex justify-content-end">
            <div class="btn-round btn-round_delete order__cancel"></div>
        </div>
    <?php endif; ?>
</div>