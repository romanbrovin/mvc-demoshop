<?php if ($route['controller'] != 'Index' && !$route['prefix']) : ?>

<div class="d-none d-md-block">
    <ol class="breadcrumb mt-3 mb-4">
        <li class="breadcrumb-item">
            <a href="/">
                <i class="fa-solid fa-house"></i> Главная
            </a>
        </li>
        <?=$meta['breadcrumb']?>
    </ol>
</div>

<?php elseif ($route['controller'] != 'Dashboard' && $route['prefix']) : ?>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="/adm">
                <i class="fa-solid fa-house"></i>
                Рабочий стол
            </a>
        </li>
        <?=$meta['breadcrumb']?>
    </ol>

<?php endif; ?>
