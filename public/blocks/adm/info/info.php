<?php if ($position == 'horizontal') : ?>
    <span class="me-1">ID <?=$var['id']?></span>

    <?php if ($var['created_at'] != $var['updated_at'] && $var['updated_at'] != '11.11.1999 00:00') : ?>
        <span class="me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
              data-bs-title="Дата обновления" data-bs-toggle="tooltip">
            <?=$var['updated_at']?>
        </span>
    <?php else : ?>
        <span class="me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
              data-bs-title="Дата создания" data-bs-toggle="tooltip">
            <?=$var['created_at']?>
        </span>
    <?php endif; ?>

<?php elseif ($position == 'vertical') : ?>

    <div>ID <?=$var['id']?></div>
    <div>Создано <?=$var['created_at']?></div>
    <?php if ($var['created_at'] != $var['updated_at'] && $var['updated_at'] != '11.11.1999 00:00') : ?>
        <div>Обновлено <?=$var['updated_at']?></div>
    <?php endif; ?>

<?php endif; ?>