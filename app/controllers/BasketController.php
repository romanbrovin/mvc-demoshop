<?php

namespace app\controllers;

use app\models\Basket;

class BasketController extends AppController
{

    public function indexAction()
    {
        if (isAjax()) {
            $basket = Basket::getListByUid();
            require WWW . '/blocks/basket/basket.php';
        } else {
            include WWW . '/404.php';
        }
        exit;
    }

    public function addAction()
    {
        if (isAjax() && isToken()) {
            $basket = new Basket();
            $basket->loadVars($_POST);
            $basket->add();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function deleteAction()
    {
        if (isAjax() && isToken()) {
            $basket = new Basket();
            $basket->loadVars($_POST);
            $basket->delete();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function getCountAction()
    {
        if (isAjax() && isToken()) {
            echo Basket::getCount();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function getTotalSumAction()
    {
        if (isAjax() && isToken()) {
            echo Basket::getTotalSum();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function setAmountAction()
    {
        if (isAjax() && isToken()) {
            $basket = new Basket();
            $basket->loadVars($_POST);
            echo $basket->setAmount();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function setPriceAction()
    {
        if (isAjax() && isToken() && isAdmin()) {
            $basket = new Basket();
            $basket->loadVars($_POST);
            $basket->setPrice();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

}