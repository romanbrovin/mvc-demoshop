<?php

namespace app\controllers\adm;

use app\models\adm\Order;

class OrderController extends AppController
{

    public string $mainCaption = 'Список заказов';
    public string $uri = 'order';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'created_at' => 'дате',
            'id' => 'номеру',
            'total_sum' => 'сумме',
            'bonus' => 'бонусам',
            'profit' => 'прибыли',
        ];

        $sort = $this->obj->sortOnPage($searchFields);

        $this->caption = 'Список заказов';

        $meta = [
            'breadcrumb' => '<li class="breadcrumb-item active">' . $this->caption . '</li>',
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
            'addons' => ['block-sort'],
            'item' => [
                'col' => 1,
                'blocks' => ['header', 'content', 'navbar'],
            ],
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination']));
    }

    public function editAction()
    {
        parent::editAction();

        if ($this->obj['current_status'] != 'checkouted' && $this->obj['current_status'] != 'confirmed') {
            redirect('/adm/order');
            exit;
        }

        $item = $this->obj;

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri?s_order_id={$this->obj['id']}'>{$this->obj['id']}</a>
                </li>
                <li class='breadcrumb-item active'>$this->caption</li>",
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
        ];

        $this->set(compact(['meta', 'item']));
    }

    public function saveAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'address',
            'delivery_price',
        ];

        if ($this->obj->validateRequiredVars()) {
            $this->obj->save();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

    public function writtenOffAction()
    {
        $this->validateAjaxAndToken();
        Order::writtenOff();

        exit;
    }

    public function confirmedAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->confirmed();

        exit;
    }

    public function transitedAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->transited();

        exit;
    }

    public function deliveredAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->delivered();

        exit;
    }

    public function canceledAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->canceled();

        exit;
    }

    public function returnedAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->returned();

        exit;
    }

    public function marketplaceAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->createByMarketplace();

        exit;
    }

    public function setDeliveryServiceAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setDeliveryService();

        exit;
    }

    public function setDeliveryTrackAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setDeliveryTrack();

        exit;
    }

    public function setMarketplaceOrderAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setMarketplaceOrder();

        exit;
    }

}