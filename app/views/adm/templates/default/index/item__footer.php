<?php if (in_array('footer', $meta['item']['blocks'])) : ?>

    <div class="item__footer">
        <?php \app\models\App::renderBlock('adm/info', ['position' => 'horizontal', 'var' => $item]); ?>
    </div>

<?php endif; ?>