<?php

namespace app\controllers\adm;

use R;
use vendor\core\base\Controller;
use app\models\App;
use vendor\libs\Pagination;

class AppController extends Controller
{

    public string $layout = 'adm'; // текущий шаблон
    public string $table;          // имя текущей таблицы в базе данных
    public $pagination;
    public $list;
    public $obj;
    public $caption;

    public function __construct($route)
    {
        parent::__construct($route);

        if (!isAdmin()) {
            redirect('/login');
            exit;
        }

        new App;


        // таблица по умолчанию берется из контроллера (контроллер = имя_таблицы)
        $uri = str_replace('-', '_', explode('/', $_SERVER['REQUEST_URI']));
        if (isset($uri[2])) {
            $uri = explode('?', $uri[2]);
            $this->table = 'm_' . $uri[0];
        }

        $method = "app\models\\" . $this->route['prefix'] . $this->route['controller'];
        $this->obj = new $method();
        $this->obj->loadVars($_REQUEST);
    }

    public function indexAction()
    {
        $totalEntries = R::count($this->table, $this->obj->getQueryWhere());
        $pagination = new Pagination($totalEntries);

        $params = [
            'table' => $this->table,
            'where' => $this->obj->getQueryWhere(),
            'limit' => $pagination->getLimitStart(),
            'page' => $pagination->perPage,
        ];

        $this->list = $this->obj->getList($params);
        $this->pagination = $pagination;
    }

    public function addAction()
    {
        $this->caption = 'Новая запись';
    }

    public function editAction()
    {
        $this->caption = 'Редактирование';

        $this->obj = R::load($this->table, $this->obj->vars['id']);
        $this->obj = $this->obj->export();

        if ($this->obj['id'] == 0) {
            redirect('/adm/' . lcfirst($this->route['controller']));
            exit;
        }

        $this->obj = dateModifyInArray($this->obj);
    }

    public function deleteAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->simpleDelete($this->table);

        exit;
    }

    public function getDataAction()
    {
        $this->validateAjaxAndToken();
        $this->obj = R::findOne($this->table, 'id = ?', [$this->obj->vars['id']]);
        echo json_encode($this->obj);

        exit;
    }

    public function setCommentAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setComment($this->table);

        exit;
    }

    public function setHiddenAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setToogle($this->table, 'is_hidden');

        exit;
    }

    public function setSortOrderAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setSortOrder($this->table);

        exit;
    }

}