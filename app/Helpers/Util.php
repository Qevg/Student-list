<?php

namespace Students\Helpers;

class Util
{
    public static function html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES);
    }

    public static function randHash($lenthHash = 32)
    {
        $bytes = random_bytes($lenthHash / 2);
        return bin2hex($bytes);
    }

    public static function highlight($search, $subject)
    {
        if ($search != null) {
            $pattern = '/' . preg_quote($search, '/') . '/ui';
            $replacement = '<mark>$0</mark>';
            $subject = preg_replace($pattern, $replacement, $subject);
        }
        return $subject;
    }

    public static function sort($name, $sort)
    {
        if ($sort[0] == $name) {
            return $sort[1] == 'ASC' ? '▲' : '▼';
        }
    }
}
