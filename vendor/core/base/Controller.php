<?php

namespace vendor\core\base;

abstract class Controller
{

    public $view;                   // вид
    public string $layout = LAYOUT; // текущий шаблон
    public array $route = [];       // текущий маршрут и параметры (controller, action, params)
    public array $vars = [];        // пользовательские данные

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars)
    {
        $this->vars = $vars;
    }

    public function validateAjaxAndToken()
    {
        if (!isAjax() || !isToken()) {
            include WWW . '/404.php';
            exit;
        }
    }

}
