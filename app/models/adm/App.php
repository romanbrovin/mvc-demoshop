<?php

namespace app\models\adm;

use R;

class App extends \app\models\App
{

    public function getList($params): array
    {
        $orderBy = $this->vars['s_order'];

        if (!is_array($orderBy) && $orderBy) {
            $orderBy = str_replace('_asc', ' ASC', $orderBy);
            $orderBy = str_replace('_desc', ' DESC', $orderBy);
        } else {
            $orderBy = 'id DESC';
        }

        $query = "
            SELECT *
            FROM {$params['table']}
            WHERE {$params['where']}
            ORDER BY $orderBy
            LIMIT {$params['limit']}, {$params['page']}";


        return R::getAll($query);
    }

    private function getVars(): array
    {
        // Переменные сортировки
        $arr = [
            's_order_id', 's_product_id', 's_category_id', 's_user_id', 's_status',
            's_soon', 's_select', 's_tag', 's_hidden', 's_payment', 's_marketplace',
            's_date_from', 's_date_to', 's_text', 's_order', 's_amount', 's_type',
            's_cost_category_id', 's_warehouse_id','s_supplier_id', 's_no_sales'
        ];

        $var = [];

        foreach ($arr as $name) {
            $var[$name] = '';

            if (isset($this->vars[$name])) {
                if (!is_array($this->vars[$name])) {
                    $var[$name] = $this->vars[$name];
                }
            }
        }

        return $var;
    }

    public function sortOnPage($fields): array
    {
        $var = self::getVars();

        // Переменные для поиска
        foreach ($fields as $name => $value) {
            $var['fields'][$name] = $value;
            // Заполняем data-query значениями (пример: price_desc)
            $var['query_' . $name] = $name . '_desc';
            // Иконка у текста (по умолчанию ее нет)
            $var['arrow_' . $name] = null;
        }

        // Идет сортировка
        if ($var['s_order']) {
            $pos = strpos($var['s_order'], '_asc');
            if ($pos !== false) { // если совпадение найдено
                $name = str_replace('_asc', '', $var['s_order']);
                $var['query_' . $name] = $name . '_desc';
                $var['arrow_' . $name] = '<i class="fas fa-sort-amount-down-alt"></i>';
            } else {
                $name = str_replace('_desc', '', $var['s_order']);
                $var['query_' . $name] = $name . '_asc';
                $var['arrow_' . $name] = '<i class="fas fa-sort-amount-down"></i>';
            }
        }

        return $var;
    }

    public function setToogle($table, $field)
    {
        $obj = R::load($table, $this->vars['id']);
        $obj[$field] = ($obj[$field] == 0) ? 1 : 0;
        R::store($obj);
    }

    public function setComment($table)
    {
        $obj = R::load($table, $this->vars['id']);
        $obj['comment_admin'] = $this->vars['comment'];
        R::store($obj);
    }

    public function simpleDelete($table)
    {
        R::trash(R::load($table, $this->vars['id']));
    }

    public function setSortOrder($table)
    {
        $obj = R::load($table, $this->vars['id']);
        $obj['sort_order'] = $this->vars['sort'];
        R::store($obj);
    }

    public static function renderCounter($table, $field, $value, $color = 'secondary'): string
    {
        $count = R::count($table, "$field = ?", [$value]);
        if ($count > 0) {
            return '<div class="counter counter_' . $color . '">' . $count . '</div>';
        }

        return '';
    }

}