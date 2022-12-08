<?php

namespace vendor\core\base;

use R;
use vendor\core\Db;

abstract class Model
{

    protected Db $pdo;
    public array $errors = [];
    public array $vars = [];
    public array $requiredVars = [];
    public array $positiveNumbers = [];

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    public function loadVars($data)
    {
        foreach ($this->vars as $name => $value) {
            if (isset($data[$name])) {
                // вызов функции очистки переменной
                $funcName = 'filter' . ucfirst($value['type']);
                $this->vars[$name] = $funcName($data[$name]);

                // обрезаем переменную по заданной длине
                if (isset($value['lenght'])) {
                    $type = gettype($this->vars[$name]); // тип переменной

                    if ($type == 'integer') {
                        $this->vars[$name] = (int)mb_substr($this->vars[$name], 0, $value['lenght']);
                    } else if ($type == 'double') {
                        $this->vars[$name] = (float)mb_substr($this->vars[$name], 0, $value['lenght']);
                    } else {
                        $this->vars[$name] = mb_substr($this->vars[$name], 0, $value['lenght']);
                    }
                }
            }
        }
    }

    public function validateRequiredVars(): bool
    {
        foreach ($this->requiredVars as $name) {
            $type = gettype($this->vars[$name]);

            if ($name == 'captcha') {
                if ($this->vars['captcha'] != $_SESSION['captcha']) {
                    $this->errors[] = 'captcha';
                }
            } else if ($name == 'phone') {
                if (strlen($this->vars['phone']) < 10) {
                    $this->errors[] = 'phone';
                }
            } else if ($type == 'integer' || $type == 'double') {
                if ($this->vars[$name] < 0) {
                    $this->errors[] = $name;
                }
            } else if ($this->vars[$name] == '' || is_array($this->vars[$name])) {
                $this->errors[] = $name;
            }
        }

        if ($this->errors)
            return false;

        return true;
    }

    public function validatePositiveNumbers(): bool
    {
        foreach ($this->positiveNumbers as $name) {
            if ($this->vars[$name] <= 0) {
                $this->errors[] = $name;
            }
        }

        if ($this->errors)
            return false;

        return true;
    }

    public function validateAjaxAndToken()
    {
        if (!isAjax() || !isToken()) {
            include WWW . '/404.php';
            exit;
        }
    }

}

