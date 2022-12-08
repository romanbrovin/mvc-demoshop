<div class="item__content row">

    <?php if ($item['tbl_name'] == 'order') : ?>
        <div class="col-12">
            <a href="/adm/order?s_order_id=<?=$item['tbl_id']?>">
                Заказ <?=$item['tbl_id']?>
            </a>
        </div>
    <?php elseif ($item['tbl_name'] == 'storage') : ?>
        <?php $storage = R::load('m_storage', $item['tbl_id']); ?>
        <?php $product = R::load('m_product', $storage['product_id']); ?>
        <div class="col-12">
            <a href="/adm/storage?s_product_id=<?=$product['id']?>">
                Арт.
                <?=$product['article']?>
            </a>
            <span class="text-secondary font-12">
                ID <?=$item['tbl_id']?>
            </span>
        </div>
    <?php elseif ($item['tbl_name'] == 'costs') : ?>
        <?php $costs = R::load('m_costs', $item['tbl_id']); ?>
        <?php $costCategory = R::load('m_cost_category', $costs['cost_category_id']); ?>
        <div class="col-12">
            <a href="/adm/costs?s_cost_category_id=<?=$costs['cost_category_id']?>">
                <?=$costCategory['name']?>
            </a>
            <span class="text-secondary font-12">
                ID <?=$item['tbl_id']?>
            </span>

        </div>
    <?php endif; ?>

</div>