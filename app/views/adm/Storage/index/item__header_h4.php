<?php $product = R::load('m_product', $item['product_id']); ?>

<a href="/adm/product?s_product_id=<?=$product['id']?>">
    Арт. <?=$product['article']?>
</a>
