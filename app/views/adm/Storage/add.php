<div class="col-6 mb-3">
    <div class="form-floating">
        <input autofocus class="form-control" id="amount" min="0" name="amount" type="number">
        <label for="amount">Кол-во, шт.</label>
        <div class="invalid-feedback">Введите кол-во товара</div>
        <div class="feedback-short d-none">кол-во товара</div>
    </div>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <input class="form-control" id="price" min="0" name="price" type="number">
        <label for="price">Цена закупки, ₽</label>
        <div class="invalid-feedback">Введите цену закупки</div>
        <div class="feedback-short d-none">цена закупки</div>
    </div>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <?php $suppliers = R::findAll('m_supplier'); ?>
        <select class="form-select" id="supplier_id" name="supplier_id">
            <?php foreach ($suppliers as $supplier): ?>
                <?php $listId = $supplier['list_id']; ?>
                <option value="<?=$supplier['id']?>">
                    <?=$supplier['name']?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="supplier_id">Поставщик</label>
        <div class="invalid-feedback">Добавьте постащика</div>
        <div class="feedback-short d-none">поставщика</div>
    </div>

    <div class="small mt-1">
        <a href="/adm/supplier/add">
            <i class="fa-regular fa-square-plus"></i>
            Новый поставщик
        </a>
    </div>
</div>

<div class="col-6 mb-3">
    <div class="form-floating">
        <?php $warehouses = R::findAll('m_warehouse'); ?>
        <select class="form-select" id="warehouse_id" name="warehouse_id">
            <?php foreach ($warehouses as $warehouse): ?>
                <?php $listId = $warehouse['list_id']; ?>
                <option value="<?=$warehouse['id']?>">
                    <?=$warehouse['name']?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="warehouse_id">Склад хранения</label>
        <div class="invalid-feedback">Добавьте адрес склада</div>
        <div class="feedback-short d-none">адрес склада</div>
    </div>

    <div class="small mt-1">
        <a href="/adm/warehouse/add">
            <i class="fa-regular fa-square-plus"></i>
            Новый склад
        </a>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Хранение</span>
    </h4>
</div>

<div class="col-4 mb-3">
    <div class="form-floating">
        <input class="form-control" id="rack" name="rack" type="number">
        <label for="rack">Стеллаж</label>
    </div>
</div>

<div class="col-4 mb-3">
    <div class="form-floating">
        <input class="form-control" id="pallet" name="pallet" type="number">
        <label for="pallet">Паллет</label>
    </div>
</div>

<div class="col-4 mb-3">
    <div class="form-floating">
        <input class="form-control" id="box" name="box" type="number">
        <label for="box">Коробка</label>
    </div>
</div>

<div class="d-flex mt-4 mb-2">
    <h4 class="marker">
        <span class="marker_h4">Дополнительно</span>
    </h4>
</div>

<div class="col-12 mb-3">
    <div class="form-floating">
        <input class="form-control" id="comment" name="comment" type="text">
        <label for="comment">Заметка</label>
    </div>
</div>

<input type="hidden" id="product_id" name="product_id" value="<?=$productId?>">

<?php $product = R::load('m_product', $productId); ?>
<div>
    Артикул <strong><?=$product['article']?></strong>
</div>
