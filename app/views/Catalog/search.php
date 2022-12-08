<?php use app\models\App; ?>
<?php use vendor\libs\Slider; ?>

<div class="fs-4 mt-4">
    Результаты поиска по запросу
    <span class="text-danger fw-bold"><?=$searchQuery?></span>
</div>

<?php if ($pagination->totalEntries) : ?>

    <div class="mb-5 text-secondary">
        Найдено совпадений: <?=$pagination->totalEntries?>
    </div>

    <?php App::renderBlock('sort', ['sort' => $sort]); ?>

    <div class="row g-3">
        <?php foreach ($products as $product) : ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <?php App::renderBlock('post', ['product' => $product]); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?=($pagination->countPages > 1) ? $pagination : ''?>

<?php else : ?>

    <div class="oops">
        По вашему запросу нет товара :-(
    </div>

    <?php Slider::renderByGroupName('populars'); ?>

<?php endif; ?>

<?php App::renderBlock('facts'); ?>
<?php App::renderBlock('block'); ?>
