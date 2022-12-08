<?php

namespace app\controllers\adm;

class BannerController extends AppController
{

    public string $mainCaption = 'Список баннеров';
    public string $uri = 'banner';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'sort_order' => 'порядку',
            'url' => 'ссылке',
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
                'col' => 2,
                'blocks' => ['content', 'navbar',],
                'btn' => ['edit', 'delete', 'comment', 'sort'],
                'header' => [
                    'h4' => 'Баннер',
                    'marker' => 'marker_h4',
                ],
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
        ];

        $this->set(compact(['meta', 'item']));
    }

    public function createAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'url',
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
            'url',
        ];

        if ($this->obj->validateRequiredVars()) {
            $this->obj->save();
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

    public function uploadPhotoAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->uploadPhoto();

        exit;
    }

    public function deletePhotoAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->deletePhoto();

        exit;
    }

}