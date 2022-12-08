<div class="d-flex">
    <h2 class="marker">
        <span class="marker_h2"><?=$meta['h2']?></span>
    </h2>
</div>

<div class="row mt-4">
    <div class="col-xl-8 col-lg-12">

        <form class="row" id="form">
            <input type="hidden" id="id" name="id" value="<?=$item['id']?>">
            <?php
            if (isset($meta['block'])) {
                require_once APP . "/views/adm/templates/default/edit/{$meta['block']}.php";
            } else {
                require_once APP . "/views/adm/{$meta['route']['controller']}/edit.php";
            }
            ?>
        </form>

        <div class="row mt-5 mb-3">
            <div class="col-6">
                <a class="btn btn-secondary btn__back" href="#">Назад</a>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-primary btn__save" type="button">Сохранить</button>
            </div>
        </div>

    </div>
</div>

<div class="mb-5 text-secondary small">
    <?php app\models\App::renderBlock('adm/info', ['position' => 'vertical', 'var' => $item]); ?>

    <?php if (isset($item['uid'])) : ?>
        <div>UID <?=$item['uid']?></div>
    <?php endif; ?>

    <?php if (isset($item['ip'])) : ?>
        <div><?=$item['ip']?></div>
    <?php endif; ?>

    <?php if (isset($item['ua'])) : ?>
        <div><?=$item['ua']?></div>
    <?php endif; ?>
</div>