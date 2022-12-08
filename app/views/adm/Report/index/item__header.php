<div class="item__header row">

    <div class="col-xl-8 col-md-6 overflow-hidden">
        <div class="d-flex">
            <?php if ($item['tbl_name'] == 'order') : ?>
                <span class="badge bg-success me-1">Доход</span>
                <?php $order = R::load('m_order', $item['tbl_id']); ?>

                <?php if ($order['marketplace'] != 'adv') : ?>
                    <div class="d-inline-flex">
                        <span class="badge bg-teal">
                            <?=strtoupper($order['marketplace'])?>
                        </span>
                    </div>
                <?php else : ?>
                    <?php if ($order['current_status'] == 'written_off') : ?>
                        <div class="d-inline-flex">
                            <span class="badge bg-dark">
                                Списан
                            </span>
                        </div>
                    <?php else : ?>
                        <div class="d-inline-flex me-1">
                            <span class="badge bg-indigo">
                                На сайте
                            </span>
                        </div>
                        <?php if ($order['payment'] == 1) : ?>
                            <div class="d-inline-flex">
                                <span class="badge bg-pink">
                                    <i class="fa-regular fa-credit-card"></i>
                                    Картой
                                </span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php elseif ($item['tbl_name'] == 'storage') : ?>
                <span class="badge bg-danger me-1">Расход</span>
                <span class="badge bg-secondary me-1">Закупка</span>
            <?php elseif ($item['tbl_name'] == 'costs') : ?>
                <span class="badge bg-danger me-1">Расход</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 d-flex justify-content-end">
        <h5 class="fw-bold"><?=rank($item['amount'])?> ₽</h5>
    </div>

</div>
