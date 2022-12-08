<?php

namespace app\controllers;

use vendor\core\base\Controller;
use app\models\App;

class AppController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);

        new App;
    }

}
