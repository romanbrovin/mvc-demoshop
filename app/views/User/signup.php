<div class="d-flex mb-5">
    <h1 class="marker">
        <span class="marker_h1">
            Регистрация
        </span>
    </h1>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-12">
        <form class="row" id="form">

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="name" maxlength="150" name="name"
                           placeholder="Имя" type="text">
                    <label for="name">Имя</label>
                    <div class="invalid-feedback">Введите ваше имя</div>
                    <div class="feedback-short d-none">имя</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="surname" maxlength="150" name="surname"
                           placeholder="Фамилия" type="text">
                    <label for="surname">Фамилия</label>
                    <div class="invalid-feedback">Введите вашу фамилию</div>
                    <div class="feedback-short d-none">фамилию</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="email" maxlength="150" name="email"
                           placeholder="Электронная почта" type="email">
                    <label for="email">Электронная почта</label>
                    <div class="invalid-feedback">Введите вашу электронную почту</div>
                    <div class="feedback-short d-none">электронную почту</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="phone" maxlength="20" name="phone"
                           placeholder="Телефон" type="text">
                    <label for="phone">Телефон</label>
                    <div class="invalid-feedback">Введите ваш телефон</div>
                    <div class="feedback-short d-none">телефон</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="password" name="password"
                           placeholder="Пароль" type="password">
                    <label for="password">Пароль</label>
                    <div class="invalid-feedback">Придумайте новый пароль</div>
                    <div class="feedback-short d-none">пароль</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3 position-relative">
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

            <div class="col-12 mb-3 align-self-center">
                <div class="form-check">
                    <input checked class="form-check-input" id="legal" name="legal" type="checkbox">
                    <label class="form-check-label" for="legal">
                        Принимаю условия <a href="/legal">пользовательского соглашения</a>
                    </label>
                    <div class="feedback-short d-none">принять пользовательское соглашение</div>
                </div>
            </div>

            <div class="mt-4">
                <a class="btn btn-secondary btn__back me-2" href="#">Назад</a>
                <button class="btn btn-success btn__signup" type="button">Зарегистрироваться</button>
            </div>

        </form>
    </div>
</div>