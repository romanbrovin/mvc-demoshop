<div class="content_basket mt-4">

    <?php $basketData = R::findAll('m_basket', 'order_id = ?', [$order['id']]) ?>
    <?php foreach ($basketData as $basket) : ?>

        <?php $product = \app\models\Product::getById($basket['product_id']); ?>

        <div class="row">
            <div class="col-xxl-5 col-xl-4 col-lg-5 col-md-5 col-sm-3 col-12 text-center mb-3">
                <a href="/catalog/<?=$product['category_url']?>/<?=$product['article']?>">
                    <img alt="" class="img-fluid" loading="lazy" src="<?=$product['avatar']?>">
                </a>
            </div>
            <div class="col-xxl-7 col-xl-8 col-lg-7 col-md-7 col-sm-9 col-12 mb-3">
                <div class="h5 mb-0">
                    <a href="/catalog/<?=$product['category_url']?>/<?=$product['article']?>">
                        <?=$product['name']?>, <?=$product['article']?>
                    </a>
                </div>
                <div class="small text-secondary">
                    <?=$product['category_name']?>
                </div>
                <div>
                    <?php if ($product['tag_low_price'] == 1) : ?>
                        <span class="badge bg-orange">
                            Гарантия низкой цены
                        </span>
                    <?php endif; ?>

                    <?php if ($product['tag_hit'] == 1) : ?>
                        <span class="badge bg-red">
                            <i class="fa-brands fa-hotjar"></i> Хит продаж
                        </span>
                    <?php endif; ?>

                    <?php if ($product['tag_rare'] == 1) : ?>
                        <span class="badge bg-indigo">
                            Редкий набор
                        </span>
                    <?php endif; ?>

                    <?php if ($product['tag_new'] == 1) : ?>
                        <span class="badge bg-teal">
                            Новинка
                        </span>
                    <?php endif; ?>
                </div>
                <div class="mt-2 text-end">
                    <div class="d-inline-block small"><?=$basket['amount']?> шт.</div>

                    <div class="d-inline-block fw-bold">
                        <?php if ($product['price_adv_discount_sum'] > 0) : ?>
                            <del class="text-secondary font-14 fw-normal"><?=rank($product['price_adv'])?> ₽</del>
                            <?=rank($product['price_adv_discount'])?> ₽
                        <?php else : ?>
                            <?=rank($basket['price_adv'])?> ₽
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    <?php endforeach; ?>

</div>