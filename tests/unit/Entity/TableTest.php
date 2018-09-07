<?php

namespace Students\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Students\Entity\Table;

/**
 * Class TableTest
 * @package Students\Tests\Unit\Entity
 */
class TableTest extends TestCase
{
    public function testShowSortOrder()
    {
        $table = new Table(null, 'firstName', 'ASC');
        $this->assertEquals($table->showSortOrder('firstName'), '▲');
    }

    public function testHighlight()
    {
        $table = new Table('test', 'firstName', 'ASC');
        $this->assertEquals($table->highlight('test'), '<mark>test</mark>');
    }
}
