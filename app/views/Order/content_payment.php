<div class="content_payment payment-method mt-4">

    <div class="d-flex mb-3">
        <h2 class="marker">
            <span class="marker_h2">
                Оплата
            </span>
        </h2>
    </div>

    <div class="list-group list-group-radio">
        <div class="row">

            <div class="col-12 mb-3">
                <div class="position-relative">
                    <input class="form-check-input position-absolute top-50 end-0 me-3" id="payment-method__online"
                           name="payment-method__radio" type="radio" value="1"
                        <?=($order['payment'] == 1) ? 'checked' : '';?>>
                    <label class="list-group-item py-3 fw-bold" for="payment-method__online">
                        <i class="fa-regular fa-credit-card"></i>
                        Онлайн на сайте
                    </label>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="position-relative">
                    <input class="form-check-input position-absolute top-50 end-0 me-3" id="payment-method__cash"
                           name="payment-method__radio" type="radio" value="2"
                        <?=($order['payment'] == 2) ? 'checked' : '';?>>
                    <label class="list-group-item py-3 fw-bold" for="payment-method__cash">
                        При получении
                    </label>
                </div>
            </div>

        </div>
    </div>

</div>