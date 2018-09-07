<?php

namespace Students\Validators;

use Students\Databases\StudentDataGateway;
use Students\Entity\Student;

/**
 * Class StudentValidator
 * @package Students\Validators
 */
class StudentValidator extends Validator
{
    /**
     * @var StudentDataGateway $studentGateway
     */
    private $studentGateway;

    /**
     * StudentValidator constructor.
     *
     * @param StudentDataGateway $studentGateway
     */
    public function __construct(StudentDataGateway $studentGateway)
    {
        $this->studentGateway = $studentGateway;
    }

    /**
     * Validates user register
     *
     * todo мб сделать сущность StudentError?
     *
     * @param Student $student
     *
     * @return array
     */
    public function validateRegister(Student $student): array
    {
        $errors = array();

        $errors['firstName'] = $this->validateFirstName($student->getFirstName());
        $errors['lastName'] = $this->validateLastName($student->getLastName());
        $errors['gender'] = $this->validateGender($student->getGender());
        $errors['groupNum'] = $this->validateGroupNum($student->getGroupNum());
        $errors['email'] = $this->validateEmail($student->getEmail());
        if (empty($errors['email'])) {
            $errors['email'] = $this->validateEmailUnique($student->getEmail());
        }
        $errors['points'] = $this->validatePoints($student->getPoints());
        $errors['year'] = $this->validateYear($student->getYear());
        $errors['residence'] = $this->validateResidence($student->getResidence());

        return array_filter($errors);
    }

    /**
     * Validates user update
     *
     * @param Student $student
     *
     * @return array
     */
    public function validateUpdate(Student $student): array
    {
        $errors = array();

        $errors['firstName'] = $this->validateFirstName($student->getFirstName());
        $errors['lastName'] = $this->validateLastName($student->getLastName());
        $errors['gender'] = $this->validateGender($student->getGender());
        $errors['groupNum'] = $this->validateGroupNum($student->getGroupNum());
        $errors['email'] = $this->validateEmail($student->getEmail());
        $errors['points'] = $this->validatePoints($student->getPoints());
        $errors['year'] = $this->validateYear($student->getYear());
        $errors['residence'] = $this->validateResidence($student->getResidence());

        return array_filter($errors);
    }

    /**
     * Validates first name
     *
     * @param string $firstName
     *
     * @return string|null
     */
    private function validateFirstName(string $firstName)
    {
        $min = 1;
        $max = 60;
        $errorLength = "Имя пользователя должно содержать не меньше {$min} и не больше {$max} символов";

        $pattern = '/^[А-ЯЁа-яё \'\\-]+|[A-Za-z \'\\-]+$/u';
        $errorPattern = 'Имя должно состоять из кириллических или латинских символов и может содержать дефис, апостроф, пробел';

        if (!$this->validateLength($firstName, $min, $max)) {
            return $errorLength;
        } elseif (!$this->validatePattern($pattern, $firstName)) {
            return $errorPattern;
        }
    }

    /**
     * Validates last name
     *
     * @param string $lastName
     *
     * @return string|null
     */
    private function validateLastName(string $lastName)
    {
        $min = 1;
        $max = 60;
        $errorLength = "Фамилия пользователя должна содержать не меньше {$min} и не больше {$max} символов";

        $pattern = '/^[А-ЯЁа-яё \'\\-]+|[A-Za-z \'\\-]+$/u';
        $errorPattern = 'Фамилия должна состоять из кириллических или латинских символов и может содержать дефис, апостроф, пробел';

        if (!$this->validateLength($lastName, $min, $max)) {
            return $errorLength;
        } elseif (!$this->validatePattern($pattern, $lastName)) {
            return $errorPattern;
        }
    }

    /**
     * Validates gender
     *
     * @param string $gender
     *
     * @return string|null
     */
    private function validateGender(string $gender)
    {
        if ($gender !== Student::GENDER_MALE && $gender !== Student::GENDER_FEMALE) {
            return 'Выберите пожалуйста пол';
        }
    }

    /**
     * Validates group num
     *
     * @param string $groupNum
     *
     * @return string|null
     */
    private function validateGroupNum(string $groupNum)
    {
        $min = 1;
        $max = 5;
        $errorLength = "Номер группы должен содержать не меньше {$min} и не больше {$max} символов";

        $pattern = '/^[А-ЯЁа-яё0-9\\-]+|[A-Za-z0-9\\-]+$/u';
        $errorPattern = 'Номер группы должен состоять из кириллических или латинских символов, цифр и может содержать дефис';

        if (!$this->validateLength($groupNum, $min, $max)) {
            return $errorLength;
        } elseif (!$this->validatePattern($pattern, $groupNum)) {
            return $errorPattern;
        }
    }

    /**
     * Validates email
     *
     * @param string $email
     *
     * @return string|null
     */
    private function validateEmail(string $email)
    {
        $min = 3;
        $max = 120;
        $errorLength = "Email адрес должен содержать не меньше {$min} и не больше {$max} символов";

        $pattern = '/^.+@.+$/u';
        $errorPattern = 'Адрес электронной почты должен состоять из двух частей, разделённых символом «@». Например: name@example.com';

        if (!$this->validateLength($email, $min, $max)) {
            return $errorLength;
        } elseif (!$this->validatePattern($pattern, $email)) {
            return $errorPattern;
        }
    }

    /**
     * Checks the uniqueness of email
     *
     * @param string $email
     *
     * @return string|null
     */
    private function validateEmailUnique(string $email)
    {
        if (!$this->studentGateway->isEmailUnique($email)) {
            return 'Этот email уже используется';
        }
    }

    /**
     * Validates points
     *
     * @param int $points
     *
     * @return string|null
     */
    private function validatePoints(int $points)
    {
        $min = 0;
        $max = 500;
        $errorLength = "Значение этого поля должно быть не меньше {$min} и не больше {$max}";

        $pattern = '/^[0-9]+$/u';
        $errorPattern = 'Это поле должно содержать только цифры';

         if (!$this->validateNumber($points, $min, $max)) {
            return $errorLength;
        } elseif (!$this->validatePattern($pattern, $points)) {
            return $errorPattern;
        }
    }

    /**
     * Validates year
     *
     * @param int $year
     *
     * @return string|null
     */
    private function validateYear(int $year)
    {
        $min = 1970;
        $max = 2017;
        $errorLength = "Значение этого поля должно быть не меньше {$min} и не больше {$max}";

        $pattern = '/^[0-9]+$/u';
        $errorPattern = 'Это поле должно содержать только цифры';

        if (!$this->validateNumber($year, $min, $max)) {
            return $errorLength;
        } elseif (!$this->validatePattern($pattern, $year)) {
            return $errorPattern;
        }
    }

    /**
     * Validates residence
     *
     * @param string $residence
     *
     * @return string|null
     */
    private function validateResidence(string $residence)
    {
        if ($residence !== Student::RESIDENCE_RESIDENT && $residence !== Student::RESIDENCE_NONRESIDENT) {
            return 'Выберите пожалуйста место проживания';
        }
    }
}
