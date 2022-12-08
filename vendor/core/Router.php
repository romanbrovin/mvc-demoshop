<?php

namespace vendor\core;

class Router
{

    protected static array $route;  // текущий маршрут
    protected static array $routes; // таблица маршрутов

    /**
     * добавляет маршрут в таблицу
     *
     * @param string $regexp регулярное выражение маршрута
     * @param array  $route маршрут [controller, action, params]
     */
    public static function add(string $regexp, array $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * перенаправляет URL по корректному маршруру
     */
    public static function dispatch(string $url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';

                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                    $cObj->getView();
                } else {
                    include WWW . '/404.php';
                }
            } else {
                include WWW . '/404.php';
            }
        } else {
            include WWW . '/404.php';
        }
    }

    /**
     * ищет URL в таблице маршрутов
     */
    protected static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("~$pattern~i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                // prefix for admin controllers
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;

                return true;
            }
        }

        return false;
    }

    /**
     * преобразует имена к виду CamelCase
     */
    protected static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * преобразует имена к виду camelCase
     */
    protected static function lowerCamelCase(string $name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * возвращает строку без GET параметров
     */
    protected static function removeQueryString(string $url)
    {
        if ($url) {
            $params = explode('?', $url);

            if (false == strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }

        return false;
    }

}
