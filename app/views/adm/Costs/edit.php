<div class="col-6 mb-3">
    <div class="form-floating">
        <?php $date = date_format(date_create($item['created_at']), 'Y-m-d'); ?>
        <input class="form-control" type="date" name="date" id="costs__date"
               value="<?=$date?>">
        <label for="costs__date">Дата</label>
    </div>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <input autofocus class="form-control" id="costs__amount" min="0" name="amount" type="number"
               value="<?=$item['amount']?>">
        <label for="costs__amount">Сумма</label>
        <div class="invalid-feedback">Введите сумму расхода</div>
        <div class="feedback-short d-none">сумму расхода</div>
    </div>
</div>


<div class="col-12 mb-3">
    <div class="form-floating">
        <?php $costCategory = R::findAll('m_cost_category') ?>
        <select class="form-select" id="item__cost_category_id" name="cost_category_id">
            <?php foreach ($costCategory as $costs): ?>
                <option value="<?=$costs['id']?>"
                    <?=($costs['id'] == $item['cost_category_id']) ? 'selected' : null;?>>
                    <?=$costs['name']?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="item__cost_category_id">Категория расхода</label>
        <div class="invalid-feedback">Добавьте категорию расхода</div>
        <div class="feedback-short d-none">категорию расхода</div>
    </div>

    <div class="small mt-1">
        <a href="/adm/cost-category/add">
            <i class="fa-regular fa-square-plus"></i>
            Новая категория расхода
        </a>
    </div>
</div>

