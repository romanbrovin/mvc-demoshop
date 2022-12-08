<div class="content_addon me-2 mt-1 d-inline-block align-top">
    <div class="px-2 d-flex align-top">

        <?php if ($item['bonus'] > 0) : ?>
            <div class="d-inline-block me-3">
                <div class="font-10 text-gray-500">
                    Бонус
                </div>
                <div class="font-14">
                    <?=$item['bonus']?>%
                </div>
            </div>
        <?php endif; ?>

        <div class="d-inline-block me-3">
            <div class="font-10 text-gray-500">
                Год
            </div>
            <div class="font-14">
                <?=$item['year']?>
            </div>
        </div>

        <div class="d-inline-block">
            <div class="font-10 text-gray-500">
                Габариты
            </div>
            <div class="font-14" data-bs-custom-class="tooltip" data-bs-placement="left"
                 data-bs-title="Товара" data-bs-toggle="tooltip">
                <?=$item['length']?>x<?=$item['width']?>x<?=$item['height']?>,
                <?=$item['weight']?>
            </div>
            <?php if ($item['height_pack'] > 0) : ?>
                <div class="mt--2 font-12 text-secondary" data-bs-custom-class="tooltip" data-bs-placement="left"
                     data-bs-title="Упаковки" data-bs-toggle="tooltip">
                    <?=$item['length_pack']?>x<?=$item['width_pack']?>x<?=$item['height_pack']?>,
                    <?=$item['weight_pack']?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>