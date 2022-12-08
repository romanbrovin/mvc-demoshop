<?php if (isset($basket)): ?>

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"></h5>
        <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" type="button"></button>
    </div>

    <div class="offcanvas-body">

        <?php foreach ($basket as $basketItem) : ?>
            <?php $product = \app\models\Product::getById($basketItem['product_id']); ?>

            <div class="basket row mb-4" data-basket-id="<?=$basketItem['id']?>"
                 data-product-id="<?=$basketItem['product_id']?>">

                <div class="col-4">
                    <img alt="<?=$product['alt']?>" class="img-fluid" loading="lazy" src="<?=$product['avatar']?>">
                </div>

                <div class="col-7">

                    <a href="/catalog/<?=$product['category_url']?>/<?=$basketItem['article']?>">
                        <?=$product['name']?>, <?=$basketItem['article']?>
                    </a>

                    <div class="fw-bold">
                        <?php if (isAdmin()) : ?>
                            <input class="basket__price" type="text" value="<?=$basketItem['price_adv']?>"> ₽
                        <?php else : ?>
                            <?=rank($basketItem['price_adv'])?> ₽
                        <?php endif; ?>
                    </div>

                    <div class="d-flex flex-row mt-2">
                        <div class="basket__minus btn-round btn-round_event btn-round_minus"></div>
                        <div class="basket__amount px-2"><?=$basketItem['amount']?></div>
                        <div class="basket__plus btn-round btn-round_event btn-round_plus"></div>
                    </div>

                </div>

                <div class="col-1 px-0">
                    <div class="basket__delete btn-round btn-round_delete"></div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <div class="basket__footer">
        <div class="offcanvas-footer border-top p-3 d-flex">
            <?php if ($basket) : ?>
                <div class="flex-fill align-self-center fw-bold">
                    Итого: <span id="basket__total-sum"><?=rank(\app\models\Basket::getTotalSum())?></span> ₽
                </div>
                <div>
                    <?php if (isAdmin()) : ?>
                        <div class="btn-group dropup">
                            <button class="btn btn-success" id="order__written_off">Списать</button>
                            <button class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown" type="button">
                            </button>
                            <?php $marketplaceList = R::findAll('m_marketplace'); ?>
                            <ul class="dropdown-menu">
                                <?php foreach ($marketplaceList as $marketplace) : ?>
                                    <?php if ($marketplace['short_name'] != 'adv'): ?>
                                        <li>
                                            <a class="dropdown-item order__marketplace"
                                               data-market="<?=$marketplace['short_name']?>" href="#">
                                                Создать заказ <?=$marketplace['name']?>
                                                (<?=$marketplace['short_name']?>)
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <button class="btn btn-success" id="order__create">Оформить заказ</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <script>

        $('#order__written_off').click(function () {
            let vars = new Object();
            vars['token2'] = token2;

            $(this).prop('disabled', true);

            loader();

            $.ajax({
                type: "POST",
                url: '/adm/order/written-off',
                data: vars
            }).done(function () {

                offcanvas.hide();
                $('.toast').addClass('text-bg-success');
                $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Товары списаны со склада');
                toast.show();

                setTimeout(function () {
                    location.href = "/adm/order";
                }, 1000);

            });

        });

        $('.order__marketplace').click(function () {
            let vars = new Object();
            vars['token2'] = token2;
            vars['marketplace'] = $(this).attr('data-market');

            $(this).prop('disabled', true);

            loader();

            $.ajax({
                type: "POST",
                url: "/adm/order/marketplace",
                data: vars
            }).done(function () {

                offcanvas.hide();
                $('.toast').addClass('text-bg-success');
                $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;' +
                    'Заказ (' + vars['marketplace'] + ') создан');
                toast.show();

                setTimeout(function () {
                    location.href = "/adm/order";
                }, 1000);

            });
        });

        $('#order__create').click(function () {
            let vars = new Object();
            vars['token2'] = token2;

            $(this).prop('disabled', true);

            loader();

            $.ajax({
                type: "POST",
                url: '/order/create',
                data: vars
            }).done(function () {

                offcanvas.hide();
                $('.toast').addClass('text-bg-success');
                $('.toast-body').html('<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Заказ сформирован');
                toast.show();

                setTimeout(function () {
                    location.href = "/order";
                }, 1000);

            });
        });

        $('.basket__price').change(function () {
            let basketId = $(this).closest('.basket').attr('data-basket-id');
            let newPrice = $('[data-basket-id=' + basketId + '] .basket__price').val();
            setPriceInBasket(basketId, newPrice);
        });

        $('.basket__minus').click(function () {
            let basketId = $(this).closest('.basket').attr('data-basket-id');
            let amountField = $('[data-basket-id=' + basketId + '] .basket__amount');
            let currentAmount = parseInt(amountField.html().trim()) - 1;

            if (currentAmount < 1) {
                deleteProductFromBasket(basketId);
            } else {
                setBasketAmount(basketId, currentAmount);
            }
        });

        $('.basket__plus').click(function () {
            let basketId = $(this).closest('.basket').attr('data-basket-id');
            let amountField = $('[data-basket-id=' + basketId + '] .basket__amount');
            let currentAmount = parseInt(amountField.html().trim()) + 1;

            setBasketAmount(basketId, currentAmount);
        });

        $('.basket__delete').click(function () {
            event.preventDefault();
            let basketId = $(this).closest('.basket').attr('data-basket-id');
            let productId = $(this).closest('.basket').attr('data-product-id');
            $('.basket__add[data-product-id="' + productId + '"]').html('<i class="fas fa-cart-arrow-down"></i> В корзину');
            deleteProductFromBasket(basketId);
        });

    </script>
<?php endif; ?>