<div class="content_user mt-3 mb-4">

    <div class="d-flex mb-3 justify-content-between">
        <h2 class="marker">
            <span class="marker_h2">
                Ваши данные
            </span>
        </h2>

        <div class="align-self-center">
            <?php if (isAuth()): ?>
                <a href="#" id="user__settings">
                    <i class="fas fa-cog"></i> Изменить
                </a>
            <?php else : ?>
                <a href="#" id="user__login">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </a>
            <?php endif; ?>
        </div>

    </div>

    <?php if (isAuth()): ?>

        <div>
            <strong>Имя:</strong> <?=$_SESSION['user']['name']?>
            <br>
            <strong>Фамилия:</strong> <?=$_SESSION['user']['surname']?>
            <br>
            <strong>Электронная почта:</strong> <?=$_SESSION['user']['email']?>
            <br>
            <strong>Телефон:</strong> <?=$_SESSION['user']['phone']?>
        </div>

    <?php else : ?>

        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="user__name" type="text">
                    <label for="user__name">Имя</label>
                    <div class="invalid-feedback">Введите ваше имя</div>
                    <div class="feedback-short d-none">имя</div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="user__surname" type="text">
                    <label for="user__surname">Фамилия</label>
                    <div class="invalid-feedback">Введите вашу фамилию</div>
                    <div class="feedback-short d-none">фамилию</div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="user__email" type="email">
                    <label for="user__email">Электронная почта</label>
                    <div class="invalid-feedback">Введите вашу электронную почту</div>
                    <div class="feedback-short d-none">электронную почту</div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="user__phone" type="tel">
                    <label for="user__phone">Телефон</label>
                    <div class="invalid-feedback">Введите ваш телефон</div>
                    <div class="feedback-short d-none">телефон</div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 mb-3 position-relative">
                <div class="form-floating col-12">
                    <input class="form-control" id="user__captcha" maxlength="6" type="tel">
                    <label for="user__captcha">Проверочный код</label>
                    <div class="invalid-feedback">Введите проверочный код</div>
                    <div class="feedback-short d-none">проверочный код</div>
                </div>

                <div id="captcha_code">
                    <img alt="Проверочный код" src="/captcha.php" title="Проверочный код">
                </div>
            </div>

            <div class="col-12 mb-3 align-self-center">
                <div class="form-check">
                    <input checked class="form-check-input" id="user__legal" type="checkbox">
                    <label class="form-check-label" for="user__legal">
                        Принимаю условия пользовательского соглашения
                    </label>
                    <div class="feedback-short d-none"></div>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>