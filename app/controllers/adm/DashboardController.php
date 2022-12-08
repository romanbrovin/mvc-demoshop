<?php

namespace app\controllers\adm;

use app\models\adm\Dashboard;
use R;

class DashboardController extends AppController
{

    public function indexAction()
    {
        $list = R::findAll('m_const');
        $marketplaceList = R::findAll('m_marketplace');

        $meta = [
            'title' => "Личный кабинет",
        ];

        $this->set(compact(['meta', 'list', 'marketplaceList']));
    }

    public function setSyncAction()
    {
        $this->validateAjaxAndToken();
        Dashboard::setSync();

        exit;
    }

    public function setFeedAction()
    {
        $this->validateAjaxAndToken();

        $obj = new Dashboard();
        $obj->loadVars($_POST);

        $obj->setFeed();

        exit;
    }

}