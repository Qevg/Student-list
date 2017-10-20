<?php

namespace Students\Helpers;

class UrlGenerator
{
    private $search;
    private $column;
    private $orderBy;
    private $page;

    public function __construct($search, $column, $orderBy, $page)
    {
        $this->search = $search;
        $this->column = $column;
        $this->orderBy = $orderBy;
        $this->page = $page;
    }

    public function generatePageUrl($page)
    {
        $param = ['search' => $this->search, 'column' => $this->column, 'orderBy' => $this->orderBy, 'page' => $page];
        return 'home' . "?" . http_build_query($param);
    }

    public function generateSortUrl($column)
    {
        $orderBy = $this->orderBy == 'ASC' ? 'DESC' : 'ASC';
        $param = ['search' => $this->search, 'column' => $column, 'orderBy' => $orderBy, 'page' => $this->page];
        return 'home' . "?" . http_build_query($param);
    }
}
