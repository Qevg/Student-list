<?php

namespace Students\Helpers;

/**
 * Generates link for templates
 *
 * Class TableAndPagerLinkHelper
 * @package Students\Helpers
 */
class TableAndPagerLinkHelper
{
    /**
     * @var string|null $search
     */
    private $search;

    /**
     * @var string $column
     */
    private $column;

    /**
     * @var string $orderBy
     */
    private $orderBy;

    /**
     * @var int $page
     */
    private $page;

    /**
     * TableAndPagerLinkHelper constructor.
     *
     * @param string|null $search
     * @param string $column
     * @param string $orderBy
     * @param int $page
     */
    public function __construct($search, string $column, string $orderBy, int $page)
    {
        $this->search = $search;
        $this->column = $column;
        $this->orderBy = $orderBy;
        $this->page = $page;
    }

    /**
     * Generates page url for pagination
     *
     * @param int $page
     *
     * @return string
     */
    public function generatePageUrl(int $page): string
    {
        $params = ['search' => $this->search, 'column' => $this->column, 'orderBy' => $this->orderBy, 'page' => $page];
        return '/?' . http_build_query($params);
    }

    /**
     * Generates sort url for student tables
     *
     * @param string $column
     *
     * @return string
     */
    public function generateSortUrl(string $column): string
    {
        $orderBy = $this->orderBy === 'ASC' ? 'DESC' : 'ASC';
        $params = ['search' => $this->search, 'column' => $column, 'orderBy' => $orderBy, 'page' => $this->page];
        return '/?' . http_build_query($params);
    }
}
