<div class="row mb-2">
    <div class="col-xl-8 col-lg-7 col-md-12 col-12 d-flex">
        <h2 class="marker">
            <span class="marker_h2"><?=$meta['h2']?></span>
        </h2>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-12 d-flex justify-content-end">
        <?php if (isset($meta['h5'])) : ?>
            <h5 class="fw-bold"><?=$meta['h5']?></h5>
        <?php endif; ?>
    </div>
</div>

<?php

$pathDefault = ADM . "/templates/default/index/";
$pathOwn = ADM . "/{$meta['route']['controller']}/index/";


$nav__links = "{$pathOwn}nav__links.php";
if (!is_file($nav__links)) {
    $nav__links = "{$pathDefault}nav__links.php";
}

include_once $nav__links;


if (in_array('block-sort', $meta['addons'])) {
    $params = ['route' => $meta['route'], 'sort' => $sort, 'pagination' => $pagination];
    app\models\App::renderBlock('adm/sort', $params);
}


$arrItemBlocks = ['header', 'content', 'navbar', 'footer'];
foreach ($arrItemBlocks as $block) {
    ${'item__' . $block} = "{$pathOwn}item__$block.php";

    if (!is_file(${'item__' . $block})) {
        ${'item__' . $block} = "{$pathDefault}item__$block.php";
    }
}

$col = 'col-xxl-4 col-xl-6 col-lg-6 col-md-12 col-12';
if (isset($meta['item']['col'])) {
    if ($meta['item']['col'] == 2) {
        $col = 'col-lg-6 col-md-12';
    } else if ($meta['item']['col'] == 1) {
        $col = 'col-12';
    }
}

?>

<div class="row mt-4">
    <?php foreach ($list as $item) :
        $item = dateModifyInArray($item);

        $class = 'border-secondary bg-white';

        if (
            (isset($item['amount_active']) && $item['amount_active'] == 0) ||
            (isset($item['is_hidden']) && $item['is_hidden'] == 1)
        ) {
            $class = 'bg-gray-200';
        }
        ?>

        <div class="item <?=$col?>" id="<?=$item['id']?>">
            <div class="border rounded p-3 mb-3 <?=$class?>">
                <?php include $item__header; ?>
                <?php include $item__content; ?>
                <?php include $item__navbar; ?>
                <?php include $item__footer; ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<?=($pagination->countPages > 1) ? $pagination : '';?>