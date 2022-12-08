<div class="content_basket">

    <div class="d-flex mb-3">
        <h2 class="marker">
            <span class="marker_h2">
                Корзина
            </span>
        </h2>
    </div>

    <div class="bg-white border rounded p-4 py-0 pt-4">
        <?php foreach ($basket as $basketItem) : ?>
            <?php $product = \app\models\Product::getById($basketItem['product_id']); ?>

            <div class="row mb-3">

                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 mb-2">
                    <img alt="" class="img-fluid" src="<?=$product['avatar']?>">
                </div>

                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-12">
                    <a href="/catalog/<?=$product['category_url']?>/<?=$product['article']?>">
                        <span class="h4"><?=$product['name']?>, <?=$product['article']?></span>
                    </a>

                    <div class="text-secondary">
                        <?=$product['category_name']?>
                    </div>

                    <div class="small text-secondary">
                        <span class="me-1">👉 Возраст: <?=$product['age']?>+</span>
                        <span class="me-1">👉 Кол-во деталей: <?=$product['parts']?></span>
                        <span class="me-1">👉 Год выпуска: <?=$product['year']?></span>
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
                </div>

                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12 text-end">
                    <?php if ($product['price_adv_discount_sum'] > 0) : ?>
                        <div class="h5 fw-bold mb-1">
                            <?=rank($product['price_adv_discount'])?> ₽
                        </div>
                        <div class="h6">
                            <del><?=rank($product['price_adv'])?> ₽</del>
                        </div>
                    <?php else : ?>
                        <div class="h5 fw-bold">
                            <?=rank($product['price_adv_discount'])?> ₽
                        </div>
                    <?php endif; ?>

                    <div class="small"><?=$basketItem['amount']?> шт.</div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>