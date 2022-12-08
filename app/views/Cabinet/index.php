<div class="d-flex mb-2">
    <h1 class="marker">
        <span class="marker_h1">Личный кабинет</span>
    </h1>
</div>

<div class="d-flex h2 mb-3">
    Здравствуйте, <?=$_SESSION['user']['name']?>!
</div>

<div class="d-flex row mb-4">

    <div class="col-md-8 col-sm-12">
        <ul class="list-inline">
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip"
                data-bs-title="Бонусы начисляются сразу после оплаты или подтверждения заказа менеджером">
                <span class="dotted">Накопленные бонусы:</span>
                <?=$_SESSION['user']['bonus']?> ₽
            </li>
        </ul>
    </div>

    <div class="d-flex col-md-4 col-sm-12">
        <ul class="list-inline ms-md-auto">
            <li class="list-inline-item me-3">
                <a href="/settings">
                    <i class="fas fa-cog"></i> Настройки
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Выйти
                </a>
            </li>
        </ul>
    </div>
</div>

<?php if ($pagination->totalEntries) : ?>

    <div class="row g-4">

        <?php foreach ($orders as $order) : ?>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">

                <div class="order box-shadow p-4 pt-3 pb-3 rounded border bg-white" id="<?=$order['id']?>">

                    <?php include 'content_header.php'; ?>
                    <?php include 'content_status.php'; ?>

                    <?php if ($order['current_status'] == 'new') : ?>
                        <a class="btn btn-primary mb-4 mt-4 order__continue">
                            Продолжить оформление
                        </a>
                    <?php elseif ($order['current_status'] == 'checkouted') : ?>
                        <?php if ($order['payment'] == 1) : ?>
                            <a class="btn btn-success mb-4 mt-4 order__pay" href="#">
                                Оплатить заказ
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php include 'content_delivery.php'; ?>
                    <?php include 'content_basket.php'; ?>

                    <div class="offset-4 col-8">
                        <hr class="mt-0">
                    </div>

                    <?php include 'content_total.php'; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?=($pagination->countPages > 1) ? $pagination : ''?>

<?php else : ?>

    <div class="oops text-secondary">
        Вы пока не сделали ни одной покупки
        <br>
        <a href="/">Начать покупки!</a>
    </div>

<?php endif; ?>

<div class="mt-120">
    <?php \vendor\libs\Slider::renderByGroupName('populars'); ?>
</div>


