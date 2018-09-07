<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->html($title) ?></title>
    <style>
        body {
            margin: 0;
            padding: 30px;
            font: 12px/1.5 Helvetica, Arial, Verdana, sans-serif;
        }
        h1 {
            margin: 0;
            font-size: 48px;
            font-weight: normal;
            line-height: 48px;
        }
    </style>
</head>
<body>
<h1><?= $this->html($caption) ?></h1>
<p><?= $this->html($message) ?></p>
<a href="/">Главная</a>
<?php if ($displayErrors === "1" || strtolower($displayErrors) === "on"): ?>
<p><?= $this->html($debugInfo) ?></p>
<?php endif; ?>
</body>
</html>