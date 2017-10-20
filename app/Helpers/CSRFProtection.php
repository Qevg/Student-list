<?php

namespace Students\Helpers;

class CSRFProtection
{
    public function setCSRFToken()
    {
        $token = isset($_POST['token']) ? $_POST['token'] : Util::randHash(32);
        setcookie('token', $token, time() + 3600, '/', $_SERVER['SERVER_NAME'], false, true);
        return $token;
    }

    public function checkCSRFToken()
    {
        if (!isset($_COOKIE['token']) || !isset($_POST['token']) || $_COOKIE['token'] != $_POST['token']) {
            return false;
        }
        return true;
    }
}
