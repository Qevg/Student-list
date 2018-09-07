<?php

namespace Students\Tests\Unit\Validators;

use PHPUnit\Framework\TestCase;
use Students\Validators\Validator;

/**
 * Class ValidatorTest
 * @package Students\Tests\Unit\Validators
 */
class ValidatorTest extends TestCase
{
    /**
     * @var new class extends Validator
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = new class extends Validator {
            public function validatePattern(string $pattern, string $string): bool
            {
                return parent::validatePattern($pattern, $string);
            }

            public function validateLength(string $string, int $min, int $max): bool
            {
                return parent::validateLength($string, $min, $max);
            }

            public function validateNumber(int $number, int $min, int $max): bool
            {
                return parent::validateNumber($number, $min, $max);
            }
        };
    }

    public function testSuccessfulValidatePattern()
    {
        $this->assertTrue($this->validator->validatePattern('/^.+@.+$/u', 'test@example.com'));
    }

    public function testUnsuccessfulValidatePattern()
    {
        $this->assertFalse($this->validator->validatePattern('/^.+@.+$/u', 'test'));
    }

    public function testSuccessfulValidateLength()
    {
        $this->assertTrue($this->validator->validateLength('qwerty', 0, 6));
    }

    public function testUnsuccessfulValidateLength()
    {
        $this->assertFalse($this->validator->validateLength('qwerty', 0, 3));
    }

    public function testSuccessfulValidateNumber()
    {
        $this->assertTrue($this->validator->validateNumber(8, 3, 30));
    }

    public function testUnsuccessfulValidateNumber()
    {
        $this->assertFalse($this->validator->validateNumber(8, 9, 10));
    }
}
