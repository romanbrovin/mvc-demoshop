<?php

namespace app\models;

use R;

class Catalog
{

    public static function getAllProducts(int $limitStart, int $perPage): array
    {
        $query = "
            ORDER BY " . self::getQueryOrder() . "
            LIMIT $limitStart, $perPage";

        return R::findAll('m_product', $query);
    }

    public static function getCountOfProductsBySearchQuery(string $searchQuery): int
    {
        $query = "
            SELECT id
            FROM m_product
            WHERE 
                    name LIKE ?
                OR  article LIKE ?
                OR  year LIKE ?
                OR  category_id LIKE 
                    (
                        SELECT id
                        FROM m_category
                        WHERE 
                                name LIKE ?
                            OR  url LIKE ?
                    )";

        $product = R::getAll($query, [
            "%$searchQuery%",
            "%$searchQuery%",
            "%$searchQuery%",
            "%$searchQuery%",
            "%$searchQuery%",
        ]);

        return count($product);
    }

    /**
     * Товары по поисковому запросу
     */
    public static function getProductsBySearchQuery(int $limitStart, int $perPage, string $searchQuery): array
    {
        $query = "
            SELECT *
            FROM m_product
            WHERE 
                    name LIKE ?
                OR  article LIKE ?
                OR  year LIKE ?
                OR  category_id LIKE 
                    (
                        SELECT id
                        FROM m_category
                        WHERE 
                                name LIKE ?
                            OR  url LIKE ?
                    )
            ORDER BY " . self::getQueryOrder() . " 
            LIMIT $limitStart, $perPage";

        return R::getAll($query, [
            "%$searchQuery%",
            "%$searchQuery%",
            "%$searchQuery%",
            "%$searchQuery%",
            "%$searchQuery%",
        ]);
    }

    public static function getCountOfProductsByGroupName(string $name): int
    {
        $groupMeta = require ROOT . '/config/group_meta.php';

        // нет вхождение в список групп
        if (!array_key_exists($name, $groupMeta)) {
            return 0;
        }

        if ($groupMeta[$name]['queryWhere']) {
            $queryWhere = 'AND ' . $groupMeta[$name]['queryWhere'];
        } else {
            $queryWhere = null;
        }

        $query = 'amount_active > 0 ' . $queryWhere;

        return R::count('m_product', $query);
    }

    /**
     * Товары по названию группы
     */
    public static function getProductsByGroupName(int $limitStart, int $perPage, string $name): array
    {
        $groupMeta = require ROOT . '/config/group_meta.php';

        // нет вхождение в список групп
        if (!array_key_exists($name, $groupMeta)) {
            return [];
        }

        $queryWhere = null;

        if ($groupMeta[$name]['queryWhere']) {
            $queryWhere = 'AND ' . $groupMeta[$name]['queryWhere'];
        }

        $query = "
            WHERE
                amount_active > 0
                $queryWhere
            ORDER BY " . self::getQueryOrder() . "
            LIMIT $limitStart, $perPage";

        return R::findAll('m_product', $query);
    }

    /**
     * Все товары по ID категории
     */
    public static function getProductsByCategoryId(int $limitStart, int $perPage, int $categoryId): array
    {
        $query = "
            WHERE category_id = ?
            ORDER BY " . self::getQueryOrder() . "
            LIMIT $limitStart, $perPage";

        return R::findAll('m_product', $query, [$categoryId]);
    }

    /**
     * Получаем мета данные группы из глобального массива $groupMeta
     */
    public static function getGroupMetaByName(string $name): array
    {
        $groupMeta = require ROOT . '/config/group_meta.php';

        return $groupMeta[$name];
    }

    /**
     * Порядок сортировки
     */
    public static function getQueryOrder(string $name = ''): string
    {
        $groupMeta = require ROOT . '/config/group_meta.php';

        $queryOrder = '';

        // передано имя группы и есть запрос сортировки в массиве группы
        if ($name && $groupMeta[$name]['queryOrder']) {
            $queryOrder = ', ' . $groupMeta[$name]['queryOrder'];
        }

        $q = (isset($_GET['q'])) ? filterString($_GET['q']) : null;

        if ($q === 'price_down') {
            $queryOrder = '
                ,   price_adv_discount DESC';
        } else if ($q === 'price_up') {
            $queryOrder = '
                ,   price_adv_discount ASC';
        } else if ($q === 'discount_down') {
            $queryOrder = '
                ,   price_adv_discount_percent DESC';
        } else if ($q === 'discount_up') {
            $queryOrder = '
                ,   price_adv_discount_percent ASC';
        } else if ($q === 'new_down') {
            $queryOrder = '
                ,   created_at DESC';
        } else if ($q === 'new_up') {
            $queryOrder = '
                ,   created_at ASC';
        } else if ($q === 'year_up') {
            $queryOrder = '
                ,   year ASC
                ,   price_adv_discount DESC';
        } else if ($q === 'year_down') {
            $queryOrder = '
                ,   year DESC
                ,   price_adv_discount DESC';
        } else if ($q === 'age_up') {
            $queryOrder = '
                ,   age ASC
                ,   price_adv_discount DESC';
        } else if ($q === 'age_down') {
            $queryOrder = '
                ,   age DESC
                ,   price_adv_discount DESC';
        } else if ($q === 'popular_up') {
            $queryOrder = '
                ,   counter ASC
                ,   price_adv_discount DESC';
        } else if ($q === 'popular_down') {
            $queryOrder = '
                ,   counter DESC
                ,   price_adv_discount DESC';
        } else if ($q === 'parts_up') {
            $queryOrder = '
                ,   parts ASC
                ,   price_adv_discount DESC';
        } else if ($q === 'parts_down') {
            $queryOrder = '
                ,   parts DESC
                ,   price_adv_discount DESC';
        }

        // все неактивные товары переносим в конец списка (amount_active = 0 ASC)
        return '                
                amount_active = 0 ASC
            ,   price_adv_discount = 0 ASC '
            . $queryOrder . '
            ,   price_adv_discount_sum DESC
            ,   tag_hit DESC
            ,   tag_new DESC';
    }

    /**
     * Сортировка в каталоге
     */
    public static function sortOnPage(): array
    {
        $var = [];

        $var['searchQuery'] = (isset($_GET['s'])) ? filterString($_GET['s']) : null;
        $var['sortQuery'] = (isset($_GET['q'])) ? filterString($_GET['q']) : null;

        // Поля для поиска
        $var['searchFields'] = [
            ['query' => 'price', 'name' => 'цене',],
            ['query' => 'new', 'name' => 'новизне',],
            ['query' => 'year', 'name' => 'году выпуска',],
            ['query' => 'discount', 'name' => 'скидке',],
            ['query' => 'popular', 'name' => 'популярности',],
            ['query' => 'parts', 'name' => 'деталям',],
            ['query' => 'age', 'name' => 'возрасту',],
        ];

        // Переменные для поиска
        $countSearchFields = count($var['searchFields']);
        for ($i = 0; $i < $countSearchFields; $i++) {
            // Заполняем data-query значениями (ex.: price_down)
            $var['query_' . $var['searchFields'][$i]['query']] = $var['searchFields'][$i]['query'] . '_down';
            // Иконка у текста (по умолчанию ее нет)
            $var['arrow_' . $var['searchFields'][$i]['query']] = null;
        }

        // Идет сортировка
        if ($var['sortQuery']) {
            $pos = strpos($var['sortQuery'], '_up');
            if ($pos !== false) { // если совпадение найдено
                $query_str = str_replace('_up', '', $var['sortQuery']);
                ${'query_' . $query_str} = $query_str . '_down';
                ${'arrow_' . $query_str} = '<i class="fas fa-sort-amount-down-alt"></i>';
            } else {
                $query_str = str_replace('_down', '', $var['sortQuery']);
                ${'query_' . $query_str} = $query_str . '_up';
                ${'arrow_' . $query_str} = '<i class="fas fa-sort-amount-down"></i>';
            }

            $var['query_' . $query_str] = ${'query_' . $query_str};
            $var['arrow_' . $query_str] = ${'arrow_' . $query_str};
        }

        return $var;
    }

}