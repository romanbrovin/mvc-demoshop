<?php

namespace app\models\adm;

use R;

class Paykeeper extends App
{

    private string $table = 'm_paykeeper';

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        's_date_from' => ['type' => 'string'],
        's_date_to' => ['type' => 'string'],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_date_from'])) {
            $query[] = "created_at >= '{$this->vars['s_date_from']}'";
        }

        if (notArray($this->vars['s_date_to'])) {
            $query[] = "created_at <= '{$this->vars['s_date_to']}'";
        }

        if (notArray($this->vars['s_text'])) {
            $query[] = "
                (   
                        order_id LIKE '%{$this->vars['s_text']}%'
                    OR  operation_id LIKE '%{$this->vars['s_text']}%'
                    OR  sender LIKE '%{$this->vars['s_text']}%'
                    OR  order_id IN
                        (
                            SELECT order_id
                            FROM m_basket
                            WHERE product_id =
                                (
                                    SELECT id
                                    FROM m_product
                                    WHERE article LIKE '%{$this->vars['s_text']}%'
                                    LIMIT 1
                                ) 
                        )                                        
                )";
        }

        if (!isset($query)) {
            $query = "id > 0";
        } else {
            $query = implode(' AND ', $query);
        }

        return $query;
    }

    public function balance(): string
    {
        $query = "
            SELECT SUM(sum)
            FROM $this->table
            WHERE {$this->getQueryWhere()}";

        return 'Сальдо за период: ' . rank(R::getCell($query)) . ' ₽';
    }

}