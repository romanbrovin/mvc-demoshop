<div class="content_address mb-3 mt-4">

    <div class="d-flex mb-3">
        <h2 class="marker">
            <span class="marker_h2">
                Адрес доставки
            </span>
        </h2>
    </div>

    <div class="delivery-mail
        <?=($order['delivery_type'] != 'mail') ? 'd-none' : '';?>">

        <div class="mb-1">Начните вводить адрес и выберите его из списка предложенных вариантов</div>

        <div class="form-floating mb-3">
            <input class="form-control" id="user__address" type="text"
                   value="<?=($order['address'] != '') ? $order['address'] : '';?>">
            <label for="user__address">Ваш адрес</label>
            <div class="invalid-feedback">
                Введите более точный адрес для расчета доставки
            </div>
            <div class="feedback-short d-none">адрес доставки</div>
        </div>

        <div>
            <button class="btn btn-primary" disabled id="delivery-mail__calculation">
                Рассчитать доставку
            </button>
        </div>

        <div class="delivery-spin text-secondary mt-2 d-none">
            <i class="fa-solid fa-spinner fa-spin"></i> Идет расчет доставки...
        </div>

    </div>

    <div class="delivery-variant mt-4 mb-3 d-none">

        <div class="d-flex mb-3">
            <h3 class="marker">
                <span class="marker_h3">
                    Выберите вариант доставки
                </span>
            </h3>
        </div>

        <div class="list-group list-group-radio">
            <div class="row">

                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="position-relative">
                        <input class="form-check-input position-absolute top-50 end-0 me-3" data-days="" data-price=""
                               id="delivery-variant__pvz" name="delivery-variant__radio" type="radio"
                               value="pvz">
                        <label class="list-group-item py-3" for="delivery-variant__pvz">
                            <div class="d-inline-block" style="width: 25px;">
                                <i class="fa-solid fa-warehouse"></i>
                            </div>
                            <strong>До пункта выдачи заказа</strong>
                            <div class="delivery-variant__pvz-price"></div>
                        </label>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="position-relative">
                        <input class="form-check-input position-absolute top-50 end-0 me-3" data-days="" data-price=""
                               id="delivery-variant__courier" name="delivery-variant__radio" type="radio"
                               value="courier">
                        <label class="list-group-item py-3" for="delivery-variant__courier">
                            <div class="d-inline-block" style="width: 25px;">
                                <i class="fa-solid fa-truck"></i>
                            </div>
                            <strong>Курьером до двери</strong>
                            <div class="delivery-variant__courier-price"></div>
                        </label>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="delivery-courier
        <?=($order['delivery_type'] != 'courier') ? 'd-none' : '';?>">

        <div class="list-group list-group-radio">
            <div class="row">

                <?php foreach ($courierAddresses as $name => $cost) : ?>
                    <?php ($cost == 0) ? $cost = 'бесплатно' : $cost .= '  ₽'; ?>

                    <div class="col-md-6 col-sm-12 mb-3">
                        <div class="position-relative">
                            <input class="form-check-input position-absolute top-50 end-0 me-3"
                                   id="delivery-courier__<?=translit($name)?>"
                                   name="delivery-courier__radio" type="radio" value="<?=$name?>"
                                <?=($order['address'] == $name) ? 'checked' : '';?>>
                            <label class="list-group-item py-3" for="delivery-courier__<?=translit($name)?>">
                                <strong><?=$name?></strong>
                                <span class="small opacity-75">&ndash; <?=$cost?></span>
                            </label>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>

    </div>

</div>