<?php

namespace Students\Validators;

class Validator
{
    private $value;

    public function validateSearch($studentGW, $data)
    {
        $this->value['search'] = isset($data['search']) ? strval($data['search']) : null;
        if (mb_strlen($this->value['search']) > 500) {
            $this->value['search'] = mb_substr($this->value['search'], 0, 500);
        }
    }

    public function validatePage($data, $countPage)
    {
        $this->value['page'] = isset($data['page']) ? intval($data['page']) : 1;
        if ($this->value['page'] > $countPage) {
            $this->value['page'] = $countPage;
        } elseif ($this->value['page'] < 1) {
            $this->value['page'] = 1;
        }
    }

    public function validateSort($data)
    {
        $columns = array('firstname', 'lastname', 'groupNum', 'points');
        $this->value['column'] = isset($data['column']) && in_array($data['column'], $columns) ? $data['column'] : 'points';
        $this->value['orderBy'] = isset($data['orderBy']) && $data['orderBy'] == 'ASC' ? 'ASC' : 'DESC';
    }

    public function validateCookie($cookie)
    {
        if (!preg_match('/^[a-z0-9]{0,256}$/ui', $cookie)) {
            $cookie = '';
        }
        $this->value['cookie'] = $cookie;
    }

    public function getValidSearch()
    {
        return $this->value['search'];
    }

    public function getValidPage()
    {
        return $this->value['page'];
    }

    public function getValidColumn()
    {
        return $this->value['column'];
    }

    public function getValidOrderBy()
    {
        return $this->value['orderBy'];
    }

    public function getValidCookie()
    {
        return $this->value['cookie'];
    }
}
