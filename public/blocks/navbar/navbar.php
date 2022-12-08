<div class="navbar navbar-expand-lg fixed-top">
    <div class="container">

        <a class="navbar-brand" href="/">
            <img alt="Логотип" class="d-inline-block align-text-top" height="24" src="/images/logotype.png">
            Демо <span class="fw-bold">Магазин</span>
        </a>

        <button class="navbar-toggler" data-bs-target="#navbar__collapse" data-bs-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar__collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="/catalog">
                        <i class="fa-solid fa-layer-group"></i> Каталог
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav__catalog1" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-cubes"></i> Наборы
                    </a>
                    <ul class="dropdown-menu">
                        <?php $groupMeta = require ROOT . '/config/group_meta.php'; ?>
                        <?php foreach (array_keys($groupMeta) as $item) : ?>
                            <?php if ($groupMeta[$item]['navCaption']) : ?>
                                <li>
                                    <a class="dropdown-item" href="/group/<?=$item?>">
                                        <?=$groupMeta[$item]['ico']?> <?=$groupMeta[$item]['navCaption']?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav__categories" href="#">
                        <i class="fa-solid fa-list-check"></i> Серии товаров
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav__search" href="#">
                        <i class="fa-solid fa-magnifying-glass"></i> Поиск
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/delivery">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span class="nav__link_delivery">
                            Доставка и оплата
                        </span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link nav__basket" href="#">
                        <i class="fa-solid fa-cart-shopping"></i> Корзина
                        <span class="badge rounded-pill text-bg-secondary"></span>
                    </a>
                </li>

                <?php if (isAuth()) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/cabinet">
                            <i class="fa-solid fa-user"></i>
                            Кабинет
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <span class="nav__link_login">
                                Войти
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>

    </div>
</div>