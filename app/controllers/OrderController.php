<?php

namespace app\controllers;

use app\models\Basket;
use app\models\Order;
use app\models\User;
use R;

class OrderController extends AppController
{

    public function indexAction()
    {
        if (!Order::isNew()) {
            redirect("/catalog");
            exit;
        }

        $basket = Basket::getListByUidAndOrderId();
        $order = R::findOne('m_order', 'id = ?', [$_COOKIE['orderId']]);
        $courierAddresses = Order::courierAddresses();

        $meta = [
            'title' => "Оформление заказа",
            'robots' => 'noindex, nofollow',
            'breadcrumb' => '<li class="breadcrumb-item active">Оформление заказа</li>',
        ];

        $this->set(compact(['meta', 'basket', 'order', 'courierAddresses']));
    }

    public function successAction()
    {
        $meta = [
            'title' => "Заказ оплачен",
            'robots' => 'noindex, nofollow',
            'refresh' => '5;URL=/cabinet',
            'breadcrumb' => '<li class="breadcrumb-item active">Оплата прошла успешно</li>',
        ];

        $this->set(compact(['meta',]));
    }

    public function failAction()
    {
        $meta = [
            'title' => "Ошибка оплаты",
            'robots' => 'noindex, nofollow',
            'refresh' => '5;URL=/cabinet',
            'breadcrumb' => '<li class="breadcrumb-item active">Ошибка при оплате</li>',
        ];

        $this->set(compact(['meta',]));
    }

    public function createAction()
    {
        if (isAjax() && isToken()) {
            $order = new Order();
            $order->create();
            echo 'ok';
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function checkoutAction()
    {
        if (isAjax() && isToken()) {
            $order = new Order();
            $order->loadVars($_POST);

            $order->requiredVars = [
                'address',
            ];

            if ($order->validateRequiredVars()) {
                $order->update();

                if (isAuth()) {
                    $order->checkout();
                    echo json_encode('ok');
                } else {
                    $user = new User();
                    $user->loadVars($_POST);

                    $user->requiredVars = [
                        'surname',
                        'name',
                        'email',
                        'phone',
                        'captcha',
                    ];

                    if ($user->validateRequiredVars() && $user->checkUniqueEmail()) {
                        $user->signup();
                        $user->login();
                        $order->checkout();
                        echo json_encode('ok');
                    } else {
                        echo json_encode($user->errors);
                    }
                }
            } else {
                echo json_encode($order->errors);
            }
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function updateAction()
    {
        if (isAjax() && isToken()) {
            $order = new Order();
            $order->loadVars($_POST);
            $order->update();
            $order = R::findOne('m_order', 'id = ?', [$_COOKIE['orderId']]);
            echo json_encode($order);
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function calculationDeliveryAction()
    {
        if (isAjax() && isToken()) {
            $order = new Order();
            $order->loadVars($_POST);

            if ($order->getCalculationDelivery()) {
                echo json_encode($order->deliveryData);
            } else {
                echo json_encode($order->errors);
            }
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function resetDeliveryAction()
    {
        if (isAjax() && isToken()) {
            $order = new Order();
            $order->resetDelivery();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function setBonusAction()
    {
        if (isAjax() && isToken()) {
            $order = new Order();
            $order->setBonus();
            echo $_SESSION['user']['bonus'];
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

}