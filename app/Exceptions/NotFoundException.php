<?php
namespace Students\Exceptions;

use Throwable;

class NotFoundException extends \Exception {
    public function __construct($message = "Not Found", $code = 404, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        header("HTTP/1.0 404 Not Found");
        echo "Страница не найдена";
    }
}