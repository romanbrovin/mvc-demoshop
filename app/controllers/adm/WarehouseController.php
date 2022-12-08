<?php

namespace app\controllers\adm;

class WarehouseController extends AppController
{

    public string $mainCaption = 'Список складов';
    public string $uri = 'warehouse';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'created_at' => 'дате',
            'name' => 'названию',
        ];

        $sort = $this->obj->sortOnPage($searchFields);

        $meta = [
            'breadcrumb' => '<li class="breadcrumb-item active">' . $this->mainCaption . '</li>',
            'h2' => $this->mainCaption,
            'title' => $this->mainCaption,
            'route' => $this->route,
            'template' => true,
            'addons' => ['nav', 'block-sort'],
            'item' => [
                'col' => 3,
                'blocks' => ['header', 'navbar', ],
                'btn' => ['edit', 'delete', 'comment',],
            ],
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination']));
    }

    public function addAction()
    {
        parent::addAction();

        $meta = [
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/adm/' . $this->uri . '">' . $this->mainCaption . '</a></li>
                <li class="breadcrumb-item active">' . $this->caption . '</li>',
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
            'block' => 'addSimpleName',
        ];

        $this->set(compact(['meta']));
    }

    public function editAction()
    {
        parent::editAction();
        $item = $this->obj;

        $meta = [
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/adm/' . $this->uri . '">' . $this->mainCaption . '</a></li>
                <li class="breadcrumb-item active">' . $this->caption . '</li>',
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
            'block' => 'editSimpleName',
        ];

        $this->set(compact(['meta', 'item']));
    }

    public function createAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'name',
        ];

        if ($this->obj->validateRequiredVars()) {
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
        ];

        if ($this->obj->validateRequiredVars()) {
            $this->obj->save();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

}