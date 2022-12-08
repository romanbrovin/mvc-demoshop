<?php use app\models\App; ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="/images/icons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/images/icons/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- CSS common block-->
    <link rel="stylesheet" href="/css/common/bootstrap.min.css">
    <link rel="stylesheet" href="/css/common/jquery.fancybox.min.css">
    <link rel="stylesheet" href="/css/common/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/common/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/common/list-groups.min.css">

    <!-- layouts CSS -->
    <?php
    $files = scandir(WWW . '/css/layouts');
    foreach ($files as $file) {
        if (strpos($file, 'adm.min.css') !== false) {
            echo '<link rel="stylesheet" href="/css/layouts/' . $file . '">';
        }

        if (strpos($file, 'default.min.css') !== false) {
            echo '<link rel="stylesheet" href="/css/layouts/' . $file . '">';
        }
    }
    ?>

    <?php foreach ($styles as $style) : ?>
        <?=$style . PHP_EOL?>
    <?php endforeach; ?>

    <!-- JS common block-->
    <script src="/js/common/jquery.3.6.0.min.js"></script>
    <script src="/js/common/bootstrap.bundle.min.js"></script>
    <script src="/js/common/fontawesome.6.1.1.all.min.js"></script>
    <script src="/js/common/jquery.fancybox.min.js"></script>
    <script src="/js/common/owl.carousel.min.js"></script>
    <script src="/js/common/functions.min.js"></script>
    <script src="/js/common/tinymce/tinymce.min.js"></script>

    <?php if ($route['controller'] == 'Order' && $route['action'] == 'edit') : ?>
        <script src="/js/common/ahunter.suggest.min.js"></script>
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">

    <meta name="robots" content="noindex, nofollow">

    <title><?=$meta['title']?></title>
</head>
<body>

<?php $_SESSION['token1'] = hash('md5', rand()); ?>
<input id="token2" type="hidden" value="<?=$_SESSION['token1']?>">

<?php App::renderBlock('modals/notification'); ?>
<?php App::renderBlock('scrollup'); ?>
<?php App::renderBlock('adm/navbar/top', ['route' => $route]); ?>

<div class="adm d-flex">

    <?php App::renderBlock('adm/navbar/left', ['route' => $route]); ?>

    <div class="flex-fill p-4 mt-3">

        <?php App::renderBlock('breadcrumb', ['route' => $route, 'meta' => $meta]); ?>
        <input type="hidden" id="uri" value="<?=$uri?>">

        <?=$content?>
    </div>

</div>

<?php App::renderBlock('loader'); ?>
<?php App::renderBlock('toast'); ?>
<?php App::renderBlock('offcanvas'); ?>

<!-- layouts JS -->
<?php
$files = scandir(WWW . '/js/layouts');
foreach ($files as $file) {
    if (strpos($file, 'adm.min.js') !== false) {
        echo '<script src="/js/layouts/' . $file . '"></script>';
    }

    if (strpos($file, 'default.min.js') !== false) {
        echo '<script src="/js/layouts/' . $file . '"></script>';
    }
}
?>

<?php foreach ($scripts as $script) : ?>
    <?=$script . PHP_EOL?>
<?php endforeach; ?>

</body>
</html>