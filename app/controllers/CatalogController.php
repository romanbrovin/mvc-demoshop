<?php

namespace app\controllers;

use app\models\Catalog;
use R;
use vendor\libs\Pagination;

class CatalogController extends AppController
{

    public function indexAction()
    {
        $totalEntries = R::count('m_product');

        $pagination = new Pagination($totalEntries);
        $limitStart = $pagination->getLimitStart();
        $perPage = $pagination->perPage;

        $products = Catalog::getAllProducts($limitStart, $perPage);

        $sort = Catalog::sortOnPage();
        $sort['perPage'] = $perPage;
        $sort['listPerPage'] = $pagination::LIST_PER_PAGE;

        $meta = [
            'title' => 'Каталог товаров',
            'breadcrumb' => '<li class="breadcrumb-item active">Каталог</li>',
        ];

        $this->set(compact(['meta', 'products', 'sort', 'pagination']));
    }

    public function searchAction()
    {
        $searchQuery = filterString($_GET['s']);

        if (!$searchQuery) {
            header('Location: /catalog');
            exit;
        }

        $totalEntries = Catalog::getCountOfProductsBySearchQuery($searchQuery);

        $pagination = new Pagination($totalEntries);
        $limitStart = $pagination->getLimitStart();
        $perPage = $pagination->perPage;

        $products = Catalog::getProductsBySearchQuery($limitStart, $perPage, $searchQuery);

        $sort = Catalog::sortOnPage();
        $sort['perPage'] = $perPage;
        $sort['listPerPage'] = $pagination::LIST_PER_PAGE;

        $meta = [
            'title' => $searchQuery . ' - поиск по каталогу товаров',
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/catalog">Каталог</a></li>
                <li class="breadcrumb-item active">Поиск по каталогу</li>',
        ];

        $this->set(compact(['meta', 'products', 'sort', 'pagination', 'searchQuery']));
    }

    public function groupAction()
    {
        $groupName = $this->route['group'];
        $totalEntries = Catalog::getCountOfProductsByGroupName($groupName);

        if ($totalEntries == 0) {
            header('Location: /catalog');
            exit;
        }

        $pagination = new Pagination($totalEntries);
        $limitStart = $pagination->getLimitStart();
        $perPage = $pagination->perPage;

        $products = Catalog::getProductsByGroupName($limitStart, $perPage, $groupName);

        $sort = Catalog::sortOnPage();
        $sort['perPage'] = $perPage;
        $sort['listPerPage'] = $pagination::LIST_PER_PAGE;

        $groupMeta = Catalog::getGroupMetaByName($groupName);

        $meta = [
            'title' => $groupMeta['title'],
            'description' => $groupMeta['description'],
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/catalog">Каталог товаров</a></li>
                <li class="breadcrumb-item active">' . $groupMeta['breadcrumb'] . '</li>',
            'ico' => $groupMeta['ico'],
            'caption' => $groupMeta['caption'],
        ];

        $this->set(compact(['meta', 'products', 'sort', 'pagination']));
    }

    public function categoryAction()
    {
        $categoryUrl = $this->route['category'];
        $category = R::findOne('m_category', 'url = ?', [$categoryUrl]);

        if (!$category) {
            header('Location: /catalog');
            exit;
        }

        $totalEntries = R::count('m_product', 'category_id = ?', [$category['id']]);

        $pagination = new Pagination($totalEntries);
        $limitStart = $pagination->getLimitStart();
        $perPage = $pagination->perPage;

        $products = Catalog::getProductsByCategoryId($limitStart, $perPage, $category['id']);

        $sort = Catalog::sortOnPage();
        $sort['perPage'] = $perPage;
        $sort['listPerPage'] = $pagination::LIST_PER_PAGE;

        $meta = [
            'title' => $category['name'] . ' - каталог товаров',
            'description' => $category['name'] . ' - магазин',
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/catalog">Каталог товаров</a></li>
                <li class="breadcrumb-item active">Серия ' . $category['name'] . '</li>',
        ];

        $this->set(compact(['meta', 'products', 'sort', 'pagination', 'category']));
    }

}