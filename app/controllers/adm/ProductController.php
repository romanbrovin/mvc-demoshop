<?php

namespace app\controllers\adm;

use R;

class ProductController extends AppController
{

    public string $mainCaption = 'Список товаров';
    public string $uri = 'product';

    public function indexAction()
    {
        parent::indexAction();

        $list = $this->list;
        $pagination = $this->pagination;

        $searchFields = [
            'article' => 'артикулу',
            'name' => 'названию',
            'category_id' => 'категории',
            'price_adv_profit' => 'доходности',
            'counter' => 'просмотрам',
            'amount' => 'остаткам',
            'amount_active' => 'остаткам (актив.)',
            'price_adv_discount' => 'цене adv',
            'price_dbs_discount' => 'цене dbs',
            'price_ozon_discount' => 'цене ozon',
            'price_wb_discount' => 'цене wb',
            'price_avito_discount' => 'цене avito',
            'price_avg' => 'закупочной цене',
            'parts' => 'деталям',
            'age' => 'мин. возрасту',
            'figures' => 'фигуркам',
            'year' => 'году выпуска',
            'bonus' => 'бонусам',
        ];

        $sort = $this->obj->sortOnPage($searchFields);

        $marketplaceList = R::findAll('m_marketplace');

        $meta = [
            'breadcrumb' => "<li class='breadcrumb-item active'>$this->mainCaption</li>",
            'h2' => $this->mainCaption,
            'title' => $this->mainCaption,
            'route' => $this->route,
            'template' => true,
            'addons' => ['nav', 'block-sort'],
            'item' => [
                'col' => 1,
                'blocks' => ['header', 'content', 'navbar', 'footer'],
                'btn' => ['edit', 'delete', 'comment',],
            ],
        ];

        $this->set(compact(['meta', 'list', 'sort', 'pagination', 'marketplaceList']));
    }

    public function addAction()
    {
        parent::addAction();

        $categoryId = $this->obj->vars['category_id'];

        $marketplaceList = R::findAll('m_marketplace');

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item active'>Новый товар</li>",
            'h2' => 'Новый товар',
            'title' => 'Новый товар',
            'route' => $this->route,
            'template' => true,
        ];

        $this->set(compact(['meta', 'categoryId', 'marketplaceList']));
    }

    public function editAction()
    {
        parent::editAction();

        $obj = R::load('m_category', $this->obj['category_id']);

        $this->obj['category_name'] = $obj['name'];

        $varsNullIfZero = ['barcode', 'figures', 'length_pack', 'width_pack', 'height_pack', 'weight_pack'];

        foreach ($varsNullIfZero as $name) {
            if ($this->obj[$name] == 0) {
                $this->obj[$name] = null;
            }
        }

        $item = $this->obj;

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri?s_product_id={$this->obj['id']}'>Арт. {$this->obj['article']}</a>
                </li>
                <li class='breadcrumb-item active'>$this->caption</li>",
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
            'template' => true,
        ];

        $this->set(compact(['meta', 'item']));
    }

    public function photoAction()
    {
        parent::editAction();

        $obj = R::load('m_category', $this->obj['category_id']);

        $this->obj['category_name'] = $obj['name'];
        $this->obj['category_url'] = $obj['url'];
        $this->obj = addAvatar($this->obj);

        $item = $this->obj;
        $this->caption = 'Загрузка фотографий';

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri?s_product_id={$this->obj['id']}'>Арт. {$this->obj['article']}</a>
                </li>
                <li class='breadcrumb-item active'>$this->caption</li>",
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
        ];

        $this->set(compact(['meta', 'item']));
    }
    public function priceAction()
    {
        parent::editAction();

        $item = $this->obj;
        $this->caption = 'Цены на товар';

        $marketplaceList = R::findAll('m_marketplace');

        $meta = [
            'breadcrumb' => "
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri'>$this->mainCaption</a>
                </li>
                <li class='breadcrumb-item'>
                    <a href='/adm/$this->uri?s_product_id={$this->obj['id']}'>Арт. {$this->obj['article']}</a>
                </li>
                <li class='breadcrumb-item active'>$this->caption</li>",
            'h2' => $this->caption,
            'title' => $this->caption,
            'route' => $this->route,
        ];

        $this->set(compact(['meta', 'item', 'marketplaceList']));
    }

    public function createAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'name',
            'article',
            'category_id',
            'parts',
            'age',
            'year',
            'length',
            'width',
            'height',
            'weight',
        ];

        $this->obj->positiveNumbers = [
            'parts',
            'age',
            'year',
            'length',
            'width',
            'height',
            'weight',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->validatePositiveNumbers()
            && $this->obj->checkUniqueName() && $this->obj->checkUniqueArticle()) {
            $this->obj->create();
            echo json_encode('ok');
        } else {
            echo json_encode($this->obj->errors);
        }

        exit;
    }

    public function setPricesAction()
    {
        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'id',
        ];

        if ($this->obj->validateRequiredVars()) {
            $this->obj->setPrices();
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
            'article',
            'category_id',
            'parts',
            'age',
            'year',
            'length',
            'width',
            'height',
            'weight',
        ];

        $this->obj->positiveNumbers = [
            'parts',
            'age',
            'year',
            'length',
            'width',
            'height',
            'weight',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->validatePositiveNumbers()
            && $this->obj->checkExistName() && $this->obj->checkExistArticle()) {
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

    public function setAvatarAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setAvatar();

        exit;
    }

    public function setMarkAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setToogle($this->table, 'is_select');

        exit;
    }

    public function setSoonAction()
    {
        $this->validateAjaxAndToken();
        $this->obj->setToogle($this->table, 'is_soon');

        exit;
    }

}