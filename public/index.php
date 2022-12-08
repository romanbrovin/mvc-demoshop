<?php

use vendor\core\Router;

$query = trim($_SERVER['REQUEST_URI'], '/');

define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('WWW', dirname(__DIR__) . '/public');
define('CORE', dirname(__DIR__) . '/vendor/core');
define('LIBS', dirname(__DIR__) . '/vendor/libs');
define('CACHE', dirname(__DIR__) . '/tmp/cache');
define('ADM', dirname(__DIR__) . '/app/views/adm');

const LAYOUT = 'default'; // основной шаблон
const COMPRESS_PAGE = 0; // сжатие html кода 1-да 0-нет
const DB_DEBUG = 0; // режим дебага базы данных
const DB_LOCAL = 0; // база данных 1-локальная 0-серверная

require ROOT . '/config/site_meta.php';
require LIBS . '/functions.php';

session_start();

$_SESSION['ip'] = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];
$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];


if (!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = hash('md5', time() + rand());
}


spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

new \vendor\core\App();


// Статическая страница
Router::add('^delivery$', ['controller' => 'Page', 'action' => 'delivery']);
Router::add('^legal$', ['controller' => 'Page', 'action' => 'legal']);
Router::add('^contacts', ['controller' => 'Page', 'action' => 'contacts']);
Router::add('^about', ['controller' => 'Page', 'action' => 'about']);

// Пользователь
Router::add('^recovery', ['controller' => 'User', 'action' => 'recovery']);
Router::add('^signup', ['controller' => 'User', 'action' => 'signup']);
Router::add('^login$', ['controller' => 'User', 'action' => 'login']);
Router::add('^logout', ['controller' => 'User', 'action' => 'logout']);
Router::add('^settings', ['controller' => 'User', 'action' => 'settings']);

// Каталог
Router::add('^search$', ['controller' => 'Catalog', 'action' => 'search']);
Router::add('^catalog$', ['controller' => 'Catalog', 'action' => 'index']);
Router::add('^catalog/(?P<category>[-a-z\d]+)$', ['controller' => 'Catalog', 'action' => 'category']);
Router::add('^group/(?P<group>[-a-z\d]+)$', ['controller' => 'Catalog', 'action' => 'group']);

// Продукт
Router::add('^catalog/(?P<category>[-a-z\d]+)/(?P<article>[-a-z\d]+)$', ['controller' => 'Product', 'action' => 'index']);

// Админка
Router::add('^adm$', ['controller' => 'Dashboard', 'action' => 'index', 'prefix' => 'adm']);
Router::add('^adm/?(?P<controller>[-a-z\d]+)/?(?P<action>[-a-z\d]+)?$', ['prefix' => 'adm']);

// Правила по умолчанию
Router::add('^$', ['controller' => 'Index', 'action' => 'index']);
Router::add('^(?P<controller>[-a-z\d]+)/?(?P<action>[-a-z\d]+)?$');

// Запуск
Router::dispatch($query);
