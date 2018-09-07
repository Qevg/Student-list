<?php

namespace Students\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Students\Entity\Student;

/**
 * Class StudentTest
 * @package Students\Tests\Unit\Entity
 */
class StudentTest extends TestCase
{
    public function testSuccessfulSetValues()
    {
        $student = new Student();
        $student->setValues(array('firstName' => 'test', 'groupNum' => 'test1'));
        $this->assertTrue(method_exists($student, 'getFirstName'));
        $this->assertEquals($student->getFirstName(), 'test');

        $this->assertTrue(method_exists($student, 'getGroupNum'));
        $this->assertEquals($student->getGroupNum(), 'test1');
    }

    public function testUnsuccessfulSetValues()
    {
        $student = new Student();
        $student->setValues(array('qwe' => 'test', 'groupNum' => 'test1'));
        $this->assertFalse(method_exists($student, 'getQwe'));

        $this->assertTrue(method_exists($student, 'getGroupNum'));
        $this->assertEquals($student->getGroupNum(), 'test1');
    }
}
