<?php

use Pimple\Container;
use Students\Databases\StudentDataGateway;
use Students\Validators\StudentValidator;

$container = new Container;

$container['config'] = function($c) {
    return json_decode(file_get_contents(__DIR__.'/config.json'), true);
};

$container['db'] = function($c) {
    $db = new PDO("mysql:host=".$c['config']['db']['host'] . ";dbname=".$c['config']['db']['dbname'] . ";charset=UTF8",
        $c['config']['db']['user'], $c['config']['db']['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
};

$container['StudentGateway'] = function($c) {
    return new StudentDataGateway($c['db']);
};

$container['StudentValidator'] = function($c) {
    return new StudentValidator($c['StudentGateway']);
};