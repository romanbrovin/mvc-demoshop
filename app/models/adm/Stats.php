<?php

namespace app\models\adm;

use R;

class Stats extends App
{

    public array $vars = [
        's_no_sales' => ['type' => 'int', 'lenght' => 1],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_no_sales'])) {
            $query = "amount_sells = 0";
        }

        if (!isset($query)) {
            $query = "id > 0";
        }

        return $query;
    }

    public static function reload()
    {
        R::wipe('m_stats');

        $productList = R::findAll('m_product');

        foreach ($productList as $product) {
            $countSells = 0;
            $totalCosts = 0;

            $basketList = R::findAll('m_basket', "product_id = '{$product['id']}'");

            foreach ($basketList as $basket) {
                $order = R::load('m_order', $basket['order_id']);
                if ($order['current_status'] == 'delivered' || $order['current_status'] == 'written_off') {
                    $countSells += $basket['amount'];
                }
            }

            if ($product['amount'] > 0) {
                $query = "
                    SELECT SUM(amount*price) as total_costs
                    FROM m_storage
                    WHERE product_id = {$product['id']}";

                $totalCosts = R::getCell($query);
            }


            $obj = R::dispense('m_stats');
            $obj['product_id'] = $product['id'];
            $obj['amount_sells'] = $countSells;
            $obj['amount_storage'] = $product['amount'];
            $obj['total_costs'] = $totalCosts;

            R::store($obj);
        }
    }

    public function getTotal(): array
    {
        $statsList = R::findAll('m_stats', self::getQueryWhere());

        $balance = [
            'amount' => 0,
            'costs' => 0,
        ];

        foreach ($statsList as $stats) {
            $balance['amount'] += $stats['amount_storage'];
            $balance['costs'] += $stats['total_costs'];
        }

        return $balance;
    }

}