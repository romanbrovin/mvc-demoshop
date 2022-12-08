<?php use app\models\App; ?>

<div class="row">
    <div class="col-lg-1 col-md-2 d-none d-md-block pt-2">
        <img alt="Категория <?=$category['name']?>"
             class="img-fluid" loading="lazy"
             src="<?=isImageExist("/uploads/goods/$category[url]/thumb-$category[photo]")?>">
    </div>
    <div class="col-lg-11 col-md-10 col-sm-12 px-3">
        <div class="d-flex">
            <h1 class="marker">
                <span class="marker_h1">
                    Серия товаров
                    <br>
                    <?=$category['name']?>
                </span>
            </h1>
        </div>
    </div>
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

<?php if ($category['description']): ?>

    <div class="d-flex mt-5">
        <h2 class="marker">
            <span class="marker_h2">Описание серии <?=$category['name']?></span>
        </h2>
    </div>

    <div class="mt-3">
        <?=htmlspecialchars_decode($category['description'])?>
    </div>
<?php endif; ?>

<?php App::renderBlock('facts'); ?>
<?php App::renderBlock('block'); ?>
