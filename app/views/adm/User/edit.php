<div class="col-md-6 col-12 mb-3">
    <div class="form-floating">
        <input autofocus class="form-control" id="name" maxlength="150" name="name"
               placeholder="Имя" type="text" value="<?=$item['name']?>">
        <label for="name">Имя</label>
        <div class="invalid-feedback">Введите имя клиента</div>
        <div class="feedback-short d-none">имя</div>
    </div>
</div>

<div class="col-md-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="surname" maxlength="150" name="surname"
               placeholder="Фамилия" type="text" value="<?=$item['surname']?>">
        <label for="surname">Фамилия</label>
        <div class="invalid-feedback">Введите фамилию клиента</div>
        <div class="feedback-short d-none">фамилию</div>
    </div>
</div>

<div class="col-md-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="email" maxlength="150" name="email"
               placeholder="Электронная почта" type="email" value="<?=$item['email']?>">
        <label for="email">Электронная почта</label>
        <div class="invalid-feedback">Введите электронную почту клиента</div>
        <div class="feedback-short d-none">электронную почту</div>
    </div>
</div>

<div class="col-md-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="phone" maxlength="20" name="phone"
               placeholder="Телефон" type="text" value="<?=$item['phone']?>">
        <label for="phone">Телефон</label>
        <div class="invalid-feedback">Введите телефон клиента</div>
        <div class="feedback-short d-none">телефон</div>
    </div>
</div>

<div class="col-md-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="bonus" min="0" name="bonus"
               placeholder="Бонусы" type="number" value="<?=$item['bonus']?>">
        <label for="bonus">Бонусы</label>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Безопасность</span>
    </h4>
</div>

<div class="col-md-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="password" name="password" type="text" value="">
        <label for="password">Новый пароль</label>
    </div>
    <a class="btn__password-generate" href="#">
        <i class="fa-solid fa-cubes"></i>
        Сгенерировать
    </a>
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
