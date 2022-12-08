<?php use app\models\App; ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <!-- verification -->
    <meta name="verification" content="<?=GOOGLE_VERIFICATION?>">
    <meta name="yandex-verification" content="<?=YANDEX_VERIFICATION?>">

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="/images/icons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/images/icons/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- apple-touch-icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="/images/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/icons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/apple-touch-icon.png">

    <!-- twitter-->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="<?=TWITTER_URL?>">
    <meta name="twitter:site" content="<?=TWITTER_SITE?>">
    <meta name="twitter:image:src" content="//<?=TWITTER_IMAGE?>">

    <!-- msapplication-->
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/images/icons/mstile-144x144.png">
    <meta name="msapplication-square70x70logo" content="/images/icons/mstile-70x70.png">
    <meta name="msapplication-square150x150logo" content="/images/icons/mstile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/images/icons/mstile-310x150.png">
    <meta name="msapplication-square310x310logo" content="/images/icons/mstile-310x310.png">

    <!-- og -->
    <meta property="og:locale" content="ru_RU">
    <meta property="og:type" content="website">
    <meta property="og:image:height" content="<?=OG_IMAGE_HEIGHT?>">
    <meta property="og:image:width" content="<?=OG_IMAGE_WIDTH?>">
    <meta property="og:site_name" content="<?=OG_NAME?>">
    <meta property="og:url" content="//<?=OG_URL?>">

    <?php if ($route['controller'] == 'Product'
        || ($route['controller'] == 'Catalog' && $route['action'] == 'category')) : ?>
        <meta name="twitter:title" content="<?=$meta['title']?>">
        <meta name="twitter:description" content="<?=$meta['description']?>">
        <meta property="og:title" content="<?=$meta['title']?>">
        <meta property="og:description" content="<?=$meta['description']?>">
        <meta name="title" content="<?=$meta['title']?>">
        <meta name="description" content="<?=$meta['description']?>">
    <?php else : ?>
        <meta name="twitter:title" content="<?=TWITTER_TITLE?>">
        <meta name="twitter:description" content="<?=TWITTER_DESCRIPTION?>">
        <meta property="og:title" content="<?=OG_TITLE?>">
        <meta property="og:description" content="<?=OG_DESCRIPTION?>">
        <meta property="og:image" content="//<?=OG_IMAGE?>">
        <meta name="title" content="<?=SITE_DESCRIPTION;?>">
        <meta name="description" content="<?=SITE_DESCRIPTION;?>">
    <?php endif; ?>

    <?php if ($route['controller'] == 'Product') : ?>
        <meta property="og:image" content="//<?=OG_URL?><?=$product['avatar']?>">
    <?php else : ?>
        <meta property="og:image" content="//<?=OG_IMAGE?>">
    <?php endif; ?>

    <!-- other block-->
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/images/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="image_src" href="//<?=SITE_IMAGE_VK?>">
    <meta name="image" content="//<?=SITE_IMAGE?>">
    <meta name="theme-color" content="#ffffff">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-title" content="<?=APP_TITLE?>">
    <meta name="application-name" content="<?=APP_NAME?>">
    <meta name="keywords" content="<?=SITE_KEYWORDS?>">
    <meta name="robots" content="<?=$meta['robots'] ?? SITE_ROBOTS;?>">
    <meta property="fb:app_id" content="<?=FB_APP_ID?>">
    <meta http-equiv="refresh" content="<?=$meta['refresh'] ?? '';?>">

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

    <?php if ($route['controller'] == 'Order' && $route['action'] == 'index') : ?>
        <script src="/js/common/ahunter.suggest.min.js"></script>
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">

    <title><?=$meta['title']?></title>
</head>
<body itemscope itemtype="https://schema.org/WebSite">

<?php $_SESSION['token1'] = hash('md5', rand()); ?>
<input id="token2" type="hidden" value="<?=$_SESSION['token1']?>">

<div style="position: fixed; bottom: 10px; z-index: 9999; padding: 2px 5px; left: 10px; background-color: #ccc;">
    <div style="color: red; font-size: 12px">
        <strong>ДЕМО-ВЕРСИЯ</strong>
    </div>
    <div style="color: #444; font-size: 10px">
        АВТОРИЗАЦИЯ <br>
        Клиент: user@shop.ru <br>
        Администратор: admin@shop.ru <br>
        Пароль: demo
    </div>
</div>

<?php App::renderBlock('modals/notification'); ?>
<?php App::renderBlock('modals/search'); ?>
<?php App::renderBlock('modals/categories'); ?>

<?php App::renderBlock('navbar'); ?>
<?php App::renderBlock('scrollup'); ?>

<?php if ($route['controller'] == 'Index') : ?>
    <?php App::renderBlock('banners'); ?>
<?php endif; ?>

<div class="container wrapper">
    <?php App::renderBlock('breadcrumb', ['route' => $route, 'meta' => $meta]); ?>

    <?=$content?>

</div>

<?php App::renderBlock('loader'); ?>
<?php App::renderBlock('footer'); ?>
<?php App::renderBlock('toast'); ?>
<?php App::renderBlock('offcanvas'); ?>

<!-- layouts JS -->
<?php
$files = scandir(WWW . '/js/layouts');
foreach ($files as $file) {
    if (strpos($file, 'default.min.js') !== false) {
        echo '<script src="/js/layouts/' . $file . '"></script>';
    }
}
?>

<?php foreach ($scripts as $script) : ?>
    <?=$script . PHP_EOL?>
<?php endforeach; ?>

<?php App::renderBlock('basket'); ?>

<?php if (DB_LOCAL == 0) { ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {(m[i].a = m[i].a || []).push(arguments)};
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(91579007, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/91579007" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
<?php } ?>

</body>
</html>