<?php

namespace app\controllers\adm;

class StorageController extends AppController
{

    public string $mainCaption = 'Список закупок';
    public string $uri = 'storage';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'created_at' => 'дате закупки',
            'price' => 'цене',
            'amount' => 'остаткам',
            'supplier_id' => 'поставщику',
            'warehouse_id' => 'адресу склада',
            'rack' => 'стеллажу',
            'pallet' => 'паллету',
            'box' => 'коробке',
        ];

        $sort = $this->obj->sortOnPage($searchFields);

        $meta = [
            'breadcrumb' => '<li class="breadcrumb-item active">' . $this->mainCaption . '</li>',
            'h2' => $this->mainCaption,
            'title' => $this->mainCaption,
            'route' => $this->route,
            'template' => true,
            'addons' => ['block-sort'],
            'item' => [
                'col' => 3,
                'blocks' => ['header', 'content', 'navbar', 'footer'],
                'btn' => ['edit', 'delete', 'comment', 'hidden', 'split'],
            ],
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination']));
    }

    public function addAction()
    {
        parent::addAction();

        $productId = $this->obj->vars['product_id'];

        $meta = [
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/adm/' . $this->uri . '">' . $this->mainCaption . '</a></li>
                <li class="breadcrumb-item active">' . $this->caption . '</li>',
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
        ];

        $this->set(compact(['meta', 'productId']));
    }

    public function editAction()
    {
        parent::editAction();


        $varsNullIfZero = ['rack', 'box', 'pallet'];

        foreach ($varsNullIfZero as $name) {
            if ($this->obj[$name] == 0) {
                $this->obj[$name] = null;
            }
        }
        $item = $this->obj;


        $meta = [
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/adm/' . $this->uri . '">' . $this->mainCaption . '</a></li>
                <li class="breadcrumb-item active">' . $this->caption . '</li>',
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
            'product_id',
            'price',
            'amount',
            'warehouse_id',
            'supplier_id',
        ];

        $this->obj->positiveNumbers = [
            'price',
            'amount',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->validatePositiveNumbers()) {
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
            'price',
            'amount',
            'warehouse_id',
            'supplier_id',
        ];

        $this->obj->positiveNumbers = [
            'price',
            'amount',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->validatePositiveNumbers()) {
            $this->obj->save();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

    public function setSplitAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'amount',
        ];

        $this->obj->positiveNumbers = [
            'amount',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->checkSplitAmount()
            && $this->obj->validatePositiveNumbers()) {
            $this->obj->setSplit();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

    public function deleteAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->delete();

        exit;
    }

    public function setHiddenAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setHidden();

        exit;
    }

}