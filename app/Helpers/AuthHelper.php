<?php

namespace Students\Helpers;

use Students\Databases\StudentDataGateway;
use Students\Entity\Student;

/**
 * Class AuthHelper
 * @package Students\Helpers
 */
class AuthHelper
{
    /**
     * @var StudentDataGateway $studentGateway
     */
    private $studentGateway;

    /**
     * AuthHelper constructor.
     *
     * @param StudentDataGateway $studentGateway
     */
    public function __construct(StudentDataGateway $studentGateway)
    {
        $this->studentGateway = $studentGateway;
    }

    /**
     * Generates auth token. Default length 64 symbol
     *
     * @return string
     */
    public function generateAuthToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Checks, that the user is auth
     *
     * @return bool
     */
    public function isAuth(): bool
    {
        return isset($_COOKIE['auth']) ? $this->studentGateway->checkAuthToken(strval($_COOKIE['auth'])) : false;
    }

    /**
     * Gets user
     *
     * @return Student|null
     */
    public function getUser()
    {
        return $this->isAuth() ? $this->studentGateway->getStudentByToken(strval($_COOKIE['auth'])) : null;
    }
}
