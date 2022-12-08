$(function () {

    getCountOfProductsInBasket();

    $('.basket__add').click(function () {
        event.preventDefault();
        productId = $(this).attr('data-product-id');
        $(this).html('<i class="fa-solid fa-check"></i> В корзине');
        addProductToBasket(productId);
    });

});

// показать корзину
function showBasket() {
    $.ajax({
        type: "POST",
        url: "/basket",
    }).done(function (html) {

        getCountOfProductsInBasket();

        $('.offcanvas').html(html);
        offcanvas.show();

    });
}

// добавляет в корзину товар
function addProductToBasket(productId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['productId'] = productId;

    $.ajax({
        type: "POST",
        url: "/basket/add",
        data: vars
    }).done(function () {

        showBasket();

    });
}

// удаление товара из корзины
function deleteProductFromBasket(basketId) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['basketId'] = basketId;

    $.ajax({
        type: "POST",
        url: "/basket/delete",
        data: vars
    }).done(function () {

        getTotalSumInBasket();
        getCountOfProductsInBasket();

        $('[data-basket-id=' + basketId + ']').fadeOut();

    });
}

function getTotalSumInBasket() {
    let vars = new Object();
    vars['token2'] = token2;

    $.ajax({
        type: "POST",
        url: "/basket/get-total-sum",
        data: vars
    }).done(function (totalSum) {

        if (totalSum > 0) {
            numberAnimation("#basket__total-sum", totalSum);
        }

    });
}

// считаем кол-во товаров в корзине
function getCountOfProductsInBasket() {
    let vars = new Object();
    vars['token2'] = token2;

    $.ajax({
        type: "POST",
        url: '/basket/get-count',
        data: vars
    }).done(function (count) {

        $('.nav__basket>span').text(count);

        // корзина открыта
        if ($('.offcanvas-title')) {
            if (count > 0) {
                $('.offcanvas-title').html(count + ' ' + wordByNumber(count, ['товар', 'товара', 'товаров']));
            } else {
                $('.offcanvas-title').html('Корзина пуста');
                $('.basket__footer').fadeOut();
            }
        }

    });
}

// новая цена на товар для списания
function setPriceInBasket(basketId, newPrice) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['basketId'] = basketId;
    vars['newPrice'] = newPrice;

    $.ajax({
        type: "POST",
        url: "/basket/set-price",
        data: vars
    }).done(function () {

        getTotalSumInBasket();

    });
}

// изменение кол-во товара в корзине
function setBasketAmount(basketId, currentAmount) {
    let vars = new Object();
    vars['token2'] = token2;
    vars['basketId'] = basketId;
    vars['currentAmount'] = currentAmount;

    $.ajax({
        type: "POST",
        url: "/basket/set-amount",
        data: vars
    }).done(function (totalAmount) {

        let parent = '[data-basket-id=' + basketId + ']';

        if (totalAmount == '') {
            $(parent + ' .basket__plus').addClass('btn-round_disable');
            $(parent + ' .basket__amount').html(currentAmount - 1);
        } else {
            $(parent + ' .basket__plus').removeClass('btn-round_disable');
            $(parent + ' .basket__amount').html(totalAmount);
        }

        getTotalSumInBasket();
        getCountOfProductsInBasket();

    });
}


