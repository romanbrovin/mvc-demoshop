<?php

namespace app\controllers\adm;

class PaykeeperController extends AppController
{

    public string $mainCaption = 'Список онлайн платежей';
    public string $uri = 'paykeeper';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'created_at' => 'дате',
            'order_id' => 'номеру заказа',
            'sum' => 'сумме',
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
                'blocks' => ['header', 'footer'],
            ],
            'h5' => $this->obj->balance(),
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination']));
    }

}
