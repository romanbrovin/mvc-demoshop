<div class="d-flex justify-content-center">
    <h1 class="marker text-center">
        <span class="marker_h1">Демо магазин</span>
    </h1>
</div>

<div class="mt-4 mb-4 text-center">
    <h2>Продажа товаров народного потребления</h2>
    <div class="h4">
    Наш интернет-магазин имеет возможность предоставить вам максимально широкий ассортимент товаров в наличии и высочайшее качество продукции.
    </div>
</div>

<?php \vendor\libs\Slider::renderByGroupName('bestsellers'); ?>
<?php \vendor\libs\Slider::renderByGroupName('populars'); ?>
<?php \vendor\libs\Slider::renderByGroupName('sales'); ?>

<?php \app\models\App::renderBlock('facts'); ?>

<?php \vendor\libs\Slider::renderByGroupName('news'); ?>
<?php \vendor\libs\Slider::renderByGroupName('rares'); ?>

<?php \app\models\App::renderBlock('block'); ?>