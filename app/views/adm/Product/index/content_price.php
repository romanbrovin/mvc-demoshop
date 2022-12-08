<div class="content_price d-inline-block align-top">
    <div class="booble booble_product">

        <?php foreach ($marketplaceList as $marketplace) : ?>
            <?php $name = $marketplace['short_name']; ?>
            <?php $tooltip = $marketplace['tooltip']; ?>

            <div class="d-inline-block me-3 align-top">

                <div class="font-10 text-gray-500 mt-1">

                    <div class="fw-bold">
                        <span data-bs-custom-class="tooltip" data-bs-placement="top"
                              data-bs-title="<?=$tooltip?>" data-bs-toggle="tooltip">
                            <?=mb_strtoupper($name)?>
                        </span>
                    </div>

                    <?php if ($item["price_{$name}_profit"] > 0) : ?>
                        <div class="fw-light">
                            <div>Ожидаемая прибыль</div>
                            <div>
                                <?=rank($item["price_{$name}_profit"])?> ₽
                                или <?=$item["price_{$name}_profit_percent"]?>%
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($item["price_{$name}_discount"] > 0) : ?>
                    <div class="fw-bold">
                        <?=rank($item["price_{$name}_discount"])?> ₽
                    </div>
                <?php endif; ?>

                <?php if ($item["price_$name"] > 0 && $item["price_{$name}_discount"] != $item["price_$name"]) : ?>
                    <div class="font-12 text-secondary mt--2">
                        <del><?=rank($item["price_$name"])?> ₽</del>
                    </div>
                <?php endif; ?>


                <?php if ($item["price_{$name}_discount"] == 0 && $item["price_$name"] == 0) : ?>
                    <div class="font-10 mt-1 text-center" data-bs-custom-class="tooltip" data-bs-placement="top"
                         data-bs-title="Нет в продаже" data-bs-toggle="tooltip">
                        <i class="fa-solid fa-ban text-danger fa-2x"></i>
                    </div>
                <?php else : ?>
                    <?php if ($item["price_{$name}_discount"] <= $item['price_avg']) : ?>
                        <div class="font-10 mt-1 text-center" data-bs-custom-class="tooltip" data-bs-placement="top"
                             data-bs-title="Без прибыли" data-bs-toggle="tooltip">
                            <i class="fa-solid fa-triangle-exclamation text-danger fa-2x"></i>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>
</div>