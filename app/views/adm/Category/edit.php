<div class="col-12 mb-3">
    <div class="form-floating">
        <input autofocus class="form-control" id="name" maxlength="60" name="name"
               placeholder="Название" type="text" value="<?=$item['name']?>">
        <label for="name">Название</label>
        <div class="invalid-feedback">Введите название категории</div>
        <div class="feedback-short d-none">название категории</div>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Описание</span>
    </h4>
</div>

<div class="col-12 mb-3">
    <textarea class="form-control" id="description" name="description"><?=$item['description']?></textarea>
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
