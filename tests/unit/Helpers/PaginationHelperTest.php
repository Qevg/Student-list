<?php

namespace Students\Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use Students\Helpers\PaginationHelper;

/**
 * Class PaginationHelperTest
 * @package Students\Tests\Unit\Helpers
 */
class PaginationHelperTest extends TestCase
{
    /**
     * @var PaginationHelper $paginationHelper
     */
    private $paginationHelper;

    protected function setUp()
    {
        $this->paginationHelper = new PaginationHelper(1, 33, 15);
    }

    public function testGeneratePageNumbers()
    {
        $this->assertEquals(count($this->paginationHelper->generatePageNumbers()), 3);
    }

    public function testGetCurrentPage()
    {
        $this->assertEquals($this->paginationHelper->getCurrentPage(), 1);
    }

    public function testGetPreviousPage()
    {
        $this->assertEquals($this->paginationHelper->getPreviousPage(), null);
    }

    public function testGetNextPage()
    {
        $this->assertEquals($this->paginationHelper->getNextPage(), 2);
    }

    public function testCountPage()
    {
        $this->assertEquals($this->paginationHelper->getCountPage(), 3);
    }
}
