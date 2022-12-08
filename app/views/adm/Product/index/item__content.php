<?php $item = addAvatar($item); ?>

<div class="item__content row">

    <div class="col-xl-1 col-lg-2 col-md-2 text-center">
        <a href="/adm/product/photo?id=<?=$item['id']?>">
            <img alt="" class="img-fluid" loading="lazy" src="<?=$item['avatar']?>">
        </a>
    </div>

    <div class="col-xl-11 col-lg-10 col-md-10">
        <?php include 'content_price.php'; ?>
        <?php include 'content_addon.php'; ?>
        <?php include 'content_storage.php'; ?>
    </div>

</div>