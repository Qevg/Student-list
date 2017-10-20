<?php
error_reporting(-1);

use Students\Router;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/container.php';

$router = new Router;
$router->start($container);
