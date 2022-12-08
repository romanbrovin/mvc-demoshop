<?php http_response_code(404); ?>
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

    <meta name="robots" content="noindex, nofollow">

    <!-- CSS common block-->
    <link rel="stylesheet" href="/css/common/bootstrap.min.css">

    <!-- layouts CSS -->
    <?php
    $files = scandir(WWW . '/css/layouts');
    foreach ($files as $file) {
        if (strpos($file, 'default.min.css') !== false) {
            echo '<link rel="stylesheet" href="/css/layouts/' . $file . '">';
        }
    }
    ?>

    <!-- JS common block-->
    <script src="/js/common/jquery.3.6.0.min.js"></script>
    <script src="/js/common/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">

    <title>404 Страница не найдена</title>
</head>
<body>

<div class="container wrapper mt-60 text-center">
    <h1>Упс!</h1>
    <h3 class="text-secondary">Страница не найдена :-(</h3>
    <div class="mt-4 mb-120">
        <a class="btn btn-secondary" href="/">На главную</a>
    </div>
</div>

</body>
</html>
