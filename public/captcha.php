<?php
session_start();

$cap_width = 70;
$cap_height = 34;
$cap_quality = 100;
$cap_length_min = 6;
$cap_length_max = 6;
$cap_digital = 1;
$cap_latin_char = 0;
$cap_russian_char = 0;

function code_generic($_length, $_digital = 1, $_latin_char = 1, $_russian_char = 0)
{
//    $dig = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    $dig = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    $lat = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $main = [];
    if ($_digital)
        $main = array_merge($main, $dig);
    if ($_latin_char)
        $main = array_merge($main, $lat);
    if ($_russian_char)
        $main = array_merge($main, $rus);
    shuffle($main);
    $pass = substr(implode('', $main), 0, $_length);

    return $pass;
}

$l = rand($cap_length_min, $cap_length_max);
$code = code_generic($l, $cap_digital, $cap_latin_char, $cap_russian_char);

$_SESSION['captcha'] = $code;

$canvas = imagecreatetruecolor($cap_width, $cap_height);

$c = imagecolorallocate($canvas, 150, 150, 150);
$c = imagecolorallocate($canvas, 255, 255, 255);

imagefilledrectangle($canvas, 0, 0, $cap_width, $cap_height, $c);
$count = strlen($code);
$color_text = imagecolorallocate($canvas, 0, 0, 0);

for ($it = 0; $it < $count; $it++) {
    $letter = $code[$it];
    imagestring($canvas, 6, (10 * $it + 10), $cap_height / 4, $letter, $color_text);
}
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: image/jpeg');

imagejpeg($canvas, null, $cap_quality);
