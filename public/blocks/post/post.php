<?php use app\models\App; ?>
<?php use app\models\Basket; ?>

<?php $category = App::findCells('name, url', 'm_category', $product['category_id']); ?>

<?php $product['category_name'] = $category['name']; ?>
<?php $product['category_url'] = $category['url']; ?>
<?php $product = addAvatar($product); ?>

<div class="card post border">

    <?php if ($product['price_adv_discount_percent'] > 0) : ?>
        <div class="discount discount_post">
            <div class="d-flex justify-content-center">
                <div class="discount__substrate discount__substrate_post">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div class="align-self-center discount__text discount__text_post">
                    <?=$product['price_adv_discount_percent']?>%
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="post__image d-flex justify-content-center">
        <div class="align-self-center">
            <a href="/catalog/<?=$product['category_url']?>/<?=$product['article']?>">
                <img alt="<?=$product['alt']?>" class="img-fluid" loading="lazy" src="<?=$product['avatar']?>">
            </a>
        </div>
    </div>

    <div class="card-body p-1">

        <div class="post__notice">
            <?php if ($product['tag_low_price'] == 1) : ?>
                <div>
                    <span class="post__notice-item bg-orange">
                        Гарантия низкой цены
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($product['tag_hit'] == 1) : ?>
                <div>
                    <span class="post__notice-item bg-red">
                        <i class="fa-brands fa-hotjar"></i> Хит продаж
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($product['tag_rare'] == 1) : ?>
                <div>
                    <span class="post__notice-item bg-indigo">
                        Редкий набор
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($product['tag_new'] == 1) : ?>
                <div>
                    <span class="post__notice-item bg-teal">
                        Новинка
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="post__name d-flex justify-content-center">
            <h3 class="align-self-center">
                <a class="stretched-link" href="/catalog/<?=$product['category_url']?>/<?=$product['article']?>">
                    <?=$product['name']?>
                </a>
                <span class="text-secondary">
                    <?=$product['category_name']?> <?=$product['article']?>
                </span>
            </h3>
        </div>

        <ul class="post__features list-inline">
            <li class="list-inline-item">
                Деталей: <?=$product['parts']?>
            </li>
            <li class="list-inline-item">
                Возраст: <?=$product['age']?>+
            </li>
            <?php if ($product['figures'] > 0): ?>
                <br>
                <li class="list-inline-item">
                    Фигурок: <?=$product['figures']?>
                </li>
            <?php endif; ?>
            <li class="list-inline-item">
                Год выпуска: <?=$product['year']?>
            </li>
        </ul>

        <?php if ($product['amount_active'] == 0 || $product['price_adv_discount'] == 0) : ?>

            <div class="post__out">
                <div class="fs-5 mt-5">
                    Нет в наличии
                </div>

                <?php if ($product['is_soon'] == 1) : ?>
                    <div class="mt-2">
                        <i class="fas fa-hourglass-half"></i> Скоро в продаже
                    </div>
                <?php endif; ?>
            </div>

        <?php else : ?>

            <div class="post__price d-flex justify-content-center">
                <?php if ($product['price_adv_discount_sum'] > 0) : ?>
                    <div class="d-inline-block">
                        <div class="post__price-old">
                            <del><?=rank($product['price_adv'])?> ₽</del>
                        </div>
                        <div class="post__price-new post__price-new_discount">
                            <?=rank($product['price_adv_discount'])?> ₽
                        </div>
                    </div>
                <?php else : ?>
                    <div class="align-self-center">
                        <div class="post__price-new">
                            <?=rank($product['price_adv_discount'])?> ₽
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-center">

                <div class="post__basket">
                    <button class="btn btn-sm btn-success basket__add" data-product-id="<?=$product['id']?>">
                        <?php if (Basket::isProductInBasket($product['id'])) : ?>
                            <i class="fas fa-cart-arrow-down"></i> В корзину
                        <?php else : ?>
                            <i class="fa-solid fa-check"></i> В корзине
                        <?php endif; ?>
                    </button>
                </div>

                <?php if ($product['bonus'] > 0) : ?>
                    <div class="post__footer post__footer_bonus">
                        Бонус за покупку <?=calcPercent($product['price_adv_discount'], $product['bonus'])?> ₽
                    </div>
                <?php endif; ?>

                <div class="post__footer post__footer_remaining">
                    На складе
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