<?php
require ROOT . '/config/arr.php';

$selects = ['s_text'];
$checkboxes = [];
$hiddenInputs = [];

if ($route['controller'] == 'Order') {
    array_push($selects, 's_status', 's_status_short', 's_payment', 's_marketplace');
    $hiddenInputs = ['s_user_id'];
} else if ($route['controller'] == 'Category') {
    $checkboxes = ['s_hidden'];
} else if ($route['controller'] == 'User') {
    $hiddenInputs = ['s_user_id'];
} else if ($route['controller'] == 'Product') {
    array_push($selects, 's_category_id', 's_tag');
    $checkboxes = ['s_amount', 's_soon', 's_select'];
    $hiddenInputs = ['s_product_id'];
} else if ($route['controller'] == 'Storage') {
    array_push($selects, 's_warehouse_id', 's_supplier_id');
    $checkboxes = ['s_hidden'];
    $hiddenInputs = ['s_product_id'];
} else if ($route['controller'] == 'Paykeeper') {
    array_push($selects, 's_date_from', 's_date_to');
} else if ($route['controller'] == 'Costs') {
    array_push($selects, 's_date_from', 's_date_to', 's_cost_category_id');
} else if ($route['controller'] == 'Report') {
    array_push($selects, 's_date_from', 's_date_to', 's_type');
} else if ($route['controller'] == 'Stats') {
    $selects = [];
    $checkboxes = ['s_no_sales'];
}
?>

<?php if (issetVal($sort['s_category_id'])) : ?>
    <?php $category = R::findOne('m_category', 'id = ?', [$sort['s_category_id']]); ?>
    <?php if ($category) : ?>
        <div class="h4 mb-4">
            Категория: <span class="text-danger fw-bold"><?=$category['name']?></span>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (issetVal($sort['s_user_id'])) : ?>
    <?php $user = R::findOne('m_user', 'id = ?', [$sort['s_user_id']]); ?>
    <?php if ($user) : ?>
        <div class="h4 mb-4">
            Клиент: <span class="text-danger fw-bold"><?=$user['name']?> <?=$user['surname']?></span>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (issetVal($sort['s_order_id'])) : ?>
    <div class="h4 mb-4">
        Заказ: <span class="text-danger fw-bold"><?=$sort['s_order_id']?></span>
    </div>
<?php endif; ?>

<?php if (issetVal($sort['s_product_id'])) : ?>
    <?php $product = R::findOne('m_product', 'id = ?', [$sort['s_product_id']]); ?>
    <?php if ($product) : ?>
        <div class="h4 mb-4">
            Товар: <span class="text-danger fw-bold"><?=$product['article']?> <?=$product['name']?> </span>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (issetVal($sort['s_text'])) : ?>
    <div class="h5 mb-4">
        Поиск по запросу <span class="text-danger fw-bold"><?=$sort['s_text']?></span>
    </div>
<?php endif; ?>


<form class="row mt-4 mb-4" id="search__form">

    <?php if (in_array('s_user_id', $hiddenInputs)) : ?>
        <input name="s_user_id" type="hidden" value="<?=$sort['s_user_id'] ?? null;?>">
    <?php endif; ?>

    <?php if (in_array('s_product_id', $hiddenInputs)) : ?>
        <input name="s_product_id" type="hidden" value="<?=$sort['s_product_id'] ?? null;?>">
    <?php endif; ?>

    <?php if (in_array('s_text', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <div class="form-floating">
                <input class="form-control" id="search__text" name="s_text" placeholder="Поиск..." type="text"
                       value="<?=$sort['s_text']?>">
                <label for="search__text">Поиск...</label>
                <div class="search__ico search__ico_find" data-bs-custom-class="tooltip" data-bs-placement="top"
                     data-bs-title="Найти" data-bs-toggle="tooltip">
                    <a href="#" id="s_find">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </div>
                <div class="search__ico search__ico_clear" data-bs-custom-class="tooltip" data-bs-placement="top"
                     data-bs-title="Очистить поиск" data-bs-toggle="tooltip">
                    <a href="#" id="s_clear">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_status', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <div class="form-floating">
                <select class="form-select" id="search__status" name="s_status">
                    <?php foreach ($arrStatus as $name => $value): ?>
                        <option value="<?=$value?>" <?=($sort['s_status'] == $value) ? 'selected' : null;?>>
                            <?=$name?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__status">Статус заказа</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_payment', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <div class="form-floating">
                <select class="form-select" id="search__payment" name="s_payment">
                    <?php foreach ($arrPayment as $name => $value): ?>
                        <option value="<?=$value?>" <?=($sort['s_payment'] == $value) ? 'selected' : null;?>>
                            <?=$name?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__payment">Способ оплаты</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_category_id', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <div class="form-floating">
                <?php $categories = R::findAll('m_category', 'ORDER BY name ASC') ?>
                <select class="form-select" id="search__category_id" name="s_category_id">
                    <option selected value="">Все категории</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?=$category['id']?>" <?=($sort['s_category_id'] == $category['id']) ? 'selected' : null;?>>
                            <?=$category['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__category_id">Категория</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_tag', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <div class="form-floating">
                <select class="form-select" id="search__tag" name="s_tag">
                    <?php foreach ($arrTag as $name => $value): ?>
                        <option value="<?=$value?>" <?=($sort['s_tag'] == $value) ? 'selected' : null;?>>
                            <?=$name?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__tag">Теги</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_date_from', $selects)) : ?>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12 mb-2">
            <div class="form-floating">
                <input class="form-control" type="date" name="s_date_from" id="search__date_from"
                       value="<?=($sort['s_date_from']) ?: date('Y-m-01')?>">
                <label for="search__date_from">Дата от</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_date_to', $selects)) : ?>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12 mb-2">
            <div class="form-floating">
                <input class="form-control" type="date" name="s_date_to" id="search__date_to"
                       value="<?=($sort['s_date_to']) ?: date('Y-m-d')?>">
                <label for="search__date_to">Дата до</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_marketplace', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <div class="form-floating">
                <select class="form-select" id="search__marketplace" name="s_marketplace">
                    <option selected value="">Все площадки</option>
                    <?php $marketplaceList = R::findAll('m_marketplace'); ?>
                    <?php foreach ($marketplaceList as $marketplace) : ?>
                        <option value="<?=$marketplace['short_name']?>"
                            <?=($sort['s_marketplace'] == $marketplace['short_name']) ? 'selected' : null;?>>
                            <?=$marketplace['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__marketplace">Маркетплейс</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_type', $selects)) : ?>
        <div class="col-xl-3 col-lg-3 col-sm-6 col-12 mb-2">
            <div class="form-floating">
                <select class="form-select" id="search__type" name="s_type">
                    <?php foreach ($arrType as $name => $value): ?>
                        <option value="<?=$value?>" <?=($sort['s_type'] == $value) ? 'selected' : null;?>>
                            <?=$name?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__type">Раздел</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_cost_category_id', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <?php $items = R::findAll('m_cost_category'); ?>
            <div class="form-floating">
                <select class="form-select" id="search__cost_category_id" name="s_cost_category_id">
                    <option selected value="">Все категории</option>
                    <?php foreach ($items as $item): ?>
                        <option value="<?=$item['id']?>"
                            <?=($sort['s_cost_category_id'] == $item['id']) ? 'selected' : null;?>>
                            <?=$item['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__cost_category_id">Категория расхода</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_warehouse_id', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <?php $items = R::findAll('m_warehouse'); ?>
            <div class="form-floating">
                <select class="form-select" id="search__warehouse_id" name="s_warehouse_id">
                    <option selected value="">Все склады</option>
                    <?php foreach ($items as $item): ?>
                        <option value="<?=$item['id']?>"
                            <?=($sort['s_warehouse_id'] == $item['id']) ? 'selected' : null;?>>
                            <?=$item['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__warehouse_id">Адрес склада</label>
            </div>
        </div>
    <?php endif; ?>

    <?php if (in_array('s_supplier_id', $selects)) : ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <?php $items = R::findAll('m_supplier'); ?>
            <div class="form-floating">
                <select class="form-select" id="search__supplier_id" name="s_supplier_id">
                    <option selected value="">Все поставщики</option>
                    <?php foreach ($items as $item): ?>
                        <option value="<?=$item['id']?>"
                            <?=($sort['s_supplier_id'] == $item['id']) ? 'selected' : null;?>>
                            <?=$item['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="search__supplier_id">Поставщики</label>
            </div>
        </div>
    <?php endif; ?>

    <?php
    $checkboxesList = [
        's_amount' => 'Нет в продаже',
        's_hidden' => 'Неактивные',
        's_soon' => 'Скоро в продаже',
        's_select' => 'С флажком',
        's_no_sales' => 'Без единой продажи',
    ];

    $classGroup = (count($checkboxes) > 1) ? 'col-12' : 'col-3 d-flex align-items-center';
    ?>

    <div class="<?=$classGroup?> mb-2">

        <?php foreach ($checkboxesList as $name => $value) : ?>
            <?php if (in_array($name, $checkboxes)) : ?>
                <div class="me-3">
                    <div class="form-check">
                        <input class="form-check-input" id="search__<?=$name?>" name="<?=$name?>" type="checkbox"
                               value="<?=($sort[$name] == 1) ? 0 : 1;?>"
                            <?=($sort[$name] == 1) ? 'checked' : null;?>>
                        <label class="form-check-label" for="search__<?=$name?>">
                            <?=$value?>
                        </label>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>

    <?php if (in_array('s_status_short', $selects)) : ?>
        <div class="col-12">
            <ul class="list-inline m-0">
                <li class="list-inline-item">
                    <a href="/adm/order?s_status=checkouted">
                        Ожидает подтверждения
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="/adm/order?s_status=confirmed">
                        Подтвержден
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="/adm/order?s_status=paid">
                        Оплачен
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>


    <div class="col-12 mt-2">
        <div class="text-secondary">
            Найдено совпадений: <?=$pagination->totalEntries?>
        </div>
    </div>

    <?php if (isset($sort['fields'])) : ?>
        <div class="col-12 mt-2">
            <ul class="list-inline m-0">
                <li class="list-inline-item">
                    Сортировать по:
                </li>
                <?php foreach ($sort['fields'] as $name => $value) : ?>
                    <li class="list-inline-item">
                        <a class="s_query" data-query="<?=$sort['query_' . $name]?>" href="#">
                            <?=$value?> <?=$sort['arrow_' . $name]?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!$pagination->totalEntries) : ?>
        <div class="oops">
            По вашему запросу ничего не найдено :-(
        </div>
    <?php endif; ?>

</form>
