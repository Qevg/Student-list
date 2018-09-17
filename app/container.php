<?php

use Pimple\Container;
use Students\Databases\StudentDataGateway;
use Students\Validators\StudentValidator;
use Students\Helpers\AuthHelper;
use Students\Views\View;
use Students\Router;
use Students\Exceptions\NotFoundException;
use Students\Exceptions\ConfigParseException;
use Students\Helpers\CookieHelper;
use Students\Helpers\CSRFProtection;

$container = new Container;

$container['environment'] = function (Container $c) {
    $config = json_decode(file_get_contents(__DIR__ . '/../config/config.json'), true);
    if ($config === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new ConfigParseException(json_last_error_msg());
    }

    $env = isset($config['environment']) ? $config['environment'] : false;
    if ($env === false) {
        throw new ConfigParseException('environment is undefined in the config file "config.json"');
    }

    if ($env !== 'production' && $env !== 'development' && $env !== 'testing') {
        throw new ConfigParseException('incorrect value "environment" in the config file "config.json". Allowable values: production, development, testing');
    }

    return $env;
};

$container['config'] = function (Container $c) {
    $config = json_decode(file_get_contents(__DIR__ . "/../config/config_{$c['environment']}.json"), true);
    if ($config === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new ConfigParseException(json_last_error_msg());
    }
    return $config;
};

$container['db'] = function (Container $c) {
    $db = new PDO(
        sprintf(
            "mysql:host=%s;port=%d;dbname=%s",
            $c['config']['db']['host'],
            $c['config']['db']['port'],
            $c['config']['db']['dbname']
        ),
        $c['config']['db']['user'],
        $c['config']['db']['password']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
};

$container['view'] = function (Container $c) {
    return new View($c['CSRFProtection']);
};

$container['router'] = function (Container $c) {
    return new Router($c);
};

$container['StudentGateway'] = function (Container $c) {
    return new StudentDataGateway($c['db']);
};

$container['StudentValidator'] = function (Container $c) {
    return new StudentValidator($c['StudentGateway']);
};

$container['AuthHelper'] = function (Container $c) {
    return new AuthHelper($c['StudentGateway']);
};

$container['CookieHelper'] = function (Container $c) {
    return new CookieHelper();
};

$container['CSRFProtection'] = function (Container $c) {
    return new CSRFProtection($c['CookieHelper']);
};

$container['exceptionHandler'] = function (Container $c) {
    return function (Throwable $exception) use ($c) {
        if ($exception instanceof NotFoundException) {
            header("HTTP/1.0 404 Not Found");
            $c['view']->render('error',
                [
                    'title' => "Page Not Found",
                    'caption' => "Page Not Found",
                    'message' => "The page you are looking for could not be found",
                    'displayErrors' => "off",
                    'debugInfo' => null
                ]
            );
        } else {
            error_log($exception->__toString());
            header("HTTP/1.0 500 Internal Server Error");
            $c['view']->render('error',
                [
                    'title' => "Internal Server Error",
                    'caption' => "Internal Server Error",
                    'message' => "We have technical problems. Refresh the page after some time",
                    'displayErrors' => ini_get("display_errors"),
                    'debugInfo' => $exception->__toString()
                ]
            );
        }
    };
};

$container['errorHandler'] = function (Container $c) {
    return function ($errno, $errstr, $errfile, $errline) {
        if (!error_reporting()) {
            return;
        }
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    };
};
