<?php

namespace app\controllers\adm;

class UserController extends AppController
{

    public string $mainCaption = 'Список клиентов';
    public string $uri = 'user';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'name' => 'имени',
            'surname' => 'фамилии',
            'email' => 'электронной почте',
            'phone' => 'телефону',
            'bonus' => 'бонусам',
            'purchases' => 'покупкам',
            'counter' => 'авторизациям',
        ];

        $sort = $this->obj->sortOnPage($searchFields);

        $meta = [
            'breadcrumb' => "<li class='breadcrumb-item active'>$this->mainCaption</li>",
            'h2' => $this->mainCaption,
            'title' => $this->mainCaption,
            'route' => $this->route,
            'template' => true,
            'addons' => ['nav', 'block-sort'],
            'item' => [
                'col' => 3,
                'blocks' => ['header', 'content', 'navbar', 'footer'],
                'btn' => ['edit', 'delete', 'comment',],
            ],
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination']));
    }

    public function addAction()
    {
        parent::addAction();

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item active'>Новый клиент</li>",
            'h2' => 'Новый клиент',
            'title' => 'Новый клиент',
            'route' => $this->route,
            'template' => true,
        ];

        $this->set(compact(['meta']));
    }

    public function editAction()
    {
        parent::editAction();
        $item = $this->obj;

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri?s_user_id={$this->obj['id']}'>{$this->obj['name']} {$this->obj['surname']}</a>
                </li>
                <li class='breadcrumb-item active'>$this->caption</li>",
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
        ];

        $this->set(compact(['meta', 'item']));
    }

    public function createAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'name',
            'surname',
            'email',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->checkUniqueEmail()) {
            $this->obj->create();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

    public function saveAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'name',
            'surname',
            'email',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->checkExistEmail()) {
            $this->obj->save();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

}