<?php

namespace app\models\adm;

use app\models\Calculation;
use R;

class Storage extends App
{

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'product_id' => ['type' => 'int', 'lenght' => 9],
        'warehouse_id' => ['type' => 'int', 'lenght' => 9],
        'supplier_id' => ['type' => 'int', 'lenght' => 9],
        'price' => ['type' => 'int', 'lenght' => 6],
        'amount' => ['type' => 'int', 'lenght' => 4],
        'rack' => ['type' => 'int', 'lenght' => 4],
        'pallet' => ['type' => 'int', 'lenght' => 4],
        'box' => ['type' => 'int', 'lenght' => 4],
        'comment' => ['type' => 'string', 'lenght' => 90],
        's_warehouse_id' => ['type' => 'int', 'lenght' => 9],
        's_supplier_id' => ['type' => 'int', 'lenght' => 9],
        's_product_id' => ['type' => 'int', 'lenght' => 9],
        's_hidden' => ['type' => 'int', 'lenght' => 1],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_hidden'])) {
            $query[] = "is_hidden = {$this->vars['s_hidden']}";
        }

        if (notArray($this->vars['s_product_id'])) {
            $query[] = "product_id = {$this->vars['s_product_id']}";
        }

        if (notArray($this->vars['s_warehouse_id'])) {
            $query[] = "warehouse_id = {$this->vars['s_warehouse_id']}";
        }

        if (notArray($this->vars['s_supplier_id'])) {
            $query[] = "supplier_id = {$this->vars['s_supplier_id']}";
        }

        if (notArray($this->vars['s_text'])) {
            $query[] = "
                (
                        product_id LIKE '%{$this->vars['s_text']}%'
                    OR  id = '{$this->vars['s_text']}'
                    OR  amount LIKE '%{$this->vars['s_text']}%'
                    OR  price LIKE '%{$this->vars['s_text']}%'
                    OR  comment_admin LIKE '%{$this->vars['s_text']}%'
                    OR  product_id IN
                        (
                            SELECT id
                            FROM m_product
                            WHERE 
                                    article LIKE '%{$this->vars['s_text']}%' 
                                OR  name LIKE '%{$this->vars['s_text']}%'
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

    private function prepare(): array
    {
        $varsZeroIfEmpty = ['rack', 'pallet', 'box'];

        foreach ($varsZeroIfEmpty as $name) {
            if ($this->vars[$name] == '') {
                $this->vars[$name] = 0;
            }
        }

        $var['supplier_id'] = $this->vars['supplier_id'];
        $var['warehouse_id'] = $this->vars['warehouse_id'];
        $var['price'] = $this->vars['price'];
        $var['amount'] = $this->vars['amount'];
        $var['rack'] = $this->vars['rack'];
        $var['pallet'] = $this->vars['pallet'];
        $var['box'] = $this->vars['box'];
        $var['comment_admin'] = $this->vars['comment'];

        return $var;
    }

    public function create()
    {
        $var = $this->prepare();

        $storage = R::dispense('m_storage');
        $storage['created_at'] = date('Y-m-d H:i:s');
        $storage['product_id'] = $this->vars['product_id'];
        $storage['is_hidden'] = 1;

        foreach ($var as $name => $value) {
            $storage[$name] = $value;
        }

        R::store($storage);

        $storageId = R::getInsertID();

        $amount = $storage['price'] * $storage['amount'];

        Report::add( 'storage', $storageId, $amount);

        Calculation::calc($this->vars['product_id']);
    }

    public function save()
    {
        $var = $this->prepare();

        $storage = R::load('m_storage', $this->vars['id']);
        $storage['updated_at'] = date('Y-m-d H:i:s');

        foreach ($var as $name => $value) {
            $storage[$name] = $value;
        }

        R::store($storage);

        Calculation::calc($storage['product_id']);
    }

    public function checkSplitAmount(): bool
    {
        $storageOld = R::load('m_storage', $this->vars['id']);

        if ($this->vars['amount'] >= $storageOld['amount']) {
            $this->errors[] = 'non-check';

            return false;
        }

        return true;
    }

    public function setSplit()
    {
        $storageOld = R::load('m_storage', $this->vars['id']);
        $storageOld['amount'] -= $this->vars['amount'];
        R::store($storageOld);

        $storage = R::dispense('m_storage');
        $storage['created_at'] = date('Y-m-d H:i:s');
        $storage['product_id'] = $storageOld['product_id'];
        $storage['amount'] = $this->vars['amount'];
        $storage['price'] = $storageOld['price'];
        $storage['supplier_id'] = $storageOld['supplier_id'];
        $storage['warehouse_id'] = $storageOld['warehouse_id'];
        $storage['is_hidden'] = 1;
        R::store($storage);

        Calculation::calc($storage['product_id']);
    }

    public function setHidden()
    {
        $query = "
            UPDATE m_storage
            SET
                    updated_at = NOW()
                ,   is_hidden = IF(is_hidden = 0, 1, 0)
            WHERE id = ?";

        R::exec($query, [$this->vars['id']]);

        $storage = R::load('m_storage', $this->vars['id']);

        Calculation::calc($storage['product_id']);
    }

    public function delete()
    {
        $storage = R::load('m_storage', $this->vars['id']);
        R::trash(R::load('m_storage', $this->vars['id']));

        Report::delete( 'storage', $this->vars['id']);

        Calculation::calc($storage['product_id']);
    }

}