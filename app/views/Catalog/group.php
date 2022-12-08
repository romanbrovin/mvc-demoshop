<?php use app\models\App; ?>

<div class="d-flex">
    <h1 class="marker">
        <span class="marker_h1">
            <?=$meta['ico']?> <?=$meta['caption']?>
        </span>
    </h1>
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

<?php App::renderBlock('facts'); ?>
<?php App::renderBlock('block'); ?>
