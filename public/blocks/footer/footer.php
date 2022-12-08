<?php use app\models\App; ?>
<div class="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-7 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <h2>
                            Интернет-магазин
                            <a href="//<?=SITE_URL?>">demoshop.brovin.su</a>
                        </h2>
                    </div>
                    <div class="col-12">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="/">Главная</a>
                            </li>
                            <li class="list-inline-item">
                                <i class="fa-solid fa-layer-group"></i> <a href="/catalog">Каталог</a>
                            </li>
                            <?php $groupMeta = require ROOT . '/config/group_meta.php'; ?>
                            <?php foreach (array_keys($groupMeta) as $item) : ?>
                                <?php if ($groupMeta[$item]['navCaption']) : ?>
                                    <li class="list-inline-item">
                                        <?=$groupMeta[$item]['ico']?>
                                        <a href="/group/<?=$item?>">
                                            <?=$groupMeta[$item]['navCaption']?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="list-inline-item">
                                <i class="fa-solid fa-truck-fast"></i>
                                <a href="/delivery"> Доставка и оплата</a>
                            </li>
                            <li class="list-inline-item">
                                <i class="fas fa-phone-alt"></i>
                                <a href="/contacts">Контакты</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="/about">О магазине</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="/">
                                    Отзывы
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="/legal">Пользовательское соглашение</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <h3>Реквизиты</h3>
                        <p>
                            ООО ДемоМагазин
                            <br>
                            ОГРН 12345678909999
                            <br>
                            <i class="far fa-clock"></i>
                            Часы работы: Пн-Вс с 9:00 до 21:00
                            <br>
                            Калужская область, город Калуга
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <h3><a href="/contacts">Контакты</a></h3>
                        <p>
                            <i class="fas fa-phone-alt"></i>
                            Телефон:
                            <a href="/">+7 100 001-01-01</a>
                            <br>
                            Задать вопрос через
                            <i class="fab fa-telegram"></i>
                            <a href="/">telegram</a>
                            <br>
                            <i class="fas fa-edit"></i>
                            Написать в
                            <i class="fab fa-whatsapp"></i>
                            <a href="/">whatsapp</a>
                            <br>
                            <i class="fas fa-envelope"></i>
                            Электронная почта:
                            <a href="/">support@demoshop</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <h2>Все серии товаров</h2>
                <ul class="list-inline">
                    <?php $categories = App::getCategories(); ?>
                    <?php foreach ($categories as $category): ?>
                        <li class="list-inline-item">
                            <a href="/catalog/<?=$category['url']?>">
                                <?=$category['name']?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mb-4 mt-4">
                    <a href="https://brovin.su">
                        <div class="brovin">
                            Сайт сделал <strong>Роман Бровин</strong>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
