<?php

namespace app\controllers\adm;

use app\models\adm\Stats;

class StatsController extends AppController
{

    public string $mainCaption = 'Статистика';
    public string $uri = 'stats';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'amount_sells' => 'кол-ву продаж',
            'amount_storage' => 'остатку',
            'total_costs' => 'сумме остатка',
        ];

        $sort = $this->obj->sortOnPage($searchFields);

        $total = $this->obj->getTotal();

        $meta = [
            'breadcrumb' => '<li class="breadcrumb-item active">' . $this->mainCaption . '</li>',
            'h2' => $this->mainCaption,
            'title' => $this->mainCaption,
            'route' => $this->route,
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination', 'total']));
    }

    public function reloadAction()
    {
        Stats::reload();
        redirect();
    }

}