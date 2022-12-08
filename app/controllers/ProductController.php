<?php

namespace app\controllers;

use app\models\Product;
use R;

class ProductController extends AppController
{

    public function indexAction()
    {
        $product = R::findOne('m_product', 'article = ?', [$this->route['article']]);

        if (!$product) {
            redirect("/catalog/{$this->route['category']}");
            exit;
        }

        $category = R::findOne('m_category', 'id = ?', [$product['category_id']]);
        $product['category_name'] = $category['name'];
        $product['category_url'] = $category['url'];

        $product = addAvatar($product);

        Product::countIncrease($product['id']);

        $meta = [
            'title' => "{$product['category_name']} {$product['article']} {$product['name']}",
            'description' => "Продается новый товар {$product['category_name']} {$product['article']} {$product['name']}",
            'breadcrumb' => "
                <li class='breadcrumb-item'><a href='/catalog'>Каталог товаров</a></li>
                <li class='breadcrumb-item'><a href='/catalog/{$product['category_url']}'>Серия {$product['category_name']}</a></li>
                <li class='breadcrumb-item active'>{$product['category_name']} {$product['article']} {$product['name']}</li>",
        ];

        $this->set(compact(['meta', 'product']));
    }

}