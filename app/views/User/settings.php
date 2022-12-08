<div class="d-flex mb-5">
    <h1 class="marker">
        <span class="marker_h1">Настройки</span>
    </h1>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-12">
        <form class="row" id="form">

            <div class="d-flex mb-3">
                <h2 class="marker">
                    <span class="marker_h2">Персональные данные</span>
                </h2>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="name" maxlength="150" name="name"
                           placeholder="Имя" type="text" value="<?=$_SESSION['user']['name']?>">
                    <label for="name">Имя</label>
                    <div class="invalid-feedback">Введите ваше имя</div>
                    <div class="feedback-short d-none">имя</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="surname" maxlength="150" name="surname"
                           placeholder="Фамилия" type="text" value="<?=$_SESSION['user']['surname']?>">
                    <label for="surname">Фамилия</label>
                    <div class="invalid-feedback">Введите вашу фамилию</div>
                    <div class="feedback-short d-none">фамилию</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" disabled id="email" type="email"
                           value="<?=$_SESSION['user']['email']?>">
                    <label for="email">Электронная почта</label>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="phone" maxlength="20" name="phone"
                           placeholder="Телефон" type="text" value="<?=$_SESSION['user']['phone']?>">
                    <label for="phone">Телефон</label>
                    <div class="invalid-feedback">Введите ваш телефон</div>
                    <div class="feedback-short d-none">телефон</div>
                </div>
            </div>


            <div class="d-flex mt-5">
                <h2 class="marker">
                    <span class="marker_h2">Безопасность</span>
                </h2>
            </div>

            <div class="mb-3 text-secondary">
                Оставьте эти поля пустыми, если не хотите изменить пароль
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="password" name="password"
                           placeholder="Старый пароль" type="password">
                    <label for="password">Старый пароль</label>
                    <div class="invalid-feedback">Введите старый пароль</div>
                    <div class="feedback-short d-none">старый пароль</div>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="password_new" name="password_new"
                           placeholder="Новый пароль" type="password">
                    <label for="password_new">Новый пароль</label>
                    <div class="invalid-feedback">Придумайте новый пароль</div>
                    <div class="feedback-short d-none">новый пароль</div>
                </div>
            </div>

            <div class="mt-4">
                <a class="btn btn-secondary btn__back me-2" href="#">Назад</a>
                <button class="btn btn-success btn__settings" type="button">Сохранить</button>
            </div>

        </form>
    </div>
</div>