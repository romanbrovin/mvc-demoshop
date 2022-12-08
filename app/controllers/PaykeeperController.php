<?php

namespace app\controllers;

use app\models\Paykeeper;

class PaykeeperController extends AppController
{

    public function getPayLinkAction()
    {
        if (isAjax() && isToken()) {
            $obj = new Paykeeper();
            $obj->loadVars($_POST);
            echo $obj->getPayLink($obj->vars['id']);
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

}