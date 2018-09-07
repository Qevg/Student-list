<?php

namespace Students;

use Psr\Container\ContainerInterface;
use Students\Controllers\HomeController;
use Students\Controllers\RegisterController;
use Students\Exceptions\CsrfException;
use Students\Exceptions\MalformedUrlException;
use Students\Exceptions\NotFoundException;
use Pimple\Container;
use Students\Helpers\CSRFProtection;

/**
 * Class Router
 * @package Students
 */
class Router
{
    /**
     * @var Container $container
     */
    private $container;

    /**
     * @var CSRFProtection $csrfProtection
     */
    private $csrfProtection;

    /**
     * Router constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->csrfProtection = $container['CSRFProtection'];

        $this->addHandler();
        $this->startCsrfProtection();
    }

    /**
     * Run router
     *
     * @throws NotFoundException
     */
    public function run(): void
    {
        $url = $this->parseUrl($_SERVER["REQUEST_URI"]);

        switch ($url['path']) {
            case '/' :
                $controller = new HomeController($this->container);
                $controller();
                break;
            case '/register':
                $controller = new RegisterController($this->container);
                $controller();
                break;
            case '/logout':
                $controller = new RegisterController($this->container);
                $controller->logout();
                break;
            default:
                throw new NotFoundException();
        }
    }

    /**
     * Parse url
     *
     * @param string $url
     *
     * @return array
     * @throws MalformedUrlException
     */
    private function parseUrl(string $url): array
    {
        $parts = parse_url($url);

        if ($parts === false) {
            throw new MalformedUrlException("Failed to parse url: {$url}");
        }

        return $parts;
    }

    /**
     * Adds exception and error handler
     */
    private function addHandler(): void
    {
        set_exception_handler($this->container['exceptionHandler']);
        set_error_handler($this->container['errorHandler']);
    }

    /**
     * Start csrf protection
     *
     * Validates csrf token for 'post', 'put' and 'delete' methods
     *
     * @throws CsrfException
     */
    private function startCsrfProtection(): void
    {
        $this->csrfProtection->startCsrfProtection();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if (!$this->csrfProtection->validateCsrfToken()) {
                throw new CsrfException('Invalid CSRF token');
            }
        }
    }
}
