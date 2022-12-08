<div class="d-flex mb-5">
    <h1 class="marker">
        <span class="marker_h1">
            Вход в личный кабинет
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

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="password" name="password"
                           placeholder="Пароль" type="password">
                    <label for="password">Пароль</label>
                    <div class="invalid-feedback">Введите ваш пароль</div>
                    <div class="feedback-short d-none">пароль</div>
                    <div class="mt-2">
                        <a href="/recovery">Забыли пароль?</a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-success btn__login" type="button">Войти</button>
            </div>

        </form>
    </div>
</div>

<div class="d-flex mt-5 mb-3">
    <h3 class="marker">
        <span class="marker_h3">
            Новый пользователь?
        </span>
    </h3>
</div>

<div>
    <a href="/signup" class="btn btn-primary">Зарегистрироваться</a>
</div>

<script>
    $(function () {
        $('input').keydown(function (e) {
            if (e.keyCode === 13) {
                userAction('login');
            }
        });
    });
</script>