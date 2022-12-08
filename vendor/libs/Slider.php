<?php

namespace vendor\libs;

use app\models\App;
use R;

class Slider
{

    /**
     * Вывод блока слайдера по имени группы
     */
    public static function renderByGroupName(string $groupName)
    {
        $totalEntries = R::count('m_product', 'amount_active > 0');

        if ($totalEntries > 0) {
            $groupMeta = require ROOT . '/config/group_meta.php';
            $queryWhere = 'amount_active > 0';

            if ($groupMeta[$groupName]['queryWhere']) {
                $queryWhere .= ' AND ' . $groupMeta[$groupName]['queryWhere'];
            }

            $query = "
                WHERE $queryWhere
                ORDER BY 
                        amount_active = 0
                    ,   price_adv_discount = 0 
                    ,   price_adv_discount_sum DESC
                LIMIT 12";

            $products = R::findAll('m_product', $query);


            $meta = $groupMeta[$groupName];
            $meta['url'] = $groupName;

            App::renderBlock('slider', ['meta' => $meta, 'products' => $products]);
        }
    }

    /**
     * Вывод блока слайдера по URL категории
     */
    public static function renderByCategoryId(int $categoryId)
    {
        $query = "
                WHERE
                    category_id = ?
                    AND amount_active > 0 
                ORDER BY 
                    amount_active = 0
                    ,   price_adv_discount = 0 
                    ,   price_adv_discount_sum DESC
                LIMIT 12";

        $products = R::findAll('m_product', $query, [$categoryId]);

        if (count($products) > 3) {
            $meta['sliderCaption'] = 'С этим набором покупают';
            App::renderBlock('slider', ['meta' => $meta, 'products' => $products]);
        }
    }

}