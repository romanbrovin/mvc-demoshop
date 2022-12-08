<div class="row position-relative">

    <div class="product__notice p-0">
        <?php if ($product['tag_low_price'] == 1): ?>
            <div class="product-notice">
                <span class="bg-orange">Гарантия низкой цены</span>
            </div>
        <?php endif; ?>

        <?php if ($product['tag_rare'] == 1) : ?>
            <div class="product-notice">
                <span class="bg-indigo">Редкий набор</span>
            </div>
        <?php endif; ?>

        <?php if ($product['tag_hit'] == 1) : ?>
            <div class="product-notice">
                <span class="bg-red"><i class="fa-brands fa-hotjar"></i> Хит продаж</span>
            </div>
        <?php endif; ?>

        <?php if ($product['tag_new'] == 1) : ?>
            <div class="product-notice">
                <span class="bg-teal">Новинка</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="product__features col-lg-12 col-md-6">
        <h3>Характеристики</h3>
        <ul>
            <li>Артикул: <?=$product['article']?></li>
            <li>
                Серия:
                <a href="/catalog/<?=$product['category_url']?>"><?=$product['category_name']?></a>
            </li>
            <li>Возраст: <?=$product['age']?>+</li>
            <li>Количество деталей: <?=$product['parts']?></li>
            <?php if ($product['figures'] > 0) : ?>
                <li>Количество фигурок: <?=$product['figures']?></li>
            <?php endif; ?>
            <li>
                Габариты:
                <?=$product['length']?>x<?=$product['width']?>x<?=$product['height']?> см.
            </li>
            <li>Год выпуска: <?=$product['year']?></li>
        </ul>
    </div>

    <div class="col-lg-12 col-md-6">

        <?php if ($product['amount_active'] == 0 || $product['price_adv_discount'] == 0) : ?>

            <div class="product__out">
                <div class="mt-5 fs-2">
                    Нет в наличии
                </div>
                <?php if ($product['is_soon'] == 1) : ?>
                    <div class="mt-1 fs-5">
                        <i class="fas fa-hourglass-half"></i> Скоро в продаже
                    </div>
                <?php endif; ?>
            </div>

        <?php else: ?>

            <?php if ($product['price_adv_discount_sum'] == 0) : ?>

                <div class="product__price mb-4">
                    <?=rank($product['price_adv_discount'])?> ₽
                </div>

            <?php else: ?>

                <div class="d-flex">

                    <div class="align-self-center">
                        <div class="font-18 text-secondary">
                            Старая цена:
                            <del><?=rank($product['price_adv'])?> ₽</del>
                        </div>
                        <div class="product__price product__price_discount">
                            <?=rank($product['price_adv_discount'])?> ₽
                        </div>
                    </div>

                    <div class="discount discount_product" data-bs-toggle="tooltip"
                         data-bs-placement="right" data-bs-custom-class="tooltip"
                         data-bs-title="Скидка">
                        <div class="d-flex justify-content-center">
                            <div class="discount__substrate discount__substrate_product">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div class="align-self-center discount__text discount__text_product">
                                <?=$product['price_adv_discount_percent']?>%
                            </div>
                        </div>
                    </div>

                </div>

            <?php endif; ?>

            <div class="product__basket">
                <button class="btn btn-success btn-lg basket__add"
                        data-product-id="<?=$product['id']?>">
                    <?php if (\app\models\Basket::isProductInBasket($product['id'])) : ?>
                        <i class="fas fa-cart-arrow-down"></i> В корзину
                    <?php else : ?>
                        <i class="fa-solid fa-check"></i> В корзине
                    <?php endif; ?>
                </button>
            </div>

            <div class="product__block">
                <?php if ($product['bonus'] > 0) : ?>
                    <div class="product__bonus">
                        Бонус за покупку:
                        <?=calcPercent($product['price_adv_discount'], $product['bonus'])?> ₽
                    </div>
                <?php endif; ?>

                <div class="product__remaining">
                    Наличие на складе
                    <?php if ($product['amount_active'] <= 2) : ?>
                        <div class="point bg-danger"></div>
                        мало
                    <?php elseif ($product['amount_active'] > 2 && $product['amount_active'] <= 5) : ?>
                        <div class="point bg-warning"></div>
                        <div class="point bg-warning"></div>
                        несколько
                    <?php elseif ($product['amount_active'] > 5) : ?>
                        <div class="point bg-success"></div>
                        <div class="point bg-success"></div>
                        <div class="point bg-success"></div>
                        много
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>

</div>