<?php

namespace Students\Tests\Unit\Helpers;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Students\Databases\StudentDataGateway;
use Students\Helpers\AuthHelper;

/**
 * Class AuthHelperTest
 * @package Students\Tests\Unit\Helpers
 */
class AuthHelperTest extends TestCase
{
    /**
     * @var MockObject $studentGatewayMock
     */
    private $studentGatewayMock;

    /**
     * @var AuthHelper $authHelper
     */
    private $authHelper;

    protected function setUp()
    {
        $this->studentGatewayMock = $this->createMock(StudentDataGateway::class);
        $this->authHelper = new AuthHelper($this->studentGatewayMock);
    }

    public function testGeneratorAuthToken()
    {
        $this->assertNotEmpty($this->authHelper->generateAuthToken());
    }
}
