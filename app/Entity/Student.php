<?php

namespace Students\Entity;

/**
 * Class Student
 * @package Students\Entity
 */
class Student
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const RESIDENCE_RESIDENT = 'resident';
    const RESIDENCE_NONRESIDENT = 'nonresident';

    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $firstName
     */
    private $firstName;

    /**
     * @var string $lastName
     */
    private $lastName;

    /**
     * @var string $gender
     */
    private $gender;

    /**
     * @var string $groupNum
     */
    private $groupNum;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var int $points
     */
    private $points;

    /**
     * @var int $year
     */
    private $year;

    /**
     * @var string $residence
     */
    private $residence;

    /**
     * @var string $token
     */
    private $token;

    /**
     * Recursive setting a values for variables using setters.
     * A whitelist of allowed setters for setting variables is also used.
     *
     * @param array $params
     */
    public function setValues(array $params): void
    {
        $functionWhiteList = ['setFirstName', 'setLastName', 'setGender', 'setGroupNum', 'setEmail', 'setPoints', 'setYear', 'setResidence'];
        foreach ($params as $key => $value) {
            $functionName = 'set' . ucfirst($key);
            if (method_exists($this, $functionName) && in_array($functionName, $functionWhiteList)) {
                $this->$functionName($value);
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getGroupNum(): string
    {
        return $this->groupNum;
    }

    /**
     * @param string $groupNum
     */
    public function setGroupNum(string $groupNum): void
    {
        $this->groupNum = $groupNum;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getResidence(): string
    {
        return $this->residence;
    }

    /**
     * @param string $residence
     */
    public function setResidence(string $residence): void
    {
        $this->residence = $residence;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
