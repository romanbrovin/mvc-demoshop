<div class="d-flex mb-2">
    <h4 class="marker">
        <span class="marker_h4">Доставка</span>
    </h4>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <select class="form-select" disabled id="delivery_type">
            <option <?=($item['delivery_type'] == 'mail') ? 'selected' : null;?>>
                Доставка по России
            </option>
            <option <?=($item['delivery_type'] == 'courier') ? 'selected' : null;?>>
                Курьером по городу
            </option>
        </select>
        <label for="delivery_type">Тип доставки</label>
    </div>
</div>

<div class="col-6">
    <div class="form-floating">
        <select class="form-select" id="delivery_variant" name="delivery_variant"
            <?=($item['delivery_type'] == 'courier') ? 'disabled' : null;?>>
            <option value="pvz" <?=($item['delivery_variant'] == 'pvz') ? 'selected' : null;?>>
                Пункт выдачи заказа
            </option>
            <option value="courier"
                <?=($item['delivery_variant'] == 'courier'
                    || $item['delivery_type'] == 'courier') ? 'selected' : null;?> >
                Курьером до двери
            </option>
        </select>
        <label for="delivery_variant">Вариант доставки</label>
    </div>
</div>

<div class="col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="address" name="address" type="text"
               value="<?=$item['address']?>">
        <label for="address">Адрес доставки</label>
        <div class="invalid-feedback">Введите адрес доставки</div>
        <div class="feedback-short d-none">адрес доставки</div>
    </div>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="delivery_price" min="0" name="delivery_price" type="number"
               value="<?=$item['delivery_price']?>">
        <label for="delivery_price">Стоимость доставки, ₽</label>
        <div class="invalid-feedback">Введите стоимость доставки</div>
        <div class="feedback-short d-none">стоимость доставки</div>

    </div>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="delivery_days" name="delivery_days" type="text"
               value="<?=$item['delivery_days']?>">
        <label for="delivery_days">Срок доставки</label>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Оплата</span>
    </h4>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <select class="form-select" id="payment" name="payment">
            <option <?=($item['payment'] == 1) ? 'selected' : null;?> value="1">Онлайн на сайте</option>
            <option <?=($item['payment'] == 2) ? 'selected' : null;?> value="2">При получении</option>
        </select>
        <label for="payment">Способ оплаты</label>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Дополнительно</span>
    </h4>
</div>

<div class="col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="comment" name="comment" type="text"
               value="<?=$item['comment_admin']?>">
        <label for="comment">Заметка</label>
    </div>
</div>

<script>
    $(function () {
        AhunterSuggest.Address.Solid({
            id: "address",
            empty_msg: "",
            limit: 5,
        });
    });
</script>