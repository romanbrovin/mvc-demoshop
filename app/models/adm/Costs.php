<?php

namespace app\models\adm;

use R;

class Costs extends App
{

    private string $table = 'm_costs';

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'date' => ['type' => 'string'],
        'cost_category_id' => ['type' => 'int', 'lenght' => 9],
        'amount' => ['type' => 'int', 'lenght' => 6],
        'comment' => ['type' => 'string', 'lenght' => 90],
        's_date_from' => ['type' => 'string'],
        's_date_to' => ['type' => 'string'],
        's_cost_category_id' => ['type' => 'int', 'lenght' => 9],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_date_from'])) {
            $query[] = "created_at >= '{$this->vars['s_date_from']}'";
        }

        if (notArray($this->vars['s_date_to'])) {
            $query[] = "created_at <= '{$this->vars['s_date_to']}'  + INTERVAL 1 DAY";
        }

        if (notArray($this->vars['s_cost_category_id'])) {
            $query[] = "cost_category_id = {$this->vars['s_cost_category_id']}";
        }

        if (notArray($this->vars['s_text'])) {
            $query[] = "amount LIKE '%{$this->vars['s_text']}%'";
        }

        if (!isset($query)) {
            $query = "id > 0";
        } else {
            $query = implode(' AND ', $query);
        }


        return $query;
    }

    public function create()
    {
        $obj = R::dispense($this->table);

        if (!issetVal($this->vars['date'])) {
            $this->vars['date'] = date('Y-m-d H:i:s');
        }

        $obj['created_at'] = $this->vars['date'];
        $obj['updated_at'] = $this->vars['date'];
        $obj['cost_category_id'] = $this->vars['cost_category_id'];
        $obj['amount'] = $this->vars['amount'];
        $obj['comment_admin'] = '';
        R::store($obj);

        $costsId = R::getInsertID();

        Report::add( 'costs', $costsId, $this->vars['amount']);
    }

    public function save()
    {
        $obj = R::load($this->table, $this->vars['id']);

        if (!issetVal($this->vars['date'])) {
            $this->vars['date'] = date('Y-m-d H:i:s');
        }

        $obj['created_at'] = $this->vars['date'];
        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['cost_category_id'] = $this->vars['cost_category_id'];
        $obj['amount'] = $this->vars['amount'];

        R::store($obj);
    }

    public function balance(): string
    {
        $query = "
            SELECT SUM(amount)
            FROM $this->table
            WHERE {$this->getQueryWhere()}";

        return 'Сальдо за период: ' . rank(R::getCell($query)) . ' ₽';
    }

}