<?php

namespace app\models;

use R;
use vendor\core\base\Model;

class User extends Model
{

    public array $vars = [
        'surname' => ['type' => 'string', 'lenght' => 150],
        'name' => ['type' => 'string', 'lenght' => 150],
        'email' => ['type' => 'email', 'lenght' => 150],
        'phone' => ['type' => 'string', 'lenght' => 20],
        'password' => ['type' => 'string', 'lenght' => 255],
        'password_new' => ['type' => 'string', 'lenght' => 255],
        'captcha' => ['type' => 'int', 'lenght' => 6],
        'legal' => ['type' => 'int', 'lenght' => 1],
    ];

    public array $requiredVars = [];

    public function create(): string
    {
        $uid = md5(time() + rand());

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

        $query = "
            INSERT INTO m_user
            SET
                    created_at = NOW()
                ,   updated_at = NOW()
                ,   uid = '$uid'
                ,   surname = ?
                ,   name = ?
                ,   email = ?
                ,   password = '$password'";

        R::exec($query, [
            $this->vars['surname'],
            $this->vars['name'],
            $this->vars['email'],
        ]);

        return $uid;
    }

    public function update()
    {
        $arrReplace = ['-', '(', ')', ' ', '+'];
        $this->vars['phone'] = str_replace($arrReplace, '', $this->vars['phone']);

        $query = "
            UPDATE m_user
            SET
                    updated_at = NOW()
                ,   surname = ?
                ,   name = ?
                ,   phone = ?
            WHERE uid = '{$_SESSION['user']['uid']}'";

        R::exec($query, [
            $this->vars['surname'],
            $this->vars['name'],
            $this->vars['phone'],
        ]);

        $_SESSION['user']['surname'] = $this->vars['surname'];
        $_SESSION['user']['name'] = $this->vars['name'];
        $_SESSION['user']['phone'] = $this->vars['phone'];
    }

    public function signup()
    {
        if (is_array($this->vars['password'])) {
            $code = codeGeneric(6, 1, 0, 0);
            $this->vars['password'] = password_hash($code, PASSWORD_DEFAULT);
            $password = $code;
        } else {
            $password = $this->vars['password'];
            $this->vars['password'] = password_hash($this->vars['password'], PASSWORD_DEFAULT);
        }

        $arrReplace = ['-', '(', ')', ' ', '+'];
        $this->vars['phone'] = str_replace($arrReplace, '', $this->vars['phone']);


        $query = "
            INSERT INTO m_user
            SET
                    created_at = NOW()
                ,   updated_at = NOW()
                ,   uid = '{$_SESSION['uid']}'
                ,   surname = ?
                ,   name = ?
                ,   email = ?
                ,   password = ?
                ,   phone = ?
                ,   ip = '{$_SESSION['ip']}'
                ,   ua = '{$_SESSION['ua']}'";

        R::exec($query, [
            $this->vars['surname'],
            $this->vars['name'],
            $this->vars['email'],
            $this->vars['password'],
            $this->vars['phone'],
        ]);

        // Письмо клиенту
        $mail = new Mail();
        $mail->toEmail = $this->vars['email'];
        $mail->subject = "Аккаунт зарегистрирован";
        $mail->body = "<h1>{$this->vars['name']}, вы зарегистрированы!</h1>
            <h2>Пароль от входа в личный кабинет: $password</h2>";
        $mail->send();
    }

    public function recovery()
    {
        $code = codeGeneric(6, 1, 0, 0);
        $password = password_hash($code, PASSWORD_DEFAULT);

        $query = "
            UPDATE m_user
            SET
                    updated_at = NOW()
                ,   password = '$password'
                ,   comment_admin = '$code'
            WHERE email = ? ";

        R::exec($query, [$this->vars['email']]);

        // Письмо клиенту
        $mail = new Mail();
        $mail->toEmail = $this->vars['email'];
        $mail->subject = "Восстановление пароля";
        $mail->body = "<h1>Новый пароль: $code</h1>
            <h2>Не забудьте изменить пароль в личном кабинете!</h2>";
        $mail->send();
    }

    public function login()
    {
        $user = R::findOne('m_user', 'email = ?', [$this->vars['email']]);

        foreach ($user as $key => $value) {
            if ($key != 'password') {
                $_SESSION['user'][$key] = $value;
            }
        }

        $query = "
            UPDATE m_basket
            SET
                    updated_at = NOW()
                ,   uid = '{$_SESSION['user']['uid']}'
                ,   role = '{$_SESSION['user']['role']}'
            WHERE uid = '{$_SESSION['uid']}'";

        R::exec($query);

        // Авторизация клиента в процессе оформления заказа
        if (isset($_COOKIE['orderId'])) {
            $query = "
                UPDATE m_order
                SET
                        updated_at = NOW()
                    ,   uid = '{$_SESSION['user']['uid']}'
                    ,   role = 'user'
                WHERE id = ?";

            R::exec($query, [$_COOKIE['orderId']]);
        }

        $_SESSION['uid'] = $user['uid'];

        $query = "
            UPDATE m_user
            SET 
                    counter = counter + 1
                ,   ip = '{$_SESSION['ip']}'
                ,   ua = '{$_SESSION['ua']}'
            WHERE uid = '{$_SESSION['uid']}'";

        R::exec($query);
    }

    public function verifyPassword(): bool
    {
        $user = R::findOne('m_user', 'uid = ?', [$_SESSION['user']['uid']]);

        if (!password_verify($this->vars['password'], $user->password)) {
            $this->errors[] = 'password';

            return false;
        }

        return true;
    }

    public function checkExistEmail(): bool
    {
        $user = R::findOne('m_user', 'email = ?', [$this->vars['email']]);

        if (!$user) {
            $this->errors[] = 'non-exist';

            return false;
        }

        return true;
    }

    public function checkUniqueEmail(): bool
    {
        $user = R::findOne('m_user', 'email = ?', [$this->vars['email']]);

        if ($user) {
            $this->errors[] = 'non-unique';

            return false;
        }

        return true;
    }

    public function checkEmailAndPassword(): bool
    {
        $user = R::findOne('m_user', 'email = ?', [$this->vars['email']]);

        if (!$user) {
            $this->errors[] = 'auth';

            return false;
        }

        if (!password_verify($this->vars['password'], $user->password)) {
            $this->errors[] = 'auth';

            return false;
        }

        return true;
    }

    public function setNewPassword()
    {
        $this->vars['password_new'] = password_hash($this->vars['password_new'], PASSWORD_DEFAULT);

        $query = "
            UPDATE m_user
            SET
                    updated_at = NOW()
                ,   password = ?
            WHERE uid = '{$_SESSION['user']['uid']}'";

        R::exec($query, [$this->vars['password_new']]);
    }

}