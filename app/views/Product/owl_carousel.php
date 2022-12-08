<div class="owl-carousel owl-theme owl-product">

    <?php $pathToPhotos = "/uploads/goods/$product[category_url]/$product[article]"; ?>
    <?php foreach ($product['photo'] as $key => $photo) : ?>
        <?php
        $photoHref = "$pathToPhotos/$photo";
        $photoSrc = "$pathToPhotos/thumb/$photo";
        $key++;
        $photoAlt = "$product[category_name] $product[article] $product[name] (Фото $key)";
        ?>
        <div class="item">
            <a data-caption="<?=$photoAlt?>" data-fancybox="gallery" href="<?=$photoHref?>">
                <img alt="<?=$photoAlt?>" class="owl-lazy" data-src="<?=$photoSrc?>">
            </a>
        </div>
    <?php endforeach; ?>

    <?php if ($product['youtube'] != null) : ?>
        <div class="item-video">
            <a class="owl-video" href="<?=$product['youtube']?>"></a>
        </div>
    <?php endif; ?>

</div>