<div class="d-flex mb-5">
    <h1 class="marker">
        <span class="marker_h1">
            Восстановление пароля
        </span>
    </h1>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-12">
        <form class="row" id="form">

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="email" name="email"
                           placeholder="Электронная почта" type="email">
                    <label for="email">Электронная почта</label>
                    <div class="invalid-feedback">Введите вашу электронную почту</div>
                    <div class="feedback-short d-none">электронную почту</div>
                </div>
            </div>

            <div class="col-12 mb-3 position-relative">
                <div class="form-floating col-12">
                    <input class="form-control" id="captcha" maxlength="6" name="captcha"
                           placeholder="Проверочный код" type="tel">
                    <label for="captcha">Проверочный код</label>
                    <div class="invalid-feedback">Введите проверочный код</div>
                    <div class="feedback-short d-none">проверочный код</div>
                </div>

                <div id="captcha_code">
                    <img src="/captcha.php" title="Проверочный код" alt="Проверочный код">
                </div>
            </div>

            <div class="mt-4">
                <a class="btn btn-secondary btn__back me-2" href="#">Назад</a>
                <button class="btn btn-success btn__recovery" type="button">Выслать новый пароль</button>
            </div>

        </form>
    </div>
</div>