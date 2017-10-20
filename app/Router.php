<?php

namespace Students;

use Students\Exceptions\NotFoundException;

class Router
{
    public function start(\Pimple\Container $container)
    {
        $controller = "home";
        $action = "index";
        $container = $container;

        $parseUrl = parse_url($_SERVER["REQUEST_URI"]);
        if (isset($parseUrl['path'])) {
            $path = preg_split('/\//', $parseUrl['path'], -1, PREG_SPLIT_NO_EMPTY);
        }

        if (isset($path[0])) {
            $controller = $path[0];
        }

        if (isset($path[1])) {
            $action = $path[1];
        }

        $controller = sprintf('%s\%s\%s%s', __NAMESPACE__, 'Controllers', ucfirst(strtolower($controller)), 'Controller');
        $action = $action . 'Action';

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller($container);
            $controller->$action();
        } else {
            throw new NotFoundException();
        }
    }
}
