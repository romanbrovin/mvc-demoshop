<div class="item__header row">

    <div class="col-xl-8 col-md-6 overflow-hidden">
        <h4 class="fw-normal">
            <a href="/adm/order?s_order_id=<?=$item['order_id']?>">
                Заказ <?=$item['order_id']?>
            </a>
        </h4>
    </div>

    <div class="col-xl-4 col-md-6 d-flex justify-content-end">
        <h5 class="fw-bold"><?=rank($item['sum'])?> ₽</h5>
    </div>

</div>
