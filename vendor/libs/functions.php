<?php

function debug($val)
{
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}

function issetVal($val): bool
{
    if (isset($val) && $val) {
        return true;
    }

    return false;
}

function notArray($val): bool
{
    if (!is_array($val) && $val) {
        return true;
    }

    return false;
}

function dateModifyInArray($array)
{
    foreach ($array as $key => $value) {
        if (strpos($key, '_at') !== false) {
            $array[$key] = date_format(date_create($value), 'd.m.Y H:i');
        } else {
            $array[$key] = $value;
        }
    }

    return $array;
}

function dateModify($value)
{
    return date_format(date_create($value), 'd.m.Y H:i');
}

function getDeliveryServiceUrl($deliveryService): string
{
    $url = '';
    if ($deliveryService == 'СДЭК') {
        $url = 'https://cdek.ru/tracking?order_id=';
    } else if ($deliveryService == 'Boxberry') {
        $url = 'https://boxberry.ru/tracking-page?id=';
    } else if ($deliveryService == 'Почта России') {
        $url = 'https://www.pochta.ru/tracking#';
    }

    return $url;
}


// Добавление в массив данных товара путь до аватарки + альт-описание
function addAvatar($var)
{
    $var['photo'] = explode(';', $var['photo']);
    $pathToAvatar = "/uploads/goods/{$var['category_url']}/{$var['article']}/thumb-{$var['photo'][0]}";
    $var['avatar'] = isImageExist($pathToAvatar);
    $var['alt'] = "{$var['category_name']} {$var['article']} {$var['name']}";

    return $var;
}


function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
    }

    header("Location: $redirect");
    exit;
}


function isAuth(): bool
{
    return isset($_SESSION['user']);
}

function isAdmin(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin';
}


function isAjax(): bool
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}


function isToken(): bool
{
    if (isset($_POST['token2']) && $_POST['token2'] == $_SESSION['token1']) {
        return true;
    }

    return false;
}

function filterString($var): string
{
    return htmlspecialchars(trim($var), ENT_QUOTES);
}

function filterEmail($var): string
{
    return filter_var(trim($var), FILTER_VALIDATE_EMAIL);
}

function filterUrl($var): string
{
    return filter_var(trim($var), FILTER_VALIDATE_URL);
}

function filterInt($var)
{
    return filter_var(trim($var), FILTER_VALIDATE_INT);
}

function filterFloat($var)
{
    return filter_var(trim($var), FILTER_VALIDATE_FLOAT);
}


/**
 * Процент от числа
 */
function calcPercent($number, $percent): float
{
    return round($number * ($percent / 100));
}

function sign($number): int
{
    return ($number > 0) ? 1 : (($number < 0) ? -1 : 0);
}

/**
 * Разбивка числа на разряды
 * 4 знака - 9000
 * 5 и более знаков - 19 900
 */
function rank($number): string
{
    $sing = sign($number);
    $number = abs($number);

    $number = (int)$number;
    if (strlen($number) > 4 && $number > 0) {
        $number = number_format($number, 0, ' ', ' ');
    }

    if ($sing == -1) {
        $number = '-' . $number;
    }

    return $number;
}


function copyDirectory($src, $dest)
{
    $dir = opendir($src);

    if (!is_dir($dest)) {
        mkdir($dest, 0777, true);
    }

    while (false !== ($file = readdir($dir))) {
        if ($file != '.' && $file != '..') {
            if (is_dir($src . '/' . $file)) {
                copyDirectory($src . '/' . $file, $dest . '/' . $file);
            } else {
                copy($src . '/' . $file, $dest . '/' . $file);
            }
        }
    }

    closedir($dir);
}


/**
 * Удаление папки вместе с файлами
 */
function deleteDirectory($name): bool
{
    $files = array_diff(scandir($name), ['.', '..']);
    foreach ($files as $file) {
        if (is_dir("$name/$file")) {
            deleteDirectory("$name/$file");
        } else {
            unlink("$name/$file");
        }
    }

    return rmdir($name);
}

/**
 * Транслитерация строки
 */
function translit($value): string
{
    $value = mb_strtolower($value);
    $replace = [
        'а' => 'a', 'б' => 'b', 'в' => 'v',
        'г' => 'g', 'д' => 'd', 'е' => 'e',
        'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
        'и' => 'i', 'й' => 'j', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r',
        'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shh',
        'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        ' ' => '-', '.' => '-', ',' => '-',
        '\'' => '-', '’' => '-', '?' => '-',
        '"' => '-', '«' => '-', '»' => '-',
        '!' => '-', '@' => '-', '#' => '-',
        '$' => '-', '%' => '-', '^' => '-',
        '&' => '-', '*' => '-', '(' => '-',
        ')' => '-', '=' => '-', '+' => '-',
        '_' => '-', '/' => '-', '<' => '-',
        '>' => '-', '`' => '-', '~' => '-',
        ':' => '-', ';' => '-', '§' => '-',
        '±' => '-',
    ];

    return strtr($value, $replace);
}


/**
 * Выводим заглушку при отсутствии заданного изображения
 *
 * @param $path
 *
 * @return string
 */
function isImageExist($path): string
{
    if (!file_exists(WWW . $path)) {
        return '/images/no_image.jpg';
    }

    return $path;
}

function isImageAvatar($path, $image): bool
{
    if (!file_exists(WWW . $path . 'mini-' . $image)) {
        return true;
    }

    return false;
}


function codeGeneric($_length, $_digital = 1, $_latin_char = 1, $_russian_char = 0)
{
    $dig = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    $lat = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $main = [];
    if ($_digital) {
        $main = array_merge($main, $dig);
    }

    if ($_latin_char) {
        $main = array_merge($main, $lat);
    }

    if ($_russian_char) {
        $main = array_merge($main, $rus);
    }

    shuffle($main);

    return substr(implode('', $main), 0, $_length);
}


/**
 * Получение разрешения файла
 */
function get_ext($key)
{
    $key = strtolower(substr(strrchr($key, "."), 1));

    return str_replace("jpeg", "jpg", $key);
}

/**
 * Изменение размера фотографии
 */
function resize($file_input, $file_output, $w_o, $h_o, $percent = false)
{
    [$w_i, $h_i, $type] = getimagesize($file_input);
    $types = ['', 'gif', 'jpeg', 'png'];
    $ext = $types[$type];
    if ($ext) {
        $func = 'imagecreatefrom' . $ext;
        $img = $func($file_input);
    }
    if ($percent) {
        $w_o *= $w_i / 100;
        $h_o *= $h_i / 100;
    }
    if (!$h_o) {
        $h_o = $w_o / ($w_i / $h_i);
    }

    if (!$w_o) {
        $w_o = $h_o / ($h_i / $w_i);
    }

    $img_o = imagecreatetruecolor($w_o, $h_o);
    imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
    if ($type == 2) {
        return imagejpeg($img_o, $file_output, 100);
    } else {
        $func = 'image' . $ext;

        return $func($img_o, $file_output);
    }
}

