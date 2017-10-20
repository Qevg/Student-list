<?php extract($params); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php if ($this->template == "home"): ?>
        <title>Список студентов</title>
    <?php elseif ($this->template == "register" && $isAuth == false): ?>
        <title>Регистрация</title>
    <?php elseif ($this->template == "register" && $isAuth == true): ?>
        <title>Изменение данных</title>
    <?php endif; ?>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/user.css">
</head>
<body>