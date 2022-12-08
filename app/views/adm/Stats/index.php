<div class="row mb-2">
    <div class="col-xl-8 col-lg-7 col-md-12 col-12 d-flex">
        <h2 class="marker">
            <span class="marker_h2"><?=$meta['h2']?></span>
        </h2>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-12 d-flex justify-content-end">
        <h5 class="fw-bold"><?=$total['amount']?> шт. <?=rank($total['costs'])?> ₽</h5>
    </div>
</div>


<div>
    <a href="/adm/stats/reload">
        Обновить данные
    </a>
</div>

<?php $params = ['route' => $meta['route'], 'sort' => $sort, 'pagination' => $pagination]; ?>
<?php app\models\App::renderBlock('adm/sort', $params); ?>

<table class="table table-hover table-sm mt-4">
    <thead>
    <tr>
        <th>Товар, арт.</th>
        <th>Продано, шт.</th>
        <th>На складе, шт.</th>
        <th>На складе, ₽</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $item) : ?>
        <?php $product = R::load('m_product', $item['product_id']); ?>

        <tr>
            <td>
                <a href="/adm/product?s_product_id=<?=$product['id']?>">
                    <?=$product['article']?>
                </a>
            </td>
            <td><?=$item['amount_sells']?></td>
            <td><?=$item['amount_storage']?></td>
            <td><?=rank($item['total_costs'])?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

<?=($pagination->countPages > 1) ? $pagination : '';?>