<?php

namespace Students\Validators;

/**
 * Abstract class Validator
 * @package Students\Validators
 */
abstract class Validator
{
    /**
     * Validate the string to match the regular expression
     *
     * @param string $pattern
     * @param string $string
     *
     * @return bool
     */
    protected function validatePattern(string $pattern, string $string): bool
    {
        if (!preg_match($pattern, $string)) {
            return false;
        }
        return true;
    }

    /**
     * Validate the length of a string
     *
     * @param string $string
     * @param int $min
     * @param int $max
     *
     * @return bool
     */
    protected function validateLength(string $string, int $min, int $max): bool
    {
        if (mb_strlen($string) < $min || mb_strlen($string) > $max) {
            return false;
        }
        return true;
    }

    /**
     * Validate the number
     *
     * @param int $number
     * @param int $min
     * @param int $max
     *
     * @return bool
     */
    protected function validateNumber(int $number, int $min, int $max): bool
    {
        if ($number < $min || $number > $max) {
            return false;
        }
        return true;
    }
}
