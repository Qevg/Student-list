<?php

error_reporting(-1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/container.php';

$router = $container['router'];
$router->run();
