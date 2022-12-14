<?php

namespace vendor\core;

class Registry
{

    use TSingleton;

    public static array $objects;

    protected function __construct()
    {
        $config = require_once ROOT . '/config/registry.php';
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component;
        }
    }

    public function __get($name)
    {
        if (is_object(self::$objects[$name])) {
            return self::$objects[$name];
        }
    }

    public function __set($name, $object)
    {
        if (!isset(self::$objects['name'])) {
            self::$objects['name'] = new $object;
        }
    }

}