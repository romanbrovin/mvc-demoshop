<?php

namespace app\models;

use R;

class Product
{

    public static function getById(int $id)
    {
        $product = R::load('m_product', $id);

        if ($product) {
            $category = App::findCells('name, url', 'm_category', $product['category_id']);

            $product['category_name'] = $category['name'];
            $product['category_url'] = $category['url'];

            return addAvatar($product);
        }
    }

    public static function countIncrease(int $id)
    {
        $query = "
            UPDATE m_product 
            SET counter = counter + 1 
            WHERE id = '$id'";

        R::exec($query);
    }

}