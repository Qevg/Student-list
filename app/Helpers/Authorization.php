<?php

namespace Students\Helpers;

class Authorization
{
    public function checkAuth($studentGW, $cookie)
    {
        return $studentGW->checkHash($cookie) > 0 ? true : false;
    }

    public function logIn($hash)
    {
        setcookie('Auth', $hash, time() + 10 * 365 * 24 * 60 * 60, '/', $_SERVER['SERVER_NAME'], false, true);
    }

    public function logOut($hash)
    {
        setcookie('Auth', $hash, time() - 10 * 365 * 24 * 60 * 60, '/', $_SERVER['SERVER_NAME'], false, true);
    }
}
