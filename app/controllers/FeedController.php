<?php

namespace app\controllers;

use app\models\Feed;

class FeedController extends AppController
{

    private string $key = '1234567890';

    public function advAction()
    {
        $feed = new Feed();
        $feed->loadVars($_GET);

        if ($feed->vars['key'] == $this->key) {
            $feed->createAdv();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function ozonAction()
    {
        $feed = new Feed();
        $feed->loadVars($_GET);

        if ($feed->vars['key'] == $this->key) {
            $feed->createOzon();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

    public function dbsAction()
    {
        $feed = new Feed();
        $feed->loadVars($_GET);

        if ($feed->vars['key'] == $this->key) {
            $feed->createDbs();
        } else {
            include WWW . '/404.php';
        }

        exit;
    }

}


