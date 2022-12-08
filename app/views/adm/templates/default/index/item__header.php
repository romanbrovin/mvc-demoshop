<?php if (in_array('header', $meta['item']['blocks'])) : ?>

    <div class="item__header row">

        <div class="col-12 overflow-hidden">
            <h4 class="marker fw-normal">
                <?php $h4 = $pathOwn . 'item__header_h4.php'; ?>
                <?php if (is_file($h4)) : ?>
                    <?php include $h4; ?>
                <?php else : ?>
                    <?=$meta['item']['header']['h4'] ?? 'Запись';?>
                    <?=$item['id']?>
                <?php endif; ?>
            </h4>
        </div>

    </div>

<?php endif; ?>
