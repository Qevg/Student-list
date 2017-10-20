<?php

namespace Students\Validators;

use Students\Databases\StudentDataGateway;
use Students\Entity\Student;

class StudentValidator
{
    private $data;
    private $value;
    private $error;
    private $studentGW;
    private $template = array(
        'firstname' => array(
            'type' => 'string',
            'min' => 1,
            'max' => 60,
            'regexp' => '/^[А-ЯЁа-яё \'\\-]+|[A-Za-z \'\\-]+$/u',
            'message' => 'Имя должно состоять из кириллических или латинских символов и может содержать дефис, апостроф, пробел'
        ),
        'lastname' => array(
            'type' => 'string',
            'min' => 1,
            'max' => 60,
            'regexp' => '/^[А-ЯЁа-яё \'\\-]+|[A-Za-z \'\\-]+$/u',
            'message' => 'Фамилия должна состоять из кириллических или латинских символов и может содержать дефис, апостроф, пробел'
        ),
        'gender' => array(
            'type' => 'enum',
            'value1' => Student::GENDER_MALE,
            'value2' => Student::GENDER_FEMALE
        ),
        'groupNum' => array(
            'type' => 'string',
            'min' => 1,
            'max' => 5,
            'regexp' => '/^[А-ЯЁа-яё0-9\\-]+|[A-Za-z0-9\\-]+$/u',
            'message' => 'Номер группы должен состоять из кириллических или латинских символов, цифр и может содержать дефис'
        ),
        'email' => array(
            'type' => 'string',
            'min' => 3,
            'max' => 60,
            'regexp' => '/^.+@.+$/u',
            'message' => 'Адрес электронной почты должен состоять из двух частей, разделённых символом «@». Пример: name@example.com'
        ),
        'points' => array(
            'type' => 'number',
            'min' => 0,
            'max' => 500,
            'regexp' => '/^[0-9]+$/u',
            'message' => 'Это поле должно содержать только цифры'
        ),
        'year' => array(
            'type' => 'number',
            'min' => 1970,
            'max' => 2017,
            'regexp' => '/^[0-9]+$/u',
            'message' => 'Это поле должно содержать только цифры'
        ),
        'residence' => array(
            'type' => 'enum',
            'value1' => Student::RESIDENCE_RESIDENT,
            'value2' => Student::RESIDENCE_NONRESIDENT
        )
    );

    public function __construct($studentGW)
    {
        $this->studentGW = $studentGW;
    }

    public function filter()
    {
        foreach ($this->template as $key => $value) {
            $this->value[$key] = array_key_exists($key, $this->data) ? strval(trim($this->data[$key])) : '';
        }
    }

    public function validate()
    {
        foreach ($this->template as $key => $value) {
            if (isset($value['regexp'])) {
                if (!preg_match($value['regexp'], $this->value[$key])) {
                    $this->error[$key] = $value['message'];
                }
            }
            if ($value['type'] == 'string') {
                if (mb_strlen($this->value[$key]) == 0) {
                    $this->error[$key] = 'Пожалуйста заполните это поле';
                } elseif (mb_strlen($this->value[$key]) < $value['min']) {
                    $this->error[$key] = 'Это поле должно содержать минимум ' . $value['min'] . ' символов';
                } elseif (mb_strlen($this->value[$key]) > $value['max']) {
                    $this->error[$key] = 'Это поле не должно превышать ' . $value['max'] . ' символов';
                }
            } elseif ($value['type'] == 'number') {
                if ($this->value[$key] == null) {
                    $this->error[$key] = 'Пожалуйста заполните это поле';
                } elseif ($this->value[$key] < $value['min']) {
                    if (!isset($this->error[$key])) {
                        $this->error[$key] = 'Значение этого поля не должно быть меньше ' . $value['min'];
                    }
                } elseif ($this->value[$key] > $value['max']) {
                    if (!isset($this->error[$key])) {
                        $this->error[$key] = 'Значение этого поля не должно быть больше ' . $value['max'];
                    }
                }
            } elseif ($value['type'] == 'enum') {
                if ($this->value[$key] !== $value['value1'] && $this->value[$key] !== $value['value2']) {
                    $this->error[$key] = 'Выберите пожалуйста одно из двух значений';
                }
            }
        }
    }

    public function isEmailUsed($id = '')
    {
        if (!isset($this->error['email'])) {
            if ($this->studentGW->isEmailUsed($this->value['email'], $id) > 0) {
                $this->error['email'] = 'Этот email уже зарегистрирован';
            }
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getCountError()
    {
        return count($this->error);
    }


    public function getMin($name)
    {
        return $this->template[$name]['min'];
    }

    public function getMax($name)
    {
        return $this->template[$name]['max'];
    }

    public function getRegexpForClient($name)
    {
        // Delete all characters after the last '/'
        $regexp = substr($this->template[$name]['regexp'], 0, strrpos($this->template[$name]['regexp'], '/') + 1);

        $regexp = trim($regexp, '/');
        $regexp = ltrim($regexp, '^');
        $regexp = rtrim($regexp, '$');

        $search = array('\\', ' ');
        $replace = array('', '\s');
        $regexp = str_replace($search, $replace, $regexp);

        return $regexp;
    }

    public function getMessage($name)
    {
        return $this->template[$name]['message'];
    }
}
