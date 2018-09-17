<?php

namespace Students\Helpers;

/**
 * Class CSRFProtection
 * @package Students\Helpers
 */
class CSRFProtection
{
    /**
     * @var CookieHelper $cookieHelper
     */
    private $cookieHelper;

    /**
     * @var string $csrfToken
     */
    private $csrfToken;

    /**
     * CSRFProtection constructor.
     *
     * @param CookieHelper $cookieHelper
     */
    public function __construct(CookieHelper $cookieHelper)
    {
        $this->cookieHelper = $cookieHelper;
    }

    /**
     * Start csrf protection
     *
     * Generates csrf token and set csrf-cookie to client
     */
    public function startCsrfProtection(): void
    {
        $this->csrfToken = !empty($_COOKIE['csrf']) ? strval($_COOKIE['csrf']) : bin2hex(random_bytes(32));
        $this->cookieHelper->setCookieToClient(CookieHelper::CSRF_TOKEN_NAME, $this->csrfToken, CookieHelper::CSRF_TOKEN_LIFETIME);
    }

    /**
     * Validate csrf token
     *
     * Checks, that the csrf token is valid
     *
     * @return bool
     */
    public function validateCsrfToken(): bool
    {
        if (!empty($_COOKIE['csrf']) && !empty($_POST['csrf']) && strval($_COOKIE['csrf']) === strval($_POST['csrf'])) {
            return true;
        }
        return false;
    }

    /**
     * Get csrf token
     *
     * @return string
     */
    public function getCsrfToken(): string
    {
        return $this->csrfToken;
    }
}
