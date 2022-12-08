<?php use app\models\App; ?>

<div class="d-flex">
    <h1 class="marker">
        <span class="marker_h1">Каталог товаров в демо-магазине</span>
    </h1>
</div>

<div class="d-flex mt-3">
    <h2 class="marker">
        <span class="marker_h2">Серии наборов товаров</span>
    </h2>
</div>

<div class="row mt-3">
    <?php $categories = App::getCategories(); ?>
    <?php foreach ($categories as $category): ?>
        <div class="categories col-lg-1 col-md-2 col-sm-3 col-4 mb-3 text-center" data-bs-custom-class="tooltip"
             data-bs-placement="top" data-bs-title="<?=$category['name']?>" data-bs-toggle="tooltip">
            <a href="/catalog/<?=$category['url']?>">
                <img alt="<?=$category['name']?>" class="img-fluid" loading="lazy"
                     src="<?=isImageExist("/uploads/goods/$category[url]/thumb-$category[photo]")?>">
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex mt-3 mb-3">
    <h2 class="marker">
        <span class="marker_h2">Наборы по группам</span>
    </h2>
</div>

<?php $groupMeta = require ROOT . '/config/group_meta.php'; ?>
<?php foreach (array_keys($groupMeta) as $item) : ?>
    <?php if ($groupMeta[$item]['navCaption']) : ?>
        <div class="d-inline-block me-3">
            <a href="/group/<?=$item?>">
                <h4><?=$groupMeta[$item]['ico']?> <?=$groupMeta[$item]['navCaption']?></h4>
            </a>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php App::renderBlock('sort', ['sort' => $sort]); ?>

<div class="row g-3">
    <?php foreach ($products as $product) : ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <?php App::renderBlock('post', ['product' => $product]); ?>
        </div>
    <?php endforeach; ?>
</div>

<?=($pagination->countPages > 1) ? $pagination : ''?>

<?php App::renderBlock('facts'); ?>
<?php App::renderBlock('block'); ?>
