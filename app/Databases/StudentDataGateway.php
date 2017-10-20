<?php

namespace Students\Databases;

use Students\Entity\Student;

class StudentDataGateway
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addStudent(Student $student)
    {
        $sql = "INSERT INTO `students` (`firstname`, `lastname`, `gender`, `groupNum`, `email`, `points`, `year`, `residence`, `hash`)
		        VALUES (:firstname, :lastname, :gender, :groupNum, :email, :points, :year, :residence, :hash)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':firstname', $student->getFirstName(), \PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $student->getLastName(), \PDO::PARAM_STR);
        $stmt->bindValue(':gender', $student->getGender(), \PDO::PARAM_STR);
        $stmt->bindValue(':groupNum', $student->getGroupNum(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $student->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':points', $student->getPoints(), \PDO::PARAM_INT);
        $stmt->bindValue(':year', $student->getYear(), \PDO::PARAM_INT);
        $stmt->bindValue(':residence', $student->getResidence(), \PDO::PARAM_STR);
        $stmt->bindValue(':hash', $student->getHash(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function editStudent(Student $student)
    {
        $sql = "UPDATE `students` SET `firstname`=:firstname, `lastname`=:lastname, `gender`=:gender, `groupNum`=:groupNum, `email`=:email,
                `points`=:points, `year`=:year, `residence`=:residence WHERE `hash`=:hash";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':firstname', $student->getFirstName(), \PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $student->getLastName(), \PDO::PARAM_STR);
        $stmt->bindValue(':gender', $student->getGender(), \PDO::PARAM_STR);
        $stmt->bindValue(':groupNum', $student->getGroupNum(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $student->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':points', $student->getPoints(), \PDO::PARAM_INT);
        $stmt->bindValue(':year', $student->getYear(), \PDO::PARAM_INT);
        $stmt->bindValue(':residence', $student->getResidence(), \PDO::PARAM_STR);
        $stmt->bindValue(':hash', $student->getHash(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getStudent($search, $limit, $offset, $column, $orderBy)
    {
        if ($search == null) {
            $sql = "SELECT `firstname`, `lastname`, `groupNum`, `points` FROM `students`
                    JOIN (SELECT `id` from `students` ORDER BY $column $orderBy LIMIT :limit OFFSET :offset) as b ON b.id = students.id";
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = "SELECT `firstname`, `lastname`, `groupNum`, `points` FROM `students`
                    JOIN (SELECT `id` FROM `students` WHERE CONCAT_WS(' ', `firstname`, `lastname`, `groupNum`, `points`) 
                    LIKE :search ORDER BY $column $orderBy LIMIT :limit OFFSET :offset) as b ON b.id = students.id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', '%' . addCslashes($search, '\%_') . '%', \PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        if ($this->getCountStudent($search) > 0) {
            $stmt->execute();
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCountStudent($search)
    {
        if ($search == null) {
            $sql = "SELECT COUNT(*) FROM `students`";
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = "SELECT COUNT(*) FROM `students` WHERE CONCAT_WS(' ', `firstname`, `lastname`, `groupNum`, `points`) LIKE :search";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', '%' . addCslashes($search, '\%_') . '%', \PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getStudentByHash($hash)
    {
        $sql = "SELECT * FROM `students` WHERE `hash`=:hash";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':hash', $hash, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function isEmailUsed($email, $id)
    {
        $sql = "SELECT COUNT(*) FROM `students` WHERE `email`=:email AND `id`<>:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function checkHash($hash)
    {
        $sql = "SELECT COUNT(*) FROM `students` WHERE `hash`=:hash";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':hash', $hash, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
