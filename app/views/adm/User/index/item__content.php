<div class="item__content">

    <?php if ($item['phone']): ?>
        <div>
            <a href="tel:<?=$item['phone']?>">
                +<?=$item['phone']?>
            </a>
        </div>
    <?php endif; ?>

    <?php if (strpos($item['email'], '@fake.ru') === false) : ?>
        <div>
            <a href="mailto:<?=$item['email']?>">
                <?=$item['email']?>
            </a>
        </div>
    <?php endif; ?>

    <div class="font-14 mt-1">
        <div class="me-1">
            Бонусы: <?=rank($item['bonus'])?> ₽
        </div>

        <div class="me-1">
            Покупки: <?=$item['purchases']?>
            <?php //if ($item['purchases'] > 0) :?>
            <a href="/adm/order?s_user_id=<?=$item['id']?>">
                <i class="fa-solid fa-link"></i>
                Список заказов
            </a>
            <?php //endif;?>
        </div>
        <div class="me-1">
            Авторизаций:
            <?=$item['counter']?>
        </div>
    </div>

</div>