<?php

use app\models\adm\App;

foreach ($list as $item) {
    ${$item['name']}['updated_at'] = $item['updated_at'];
    ${$item['name']}['value'] = $item['value'];
    ${$item['name']} = dateModifyInArray(${$item['name']});
}

$fields = require ROOT . '/config/arr.php';

?>

<div class="d-flex mb-4">
    <h1 class="marker">
        <span class="marker_h1">Рабочий стол</span>
    </h1>
</div>

<div class="row">

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">

        <div class="bg-white border p-4 rounded-3">

            <div class="d-flex">
                <h2 class="marker">
                    <span class="marker_h2">Информация</span>
                </h2>
            </div>

            <div class="text-secondary small">
                Данные на <?=$cost_all['updated_at']?>
            </div>

            <div>
                <a href="#" id="sync">
                    <i class="fas fa-sync" id="sync__ico"></i> Обновить данные
                </a>
            </div>

            <div class="d-flex mt-4 mb-">
                <h4 class="marker">
                    <span class="marker_h4">Сейчас в продаже</span>
                </h4>
            </div>

            <div class="mb-3">
                <div>
                    Кол-во: <strong><?=rank($amount_active['value'])?> шт.</strong>
                </div>
                <div>
                    Себестоимость: <strong><?=rank($cost_active['value'])?> ₽</strong>
                </div>
                <div>
                    Реализация: <strong><?=rank($selling_active['value'])?> ₽</strong>
                </div>
                <div class="mt-1">
                    Ожидаемый доход: <?=rank($income_money['value'])?> ₽
                    <span class="text-secondary">(<?=$income_percent['value']?>%)</span>
                </div>
            </div>

            <div class="d-flex mb-">
                <h4 class="marker">
                    <span class="marker_h4">Всего товаров</span>
                </h4>
            </div>

            <div class="mb-3">
                Кол-во: <strong><?=rank($amount_all['value'])?> шт.</strong> <br>
                Себестоимость: <strong><?=rank($cost_all['value'])?> ₽</strong>
            </div>

            <div class="d-flex mb-2 mt-4">
                <h2 class="marker">
                    <span class="marker_h2">
                        <a href="/adm/report">Отчет</a>
                    </span>
                </h2>
            </div>

            <ul>
                <li>
                    <a class="me-1" href="/adm/costs">
                        Расходы
                    </a>
                    <a href="/adm/costs/add">
                        <i class="fa-regular fa-square-plus"></i>
                    </a>
                </li>
                <li>
                    <a href="/adm/cost-category">
                        Категории расходов
                    </a>
                    <a href="/adm/cost-category/add">
                        <i class="fa-regular fa-square-plus"></i>
                    </a>
                </li>
                <li>
                    <a class="me-1" href="/adm/paykeeper">
                        PayKeeper
                    </a>
                </li>
            </ul>

            <div class="d-flex mt-4">
                <h2 class="marker">
                    <span class="marker_h2">Выгрузка фидов</span>
                </h2>
            </div>

            <ol class="list-unstyled mt-3">
                <li class="mb-1" data-feed="adv">
                    <span class="me-2 text-secondary">
                        <i class="fa-solid fa-toggle-on"></i> ADV
                    </span>
                    <a class="feed-update me-" href="#"><i class="fas fa-sync" id="feed-adv__ico"></i></a>
                    <a class="me-2" href="/feed/adv.xml" target="_blank"><i class="fa-solid fa-link"></i></a>
                    <div class="d-inline-block small text-secondary"><?=$adv['updated_at']?></div>
                </li>

                <li class="mb-1" data-feed="dbs">
                    <a class="feed me-2" href="#">
                        <?php ($dbs['value'] == 0) ? $toggle = 'off' : $toggle = 'on'; ?>
                        <i class="fa-solid fa-toggle-<?=$toggle?>"></i> DBS
                    </a>
                    <a class="feed-update me-" href="#"><i class="fas fa-sync" id="feed-dbs__ico"></i></a>
                    <a class="me-2" href="/feed/dbs.xml" target="_blank"><i class="fa-solid fa-link"></i></a>
                    <div class="d-inline-block small text-secondary"><?=$dbs['updated_at']?></div>
                </li>

                <li class="mb-1" data-feed="ozon">
                    <a class="feed me-2" href="#">
                        <?php ($ozon['value'] == 0) ? $toggle = 'off' : $toggle = 'on'; ?>
                        <i class="fa-solid fa-toggle-<?=$toggle?>"></i> OZON
                    </a>
                    <a class="feed-update me-" href="#"><i class="fas fa-sync" id="feed-ozon__ico"></i></a>
                    <a class="me-2" href="/feed/ozon.yml" target="_blank"><i class="fa-solid fa-link"></i></a>
                    <div class="d-inline-block small text-secondary"><?=$ozon['updated_at']?></div>
                </li>
            </ol>

        </div>

    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">

        <div class="bg-white border p-4 rounded-3">
            <div class="d-flex mb-2">
                <h2 class="marker">
                    <span class="marker_h2">
                        <a href="/adm/order">Заказы</a>
                    </span>
                </h2>
            </div>

            <h5 class="text-secondary">Статус</h5>
            <ul>
                <?php foreach ($arrStatus as $name => $value) : ?>
                    <?php if ($value != '') : ?>
                        <li>
                            <a href="/adm/order?s_status=<?=$value?>">
                                <?=$name?>
                                <?=App::renderCounter('m_order', 'current_status', $value)?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <h5 class="text-secondary">Способ оплаты</h5>
            <ul>
                <?php foreach ($arrPayment as $name => $value) : ?>
                    <?php if ($value != '') : ?>
                        <li>
                            <a href="/adm/order?s_payment=<?=$value?>">
                                <?=$name?>
                                <?=App::renderCounter('m_order', 'payment', $value)?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <h5 class="text-secondary">Маркетплейс</h5>
            <ul>
                <?php foreach ($marketplaceList as $marketplace) : ?>
                    <li>
                        <a href="/adm/order?s_marketplace=<?=$marketplace['short_name']?>">
                            <?=$marketplace['name']?>
                            <?=App::renderCounter('m_order', 'marketplace', $marketplace['short_name'])?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="d-flex mb-2 mt-4">
                <h2 class="marker">
                    <span class="marker_h2">
                        <a href="/adm/user">Клиенты</a>
                    </span>
                </h2>
            </div>

            <div>
                <a href="/adm/user/add">
                    <i class="fa-regular fa-square-plus"></i>
                    Новый клиент
                </a>
            </div>

        </div>

    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">

        <div class="bg-white border p-4 rounded-3">
            <div class="d-flex mb-2">
                <h2 class="marker">
                    <span class="marker_h2">
                        <a href="/adm/category">Категории</a>
                    </span>
                </h2>
            </div>

            <div class="mb-2">
                <a href="/adm/category/add">
                    <i class="fa-regular fa-square-plus"></i>
                    Новая категория
                </a>
            </div>

            <ul>
                <li>
                    <a href="/adm/category?s_hidden=1">
                        Только выключенные
                        <?=App::renderCounter('m_category', 'is_hidden', 1)?>
                    </a>
                </li>
            </ul>

            <div class="d-flex mb-2 mt-4">
                <h2 class="marker">
                    <span class="marker_h2">
                        <a href="/adm/product">Товары</a>
                    </span>
                </h2>
            </div>

            <div class="mb-2">
                <a href="/adm/product/add">
                    <i class="fa-regular fa-square-plus"></i>
                    Новый товар
                </a>
            </div>

            <ul>
                <li>
                    <a href="/adm/product?s_amount=1">
                        Нет в продаже
                        <?=App::renderCounter('m_product', 'amount_active', 0)?>
                    </a>
                </li>
                <li>
                    <a href="/adm/product?s_select=1">
                        Выделенные
                        <?=App::renderCounter('m_product', 'is_select', 1)?>
                    </a>
                </li>
                <li>
                    <a href="/adm/product?s_soon=1">
                        Скоро в продаже
                        <?=App::renderCounter('m_product', 'is_soon', 1)?>
                    </a>
                </li>
            </ul>

            <h5 class="text-secondary">Теги</h5>
            <ul>
                <?php foreach ($arrTag as $name => $value) : ?>
                    <?php if ($value != '') : ?>
                        <li>
                            <a href="/adm/product?s_tag=<?=$value?>">
                                <?=$name?>
                                <?=App::renderCounter('m_product', 'tag_' . $value, 1)?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <div class="d-flex mb-2 mt-4">
                <h2 class="marker">
                    <span class="marker_h2">
                        <a href="/adm/storage">Закупки</a>
                    </span>
                </h2>
            </div>

            <ul>
                <li>
                    <a href="/adm/storage?s_hidden=1">
                        Только выключенные
                        <?=App::renderCounter('m_storage', 'is_hidden', 1)?>
                    </a>
                </li>
            </ul>

        </div>

    </div>

</div>
