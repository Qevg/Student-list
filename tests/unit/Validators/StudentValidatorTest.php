<?php

namespace Students\Tests\Unit\Validators;

use PHPUnit\Framework\TestCase;
use Students\Databases\StudentDataGateway;
use Students\Entity\Student;
use Students\Validators\StudentValidator;

/**
 * Class StudentValidatorTest
 * @package Students\Tests\Unit\Validators
 */
class StudentValidatorTest extends TestCase
{
    /**
     * @var StudentValidator $studentValidator
     */
    private $studentValidator;

    protected function setUp()
    {
        $studentGateway = $this->createMock(StudentDataGateway::class);
        $studentGateway->method('isEmailUnique')->willReturn(true);
        $this->studentValidator = new StudentValidator($studentGateway);
    }

    public function testSuccessfulValidateRegister()
    {
        $post = [
            "firstName" => "test",
            "lastName" => "test",
            "gender" => "male",
            "groupNum" => "test",
            "email" => "test@example.com",
            "points" => "200",
            "year" => "2000",
            "residence" => "resident"
        ];

        $student = new Student();
        $student->setValues($post);
        $this->assertEmpty($this->studentValidator->validateRegister($student));
    }

    public function testUnsuccessfulValidateRegister()
    {
        $post = [
            "firstName" => "test1234567890",
            "lastName" => "test",
            "gender" => "male",
            "groupNum" => "test",
            "email" => "test@example.com",
            "points" => "200",
            "year" => "2000",
            "residence" => "resident"
        ];

        $student = new Student();
        $student->setValues($post);
        $this->assertNotEmpty($this->studentValidator->validateRegister($student));
    }

    public function testSuccessfulValidateUpdate()
    {
        $post = [
            "firstName" => "test",
            "lastName" => "test",
            "gender" => "male",
            "groupNum" => "test",
            "email" => "test@example.com",
            "points" => "200",
            "year" => "2000",
            "residence" => "resident"
        ];

        $student = new Student();
        $student->setValues($post);
        $this->assertEmpty($this->studentValidator->validateUpdate($student));
    }

    public function testUnsuccessfulValidateUpdate()
    {
        $post = [
            "firstName" => "test",
            "lastName" => "test",
            "gender" => "male",
            "groupNum" => "test",
            "email" => "test@example.com",
            "points" => "200",
            "year" => "1234567890",
            "residence" => "resident"
        ];

        $student = new Student();
        $student->setValues($post);
        $this->assertNotEmpty($this->studentValidator->validateUpdate($student));
    }
}
