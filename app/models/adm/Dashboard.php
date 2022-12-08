<?php

namespace app\models\adm;

use app\models\Calculation;
use R;

class Dashboard extends App
{

    public array $vars = [
        'feed' => ['type' => 'string'],
    ];

    public static function setSync()
    {
        Calculation::calc();
    }

    public function setFeed()
    {
        $query = "
            UPDATE m_const
            SET
                    updated_at = NOW()
                ,   value = IF(value = 0, 1, 0)
            WHERE name = ?";

        R::exec($query, [$this->vars['feed']]);
    }

}