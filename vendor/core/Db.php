<?php

namespace vendor\core;

use R;

class Db
{

    use TSingleton;

    protected function __construct()
    {
        $db = require ROOT . '/config/db.php';
        require LIBS . '/rb.php';

        R::setup($db['dsn'], $db['user'], $db['pass']);
        R::freeze(true);

        if (DB_DEBUG == 1) {
            R::fancyDebug(true);
        }

    }

}
