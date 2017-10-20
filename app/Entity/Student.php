<?php

namespace Students\Entity;

class Student
{
    private $firstname;
    private $lastname;
    private $gender;
    private $groupNum;
    private $email;
    private $points;
    private $year;
    private $residence;
    private $hash;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const RESIDENCE_RESIDENT = 'resident';
    const RESIDENCE_NONRESIDENT = 'nonresident';

    public function setValue($value)
    {
        foreach ($value as $v => $k) {
            $this->$v = $k;
        }
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function getLastName()
    {
        return $this->lastname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getGroupNum()
    {
        return $this->groupNum;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getResidence()
    {
        return $this->residence;
    }

    public function getHash()
    {
        return $this->hash;
    }
}
