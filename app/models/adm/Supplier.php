<?php

namespace app\models\adm;

use R;

class Supplier extends App
{

    private string $table = 'm_supplier';

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'name' => ['type' => 'string', 'lenght' => 150],
        'comment' => ['type' => 'string', 'lenght' => 90],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_text'])) {
            $query[] = "name LIKE '%{$this->vars['s_text']}%'";
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
        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['name'] = $this->vars['name'];
        $obj['comment_admin'] = '';

        R::store($obj);
    }

    public function save()
    {
        $obj = R::load($this->table, $this->vars['id']);
        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['name'] = $this->vars['name'];

        R::store($obj);
    }

}