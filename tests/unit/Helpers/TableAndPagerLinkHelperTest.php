<?php

namespace Students\Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use Students\Helpers\TableAndPagerLinkHelper;

/**
 * Class TableAndPagerLinkHelperTest
 * @package Students\Tests\Unit\Helpers
 */
class TableAndPagerLinkHelperTest extends TestCase
{
    /**
     * @var TableAndPagerLinkHelper $linkHelper
     */
    private $linkHelper;

    protected function setUp()
    {
        $this->linkHelper = new TableAndPagerLinkHelper('test', 'firstName', 'ASC', 1);
    }

    public function testGeneratePageUrl()
    {
        $this->assertEquals($this->linkHelper->generatePageUrl(5), '/?search=test&column=firstName&orderBy=ASC&page=5');
    }

    public function testGenerateSortUrl()
    {
        $this->assertEquals($this->linkHelper->generateSortUrl('firstName'), '/?search=test&column=firstName&orderBy=DESC&page=1');
    }
}
