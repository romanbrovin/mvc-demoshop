<li class="nav-dashboard">
    <a href="/adm" class="nav-link <?=($route['controller'] == 'Dashboard') ? 'active' : null?>">
        Рабочий стол
    </a>
</li>

<li class="nav-order">
    <a href="/adm/order" class="nav-link <?=($route['controller'] == 'Order') ? 'active' : null?>">
        Заказы
        <?=\app\models\adm\Order::renderCounter('m_order', 'current_status', 'checkouted', 'primary')?>
    </a>
</li>

<li class="nav-user">
    <a href="/adm/user" class="nav-link <?=($route['controller'] == 'User') ? 'active' : null?>">
        Клиенты
    </a>
</li>

<li class="nav-category">
    <a href="/adm/category" class="nav-link <?=($route['controller'] == 'Category') ? 'active' : null?>">
        Категории
    </a>
</li>

<li class="nav-product">
    <a href="/adm/product" class="nav-link <?=($route['controller'] == 'Product') ? 'active' : null?>">
        Товары
    </a>
</li>

<li class="nav-storage">
    <a href="/adm/storage" class="nav-link <?=($route['controller'] == 'Storage') ? 'active' : null?>">
        Закупки
    </a>
</li>

<li class="nav-warehouse">
    <a href="/adm/warehouse" class="nav-link <?=($route['controller'] == 'Warehouse') ? 'active' : null?>">
        Склады
    </a>
</li>

<li class="nav-supplier">
    <a href="/adm/supplier" class="nav-link <?=($route['controller'] == 'Supplier') ? 'active' : null?>">
        Поставщики
    </a>
</li>

<li class="nav-report">
    <a href="/adm/report" class="nav-link <?=($route['controller'] == 'Report') ? 'active' : null?>">
        <i class="fa-solid fa-book"></i> Отчет
    </a>
</li>

<li class="nav-costs">
    <a href="/adm/costs" class="nav-link <?=($route['controller'] == 'Costs') ? 'active' : null?>">
        Расходы
    </a>
</li>

<li class="nav-paykeeper">
    <a href="/adm/paykeeper" class="nav-link <?=($route['controller'] == 'Paykeeper') ? 'active' : null?>">
        <i class="fa-regular fa-credit-card"></i>
        PayKeeper
    </a>
</li>

<li class="nav-facts">
    <a href="/adm/facts" class="nav-link <?=($route['controller'] == 'Facts') ? 'active' : null?>">
        Факты о товаре
    </a>
</li>

<li class="nav-banner">
    <a href="/adm/banner" class="nav-link <?=($route['controller'] == 'Banner') ? 'active' : null?>">
        Баннера
    </a>
</li>

<li class="nav-stats">
    <a href="/adm/stats" class="nav-link <?=($route['controller'] == 'Stats') ? 'active' : null?>">
        Статистика
    </a>
</li>

<li class="nav-settings">
    <a href="/settings" class="nav-link">
        <i class="fas fa-cog"></i>
        Настройки
    </a>
</li>

<li class="nav-exit">
    <a href="#" class="logout nav-link">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        Выйти
    </a>
</li>
