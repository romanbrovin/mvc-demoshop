<div class="d-flex">
    <h2 class="marker">
        <span class="marker_h2"><?=$meta['h2']?></span>
    </h2>
</div>

<div class="row mt-4">
    <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10 col-12">
        <form class="row" id="form">
            <input type="hidden" id="id" name="id" value="<?=$item['id']?>">

            <?php foreach ($marketplaceList as $marketplace) : ?>
                <?php $name = $marketplace['short_name']; ?>
                <?php $tooltip = $marketplace['tooltip']; ?>

                <div class="d-flex mt-4 mb-2">
                    <h4 class="marker me-2">
                        <span class="marker_h4">
                            <?=mb_strtoupper($name)?>
                        </span>
                    </h4>
                    <div><?=$tooltip?></div>
                </div>

                <div class="col-6 mb-1">
                    <div class="form-floating">
                        <input class="form-control" id="price_<?=$name?>_discount" min="0"
                               name="price_<?=$name?>_discount" type="number"
                               value="<?=$item["price_{$name}_discount"]?>">
                        <label for="price_<?=$name?>_discount">Цена со скидкой, ₽</label>
                        <div class="invalid-feedback">Введите цену со скидкой</div>
                        <div class="feedback-short d-none">цену со скидкой</div>
                    </div>
                </div>

                <div class="col-6 mb-1">
                    <div class="form-floating">
                        <input class="form-control" id="price_<?=$name?>" min="0"
                               name="price_<?=$name?>" type="number" value="<?=$item["price_$name"]?>">
                        <label for="price_<?=$name?>">Цена без скидки, ₽</label>
                        <div class="invalid-feedback">Введите цену без скидки</div>
                        <div class="feedback-short d-none">цену без скидки</div>
                    </div>
                </div>

                <div class="col-12 mb-3 text-secondary small">
                    Скидка:
                    <span id="price_<?=$name?>_discount_sum">
                        <?=rank($item["price_{$name}_discount_sum"])?>
                    </span> ₽
                    или
                    <span id="price_<?=$name?>_discount_percent">
                        <?=rank($item["price_{$name}_discount_percent"])?>
                    </span>%
                </div>

                <?php if ($name == 'adv') : ?>
                    <div class="col-6 mb-1">
                        <div class="form-floating">
                            <input class="form-control" id="bonus" min="0" name="bonus" type="number"
                                   value="<?=$item['bonus']?>">
                            <label for="bonus">Бонус за покупку, %</label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>


        </form>

        <div class="row mt-5 mb-3">
            <div class="col-6">
                <a class="btn btn-secondary btn__back" href="#">Назад</a>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-primary btn__set_prices" type="button">Сохранить</button>
            </div>
        </div>

    </div>
</div>

<div class="mb-5 text-secondary small">
    <?php app\models\App::renderBlock('adm/info', ['position' => 'vertical', 'var' => $item]); ?>
</div>