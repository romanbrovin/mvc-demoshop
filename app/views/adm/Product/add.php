<div class="col-lg-6 col-12 mb-3">
    <div class="form-floating">
        <?php $categories = R::findAll('m_category', 'ORDER BY name ASC') ?>
        <select class="form-select" id="category_id" name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?=$category['id']?>"
                    <?=(notArray($categoryId) && $category['id'] == $categoryId) ? 'selected' : null;?>>
                    <?=$category['name']?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="category_id">Категория</label>
        <div class="invalid-feedback">Добавьте категорию</div>
        <div class="feedback-short d-none">категорию</div>
    </div>
</div>

<div class="col-lg-6 col-12 mb-3">
    <div class="form-floating">
        <input autofocus class="form-control" id="name" maxlength="150" name="name" placeholder="Название" type="text">
        <label for="name">Название</label>
        <div class="invalid-feedback">Введите название товара</div>
        <div class="feedback-short d-none">название товара</div>
    </div>
</div>

<div class="col-lg-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="article" maxlength="20" name="article" placeholder="Артикул" type="text">
        <label for="article">Артикул</label>
        <div class="invalid-feedback">Введите артикул</div>
        <div class="feedback-short d-none">артикул товара</div>
    </div>
</div>

<div class="col-lg-6 col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="barcode" maxlength="20" name="barcode" placeholder="Баркод"
               type="number" min="0">
        <label for="barcode">Баркод</label>
        <div class="invalid-feedback">Введите баркод</div>
        <div class="feedback-short d-none">баркод товара</div>
    </div>
</div>


<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Превью</span>
    </h4>
</div>

<div class="col-12 mb-3">
    <textarea class="form-control" id="preview" name="preview"></textarea>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Описание</span>
    </h4>
</div>

<div class="col-12 mb-3">
    <textarea class="form-control" id="description" name="description"></textarea>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Теги</span>
    </h4>
</div>

<div class="col-12 mb-3">

    <div class="form-check form-check-inline">
        <input class="form-check-input" id="tag_new" name="tag_new" type="checkbox">
        <label class="form-check-label" for="tag_new">
            Новинка
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" id="tag_hit" name="tag_hit" type="checkbox">
        <label class="form-check-label" for="tag_hit">
            Хит продаж
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" id="tag_rare" name="tag_rare" type="checkbox">
        <label class="form-check-label" for="tag_rare">
            Редкий набор
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" id="tag_low_price" name="tag_low_price" type="checkbox">
        <label class="form-check-label" for="tag_low_price">
            Гарантия низкой цены
        </label>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Характеристики</span>
    </h4>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="parts" min="0" name="parts" type="number">
        <label for="parts">Деталей</label>
        <div class="invalid-feedback">Введите кол-во деталей</div>
        <div class="feedback-short d-none">кол-во деталей</div>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="age" min="0" name="age" type="number">
        <label for="age">Мин. возраст</label>
        <div class="invalid-feedback">Введите мин. возраст</div>
        <div class="feedback-short d-none">мин. возраст</div>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="figures" min="0" name="figures" type="number">
        <label for="figures">Фигурок</label>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="year" min="1900" name="year" type="number">
        <label for="year">Год выпуска</label>
        <div class="invalid-feedback">Введите год выпуска</div>
        <div class="feedback-short d-none">год выпуска</div>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Габариты товара</span>
    </h4>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="length" min="0" name="length" type="number">
        <label for="length">Длина (см)</label>
        <div class="invalid-feedback">Введите длину</div>
        <div class="feedback-short d-none">длину товара</div>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="width" min="0" name="width" type="number">
        <label for="width">Ширина (см)</label>
        <div class="invalid-feedback">Введите ширину</div>
        <div class="feedback-short d-none">ширину товара</div>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="height" min="0" name="height" type="number">
        <label for="height">Высота (см)</label>
        <div class="invalid-feedback">Введите высоту</div>
        <div class="feedback-short d-none">высоту товара</div>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="weight" min="0" name="weight" step="0.1" type="number">
        <label for="weight">Вес (кг)</label>
        <div class="invalid-feedback">Введите вес</div>
        <div class="feedback-short d-none">вес товара</div>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Габариты упаковки</span>
    </h4>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="length_pack" min="0" name="length_pack" type="number">
        <label for="length_pack">Длина (см)</label>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="width_pack" min="0" name="width_pack" type="number">
        <label for="width_pack">Ширина (см)</label>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="height_pack" min="0" name="height_pack" type="number">
        <label for="height_pack">Высота (см)</label>
    </div>
</div>

<div class="col-sm-3 col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="weight_pack" min="0" name="weight_pack" step="0.1"
               type="number">
        <label for="weight_pack">Вес (кг)</label>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Дополнительно</span>
    </h4>
</div>

<div class="col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="youtube" name="youtube" type="text">
        <label for="youtube">Ссылка на YouTube</label>
    </div>
</div>

<div class="col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="comment" name="comment" type="text">
        <label for="comment">Заметка</label>
    </div>
</div>
