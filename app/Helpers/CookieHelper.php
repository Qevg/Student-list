<?php

namespace Students\Helpers;

/**
 * Class CookieHelper
 * @package Students\Helpers
 */
class CookieHelper
{
    const AUTH_TOKEN_LIFETIME = '1 year';
    const CSRF_TOKEN_LIFETIME = '1 hour';
    const NOTIFY_LIFETIME = '1 hour';

    /**
     * Sets cookie to client
     *
     * @param string $name
     * @param string $value
     * @param string $time
     */
    public function setCookieToClient(string $name, string $value, string $time): void
    {
        setcookie($name, $value, strtotime($time), '/', null, false, true);
    }

    /**
     * Deletes cookie to client
     *
     * @param string $name
     * @param string $time
     */
    public function deleteCookieToClient(string $name, string $time): void
    {
        setcookie($name, "", strtotime("-{$time}"), '/', null, false, true);
    }
}
