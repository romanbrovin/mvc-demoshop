<?php

namespace app\controllers\adm;

class ReportController extends AppController
{

    public string $mainCaption = 'Отчет';
    public string $uri = 'report';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'created_at' => 'дате',
            'amount' => 'сумме',
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

    public function addAction()
    {
        $type = $this->obj->vars['type'];

        $meta = [
            'title' => "Новая запись",
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/adm/report">Отчет</a></li>
                <li class="breadcrumb-item active">Новая запись</li>',
        ];

        $this->set(compact(['meta', 'type']));
    }

}
