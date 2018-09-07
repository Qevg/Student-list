<?php

namespace Students\Views;

use Students\Helpers\CSRFProtection;

/**
 * Class View
 * @package Students\Views
 */
class View
{
    /**
     * @var string $csrfToken
     */
    private $csrfToken;

    /**
     * View constructor.
     *
     * @param CSRFProtection $csrf
     */
    public function __construct(CSRFProtection $csrf)
    {
        $this->csrfToken = $csrf->getCsrfToken();
    }

    /**
     * Render template
     *
     * @param string $template
     * @param array $params
     */
    public function render(string $template, array $params = []): void
    {
        extract($params);
        require_once __DIR__ . "/../../templates/{$template}.php";
    }

    /**
     * Convert special characters to HTML entities
     *
     * @param mixed $string
     *
     * @return string
     */
    public function html($string): string
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    /**
     * @return string
     */
    public function getCsrfToken(): string
    {
        return $this->csrfToken;
    }
}
