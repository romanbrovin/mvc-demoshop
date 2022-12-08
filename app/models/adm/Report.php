<?php

namespace app\models\adm;

use R;

class Report extends App
{

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'amount' => ['type' => 'int', 'lenght' => 6],
        'comment' => ['type' => 'string', 'lenght' => 90],
        's_date_from' => ['type' => 'string'],
        's_date_to' => ['type' => 'string'],
        's_type' => ['type' => 'string'],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_date_from'])) {
            $query[] = "created_at >= '{$this->vars['s_date_from']}'";
        }

        if (notArray($this->vars['s_date_to'])) {
            $query[] = "created_at <= '{$this->vars['s_date_to']}' + INTERVAL 1 DAY";
        }

        if (notArray($this->vars['s_type'])) {
            $query[] = "tbl_name = '{$this->vars['s_type']}'";
        }

        if (notArray($this->vars['s_text'])) {
            $query[] = "
                (   
                        tbl_id LIKE '%{$this->vars['s_text']}%'
                    OR  tbl_id IN
                        (
                            SELECT order_id
                            FROM m_basket
                            WHERE product_id =
                                (
                                    SELECT id
                                    FROM m_product
                                    WHERE 
                                            article LIKE '%{$this->vars['s_text']}%'
                                        OR  name LIKE '%{$this->vars['s_text']}%'
                                    LIMIT 1
                                )
                        )                                        
                )";
        }

        if (!isset($query)) {
            $dateFrom = date('Y-m-01');
            $dateTo = date('Y-m-d');

            $query = "id > 0 AND created_at >= '$dateFrom' AND created_at < '$dateTo' + INTERVAL 1 DAY";
        } else {
            $query = implode(' AND ', $query);
        }

        return $query;
    }

    public static function add(string $tbl_name, int $tbl_id, int $amount)
    {
        $obj = R::dispense('m_report');
        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['tbl_name'] = $tbl_name;
        $obj['tbl_id'] = $tbl_id;
        $obj['amount'] = $amount;
        $obj['comment_admin'] = '';
        R::store($obj);
    }

    public static function delete(string $tbl_name, int $tbl_id)
    {
        R::exec("DELETE FROM m_report WHERE tbl_name = '$tbl_name' AND tbl_id = $tbl_id");
    }

    public function balance(): string
    {
        $query = "
            SELECT 
                    (
                        SELECT SUM(amount)
                        FROM m_report
                        WHERE tbl_name = 'order' AND {$this->getQueryWhere()}
                    ) as amount_order
                ,   (
                        SELECT SUM(amount)
                        FROM m_report
                        WHERE tbl_name = 'costs' AND {$this->getQueryWhere()}
                    ) as amount_costs
                ,   (
                        SELECT SUM(amount)
                        FROM m_report
                        WHERE tbl_name = 'storage' AND {$this->getQueryWhere()}
                    ) as amount_storage
            FROM m_report";

        $report = R::getRow($query);

        $total = $report['amount_order'] - $report['amount_costs'] - $report['amount_storage'];

        if ($total >= 0) {
            $class = 'text-success';
        } else {
            $class = 'text-danger';
        }

        return 'Сальдо за период: <span class="' . $class . '">' . rank($total) . ' ₽</span>';
    }

}