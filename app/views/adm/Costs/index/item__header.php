<div class="item__header row">

    <div class="col-xl-8 col-md-6 overflow-hidden">
        <h4 class="fw-normal">
            <?php $costCaregory = R::load('m_cost_category', $item['cost_category_id']); ?>
            <?=$costCaregory['name']?>
        </h4>
    </div>

    <div class="col-xl-4 col-md-6 d-flex justify-content-end">
        <h5 class="fw-bold"><?=rank($item['amount'])?> ₽</h5>
    </div>

</div>
