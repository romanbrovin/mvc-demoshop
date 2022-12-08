<?php

return [
    'populars' => [
        'caption' => 'Самые популярные наборы',
        'sliderCaption' => 'Популярные наборы',
        'navCaption' => 'Популярные наборы',
        'title' => 'Популярные наборы',
        'description' => 'Популярные наборы',
        'breadcrumb' => 'Популярные наборы',
        'queryWhere' => '',
        'queryOrder' => 'counter DESC',
        'ico' => '<span class="text-danger"><i class="fa-solid fa-star"></i></span>',
    ],
    'bestsellers' => [
        'caption' => 'Хиты продаж магазина',
        'sliderCaption' => 'Хиты продаж',
        'navCaption' => 'Хиты продаж',
        'title' => 'Хиты продаж наборов',
        'description' => 'Хиты продаж в топовом магазине',
        'breadcrumb' => 'Хиты продаж',
        'queryWhere' => 'tag_hit = 1',
        'queryOrder' => '',
        'ico' => '<span class="text-danger"><i class="fa-brands fa-hotjar"></i></span>',
    ],
    'sales' => [
        'caption' => 'Распродажа',
        'sliderCaption' => 'Распродажа',
        'navCaption' => 'Распродажа',
        'title' => 'Распродажа',
        'description' => 'Распродажа в топовом магазине',
        'breadcrumb' => 'Распродажа',
        'queryWhere' => 'price_adv_discount_sum > 0',
        'queryOrder' => '',
        'ico' => '<i class="fa-solid fa-bullhorn"></i>',
    ],
    'news' => [
        'caption' => 'Новинки в магазине',
        'sliderCaption' => 'Новинки в магазине',
        'navCaption' => 'Новинки в магазине',
        'title' => 'Новинки в магазине',
        'description' => 'Новинки магазина в топовом магазине',
        'breadcrumb' => 'Новинки магазина',
        'queryWhere' => 'tag_new = 1',
        'queryOrder' => '',
        'ico' => '',
    ],
    'rares' => [
        'caption' => 'Редкие товары',
        'sliderCaption' => 'Редкие товары',
        'navCaption' => 'Редкие товары',
        'title' => 'Редкие товары',
        'description' => 'Редкие товары в топовом магазине',
        'breadcrumb' => 'Редкие товары',
        'queryWhere' => 'tag_rare = 1',
        'queryOrder' => '',
        'ico' => '',
    ],
    'low-price-guarantee' => [
        'caption' => 'Самые низкие цены на рынке',
        'sliderCaption' => 'Гарантия низкой цены',
        'navCaption' => 'Гарантия низкой цены',
        'title' => 'Гарантия низкой цены на товары',
        'description' => 'Гарантия низкой цены в топовом магазине',
        'breadcrumb' => 'Гарантия низкой цены',
        'queryWhere' => 'tag_low_price = 1',
        'queryOrder' => '',
        'ico' => '',
    ],
];
