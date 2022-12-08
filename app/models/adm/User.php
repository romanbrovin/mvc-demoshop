<?php

namespace app\models\adm;

use R;

class User extends App
{

    private string $table = 'm_user';

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'name' => ['type' => 'string', 'lenght' => 150],
        'surname' => ['type' => 'string', 'lenght' => 150],
        'email' => ['type' => 'email', 'lenght' => 150],
        'password' => ['type' => 'string', 'lenght' => 255],
        'phone' => ['type' => 'string', 'lenght' => 20],
        'bonus' => ['type' => 'int', 'lenght' => 9],
        'comment' => ['type' => 'string', 'lenght' => 90],
        's_user_id' => ['type' => 'int', 'lenght' => 9],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_user_id'])) {
            $query = "
                uid IN
                    (
                        SELECT uid
                        FROM m_user
                        WHERE 
                                id = {$this->vars['s_user_id']}
                            AND role = 'user'
                    )";
        }

        if (notArray($this->vars['s_text'])) {
            $query = "
                    role = 'user'
                AND (
                            id LIKE '%{$this->vars['s_text']}%'
                        OR  name LIKE '%{$this->vars['s_text']}%'
                        OR  surname LIKE '%{$this->vars['s_text']}%'
                        OR  email LIKE '%{$this->vars['s_text']}%'
                        OR  phone LIKE '%{$this->vars['s_text']}%'
                    )";
        }

        if (!isset($query)) {
            $query = "id > 0 AND role = 'user'";
        }

        return $query;
    }

    private function prepare(): array
    {
        $var['name'] = $this->vars['name'];
        $var['surname'] = $this->vars['surname'];
        $var['email'] = $this->vars['email'];
        $var['phone'] = $this->vars['phone'];
        $var['bonus'] = $this->vars['bonus'];
        $var['comment_admin'] = $this->vars['comment'];

        return $var;
    }

    public function create()
    {
        $uid = hash('md5', time() + rand());

        if (is_array($this->vars['email'])) {
            $this->vars['email'] = time() . '@fake.ru';
        }

        if (is_array($this->vars['surname'])) {
            $this->vars['surname'] = 'Клиент';
        }

        if (is_array($this->vars['name'])) {
            $this->vars['name'] = 'Новый';
        }

        $code = codeGeneric(6, 1, 0, 0);
        $password = password_hash($code, PASSWORD_DEFAULT);

        $var = $this->prepare();

        $obj = R::dispense($this->table);

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['uid'] = $uid;
        $obj['password'] = $password;
        $obj['bonus'] = 0;

        R::store($obj);
    }

    public function save()
    {
        $var = $this->prepare();

        $obj = R::load($this->table, $this->vars['id']);

        $obj['updated_at'] = date('Y-m-d H:i:s');

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        if ($this->vars['password'] != '') {
            $obj['password'] = password_hash($this->vars['password'], PASSWORD_DEFAULT);
        }

        R::store($obj);
    }

    public function checkUniqueEmail(): bool
    {
        $query = "email = ?";
        $user = R::findOne($this->table, $query, [
            $this->vars['email'],
        ]);

        if ($user) {
            $this->errors[] = 'non-unique-email';

            return false;
        }

        return true;
    }

    public function checkExistEmail(): bool
    {
        $query = "email = ? AND id != ?";
        $user = R::findOne($this->table, $query, [
            $this->vars['email'],
            $this->vars['id'],
        ]);

        if ($user) {
            $this->errors[] = 'non-unique-email';

            return false;
        }

        return true;
    }

}