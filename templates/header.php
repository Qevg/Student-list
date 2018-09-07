<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php if ($page === "home"): ?>
        <title>Список студентов</title>
    <?php elseif ($page === "register" && $user === null): ?>
        <title>Регистрация</title>
    <?php elseif ($page === "register" && $user !== null): ?>
        <title>Изменение данных</title>
    <?php endif; ?>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/user.css">
</head>
<body>