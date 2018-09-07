<?php

namespace Students\Entity;

/**
 * Class Table
 * @package Students\Entity
 */
class Table
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
     * Table constructor.
     *
     * @param string|null $search
     * @param string $column
     * @param string $orderBy
     */
    public function __construct($search, string $column, string $orderBy)
    {
        $this->search = $search;
        $this->column = $column;
        $this->orderBy = $orderBy;
    }

    /**
     * Shows sort order (for templates)
     *
     * @param string $column
     *
     * @return string|null
     */
    public function showSortOrder(string $column)
    {
        if ($column === $this->column) {
            return $this->orderBy === 'ASC' ? '▲' : '▼';
        }
    }

    /**
     * Highlights text (for templates)
     *
     * @param string $subject
     *
     * @return string
     */
    public function highlight(string $subject): string
    {
        if ($this->search !== null) {
            $pattern = '/' . preg_quote($this->search, '/') . '/ui';
            $replacement = '<mark>$0</mark>';
            $subject = preg_replace($pattern, $replacement, $subject);
        }
        return $subject;
    }

    /**
     * @return null|string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param null|string $search
     */
    public function setSearch($search): void
    {
        $this->search = $search;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @param string $column
     */
    public function setColumn(string $column): void
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }
}
