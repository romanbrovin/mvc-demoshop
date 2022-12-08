<?php

namespace app\controllers;

use app\models\Cabinet;
use R;
use vendor\libs\Pagination;

class CabinetController extends AppController
{

    public function indexAction()
    {
        if (isAuth()) {
            if (isAdmin()) {
                redirect('/adm');
                exit;
            }

            $totalEntries = R::count('m_order', "uid = ?", [$_SESSION['user']['uid']]);

            $pagination = new Pagination($totalEntries);
            $limitStart = $pagination->getLimitStart();
            $perPage = $pagination->perPage;

            $orders = Cabinet::getOrders($limitStart, $perPage);
            $orders = dateModifyInArray($orders);

            $meta = [
                'title' => "Личный кабинет",
                'robots' => 'noindex, nofollow',
                'breadcrumb' => '<li class="breadcrumb-item active">Личный кабинет</li>',
            ];

            $this->set(compact(['meta', 'orders', 'pagination']));
        } else {
            redirect('/login');
            exit;
        }
    }

    public function cancelAction()
    {
        if (isAjax() && isToken() && isAuth()) {
            $cabinet = new Cabinet();
            $cabinet->loadVars($_POST);
            $cabinet->cancelOrder();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

}