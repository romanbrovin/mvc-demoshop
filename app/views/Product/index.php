<?php use app\models\App; ?>
<?php use vendor\libs\Slider; ?>

<div class="product">

    <div class="d-flex mb-2">
        <h1 class="marker">
            <span class="marker_h1">
                <?=$product['name']?>
            </span>
        </h1>
    </div>

    <div class="d-flex mb-3">
        <h2 class="marker">
            <span class="marker_h2">Товар <?=$product['category_name']?> <?=$product['article']?></span>
        </h2>
    </div>

    <div class="col-xxl-10 col-xl-12 col-md-12 product__info">
        <div class="row">

            <div class="col-xl-5 col-lg-5 col-md-12">
                <?php include 'owl_carousel.php'; ?>
            </div>

            <div class="col-xl-7 col-lg-6 col-md-12 product__info-right">
                <?php include 'product__info.php'; ?>
            </div>

        </div>
    </div>


    <?php if ($product['amount_active'] > 0 && $product['price_adv_discount'] > 0) : ?>
        <div class="mt-5">
            <div class="h4">
                <span>🔥</span>&nbsp;Продается новый набор. Коробка запечатана и с заводскими пломбами. Оригинал.
            </div>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <span>👉</span>&nbsp;Возраст: <?=$product['age']?>+
                </li>
                <li class="list-inline-item">
                    <span>👉</span>&nbsp;Количество деталей: <?=$product['parts']?>
                </li>
                <li class="list-inline-item">
                    <span>👉</span>&nbsp;Год выпуска: <?=$product['year']?>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($product['description']) : ?>
        <div class="row mt-5">
            <div class="col-xl-8 col-lg-7 col-md-12">
                <h3>Описание</h3>
                <h4>Товар <?=$product['category_name']?> <?=$product['article']?> <?=$product['name']?></h4>
                <p>
                    <?php
                    // временная конструкция
                    preg_match('/<strong.*strong><br><br>/', $product['description'], $output);
                    $product['description'] = str_replace($output, '', $product['description']);
                    ?>

                    <?=htmlspecialchars_decode($product['description'])?>
                </p>
            </div>

            <div class="col-xl-4 col-lg-5 col-md-12">
                <?php App::renderBlock('block/review'); ?>
                <?php App::renderBlock('block/ozon'); ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php Slider::renderByCategoryId($product['category_id']); ?>
<?php App::renderBlock('facts'); ?>
<?php Slider::renderByGroupName('populars'); ?>

