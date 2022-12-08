<?php

namespace app\controllers;

class IndexController extends AppController
{

    public function indexAction()
    {
        $meta = [
            'title' => 'Демо-магазин',
            'description' => 'Доставка по всей России',
        ];

        $this->set(compact(['meta']));
    }

}


