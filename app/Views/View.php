<?php

namespace Students\Views;

use Students\Helpers\UrlGenerator;

class View
{
    private $header;
    private $template;
    private $footer;

    public function __construct($template)
    {
        $this->header = __DIR__ . '/templates/header.php';
        $this->template = $template;
        $this->footer = __DIR__ . '/templates/footer.php';
    }

    public function render($params = [])
    {
        require_once $this->header;
        require_once __DIR__ . '/' . $this->template . '.php';
        require_once $this->footer;
    }
}
