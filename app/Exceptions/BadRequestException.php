<?php
namespace Students\Exceptions;

use Throwable;

class BadRequestException extends \Exception {
    public function __construct($message = "Bad Request", $code = 400, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        header("HTTP/1.0 400 Bad Request");
        echo "Неверный запрос";
    }
}