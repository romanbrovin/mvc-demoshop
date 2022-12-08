<div class="content_delivery mt-4">

    <div class="d-flex mb-3">
        <h2 class="marker">
            <span class="marker_h2">
                Доставка
            </span>
        </h2>
    </div>

    <div class="list-group list-group-radio">
        <div class="row">

            <div class="col-12 mb-3">
                <div class="position-relative">
                    <input class="form-check-input position-absolute top-50 end-0 me-3"
                           id="delivery-type__mail" name="delivery-type__radio" type="radio" value="mail"
                        <?=($order['delivery_type'] == 'mail') ? 'checked' : '';?>>
                    <label class="list-group-item py-3 fw-bold" for="delivery-type__mail">
                        Доставка по России
                    </label>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="position-relative">
                    <input class="form-check-input position-absolute top-50 end-0 me-3"
                           id="delivery-type__courier" name="delivery-type__radio" type="radio" value="courier"
                        <?=($order['delivery_type'] == 'courier') ? 'checked' : '';?>>
                    <label class="list-group-item py-3 fw-bold" for="delivery-type__courier">
                        Доставка курьером по городу
                    </label>
                </div>
            </div>

        </div>
    </div>

</div>


