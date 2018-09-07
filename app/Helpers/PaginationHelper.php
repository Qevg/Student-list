<?php

namespace Students\Helpers;

/**
 * Class PaginationHelper
 * @package Students\Helpers
 */
class PaginationHelper
{
    /**
     * @var int $currentPage
     */
    private $currentPage;

    /**
     * @var int $countStudents
     */
    private $countStudents;

    /**
     * @var int $limit
     */
    private $limit;

    /**
     * PaginationHelper constructor.
     *
     * @param int $currentPage
     * @param int $countStudents
     * @param int $limit
     */
    public function __construct(int $currentPage, int $countStudents, int $limit)
    {
        $this->currentPage = $currentPage;
        $this->countStudents = $countStudents;
        $this->limit = $limit;
    }

    /**
     * Generates page numbers
     *
     * todo refactoring this method
     *
     * @param int $numLeftPage number of pages to the left. Default 2
     * @param int $numRigthPage number of pages to the rigth Default 2
     *
     * @return array
     */
    public function generatePageNumbers(int $numLeftPage = 2, int $numRigthPage = 2): array
    {
        $pages = array();

        if ($this->getCurrentPage() + 1 >= $this->getCountPage()) {
            $numLeftPage++;
        }
        if ($this->currentPage === $this->getCountPage()) {
            $numLeftPage++;
        }

        //left pages
        while ($numLeftPage > 0) {
            if ($this->getCurrentPage() - $numLeftPage > 0) {
                $pages[] = $this->getCurrentPage() - $numLeftPage;
            } else {
                $numRigthPage++;
            }
            $numLeftPage--;
        }

        //current page
        $pages[] = $this->getCurrentPage();

        //rigth pages
        for ($i = 1; $i <= $numRigthPage; $i++) {
            if ($this->getCurrentPage() + $i <= $this->getCountPage()) {
                $pages[] = $this->getCurrentPage() + $i;
            }
        }

        return $pages;
    }

    /**
     * Gets current page
     *
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Gets previous page
     *
     * @return int|null
     */
    public function getPreviousPage()
    {
        return $this->getCurrentPage() > 1 ? $this->getCurrentPage() - 1 : null;
    }

    /**
     * Gets next page
     *
     * @return int|null
     */
    public function getNextPage()
    {
        return $this->getCountPage() > 1 && $this->getCurrentPage() !== $this->getCountPage() ? $this->getCurrentPage() + 1 : null;
    }

    /**
     * Gets count page
     *
     * @return int
     */
    public function getCountPage(): int
    {
        return ceil($this->countStudents / $this->limit);
    }
}
