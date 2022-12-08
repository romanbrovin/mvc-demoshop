<?php use app\models\App; ?>

<div class="slider-block">

    <div class="d-flex justify-content-center mb-3">
        <h2 class="marker">
            <?php if (isset($meta['url'])) : ?>
                <a href="/group/<?=$meta['url']?>">
                    <span class="marker_h2">
                        <?=$meta['ico']?> <?=$meta['sliderCaption']?>
                    </span>
                </a>
            <?php else : ?>
                <span class="marker_h2">
                    <?php if (isset($meta['ico']))
                        echo $meta['ico']; ?>
                    <?=$meta['sliderCaption']?>
                </span>
            <?php endif; ?>
        </h2>
    </div>

    <div class="owl-carousel owl-theme owl-slider">
        <?php foreach ($products as $product) : ?>
            <div class="m-2">
                <?php App::renderBlock('post', ['product' => $product]); ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
