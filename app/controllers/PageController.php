<?php

namespace app\controllers;

class PageController extends AppController
{

    public function deliveryAction()
    {
        $meta = [
            'title' => 'Доставка и оплата',
            'description' => 'Доставка и оплата в магазине',
            'breadcrumb' => '<li class="breadcrumb-item active">Доставка и оплата</li>',
        ];

        $this->set(compact(['meta']));
    }

    public function aboutAction()
    {
        $meta = [
            'title' => 'О магазине',
            'description' => 'ДемоМагазин - это надежный, удобный и современный интернет-магазин!',
            'breadcrumb' => '<li class="breadcrumb-item active">О магазине</li>',
        ];

        $this->set(compact(['meta']));
    }

    public function contactsAction()
    {
        $meta = [
            'title' => 'Контакты',
            'description' => 'Контакты магазина',
            'breadcrumb' => '<li class="breadcrumb-item active">Контакты</li>',
        ];

        $this->set(compact(['meta']));
    }

    public function legalAction()
    {
        $meta = [
            'title' => 'Пользовательское соглашение',
            'description' => 'Пользовательское соглашение магазина',
            'breadcrumb' => '<li class="breadcrumb-item active">Пользовательское соглашение</li>',
        ];

        $this->set(compact(['meta']));
    }

}
