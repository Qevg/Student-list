<?php

namespace Students\Databases;

use Students\Entity\Student;

/**
 * Class StudentDataGateway
 * @package Students\Databases
 */
class StudentDataGateway
{
    /**
     * @var \PDO $db
     */
    private $db;

    /**
     * StudentDataGateway constructor.
     *
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Adds student
     *
     * @param Student $student
     */
    public function addStudent(Student $student): void
    {
        $sql = "INSERT INTO `students` (`firstName`, `lastName`, `gender`, `groupNum`, `email`, `points`, `year`, `residence`, `token`)
		        VALUES (:firstName, :lastName, :gender, :groupNum, :email, :points, :year, :residence, :token)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':firstName', $student->getFirstName(), \PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $student->getLastName(), \PDO::PARAM_STR);
        $stmt->bindValue(':gender', $student->getGender(), \PDO::PARAM_STR);
        $stmt->bindValue(':groupNum', $student->getGroupNum(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $student->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':points', $student->getPoints(), \PDO::PARAM_INT);
        $stmt->bindValue(':year', $student->getYear(), \PDO::PARAM_INT);
        $stmt->bindValue(':residence', $student->getResidence(), \PDO::PARAM_STR);
        $stmt->bindValue(':token', $student->getToken(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Updates student
     *
     * @param Student $student
     */
    public function updateStudent(Student $student): void
    {
        $sql = "UPDATE `students` SET `firstName`=:firstName, `lastName`=:lastName, `gender`=:gender, `groupNum`=:groupNum, `email`=:email,
                `points`=:points, `year`=:year, `residence`=:residence WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $student->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(':firstName', $student->getFirstName(), \PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $student->getLastName(), \PDO::PARAM_STR);
        $stmt->bindValue(':gender', $student->getGender(), \PDO::PARAM_STR);
        $stmt->bindValue(':groupNum', $student->getGroupNum(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $student->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':points', $student->getPoints(), \PDO::PARAM_INT);
        $stmt->bindValue(':year', $student->getYear(), \PDO::PARAM_INT);
        $stmt->bindValue(':residence', $student->getResidence(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Gets students
     *
     * https://habr.com/post/217521/ limit offset optimization
     *
     * @param string|null $search
     * @param int $limit
     * @param int $offset
     * @param string $column
     * @param string $orderBy
     *
     * @return array
     */
    public function getStudents($search, int $limit, int $offset, string $column, string $orderBy): array
    {
        if ($search === null) {
            $sql = "SELECT `firstName`, `lastName`, `groupNum`, `points` FROM `students`
                    JOIN (SELECT `id` from `students` ORDER BY $column $orderBy LIMIT :limit OFFSET :offset) as b ON b.id = students.id";
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = "SELECT `firstName`, `lastName`, `groupNum`, `points` FROM `students`
                    JOIN (SELECT `id` FROM `students` WHERE CONCAT_WS(' ', `firstName`, `lastName`, `groupNum`, `points`) 
                    LIKE :search ORDER BY $column $orderBy LIMIT :limit OFFSET :offset) as b ON b.id = students.id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', '%' . addCslashes($search, '\%_') . '%', \PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'Students\Entity\Student');
    }

    /**
     * Gets count students
     *
     * @param string|null $search
     *
     * @return int
     */
    public function getCountStudents($search): int
    {
        if ($search === null) {
            $sql = "SELECT COUNT(*) FROM `students`";
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = "SELECT COUNT(*) FROM `students` WHERE CONCAT_WS(' ', `firstName`, `lastName`, `groupNum`, `points`) LIKE :search";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', '%' . addCslashes($search, '\%_') . '%', \PDO::PARAM_STR);
        }
        $stmt->execute();
        return intval($stmt->fetchColumn());
    }

    /**
     * Gets student by (auth) token
     *
     * @param string $token
     *
     * @return Student|false
     */
    public function getStudentByToken(string $token)
    {
        $sql = "SELECT * FROM `students` WHERE `token`=:token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject('Students\Entity\Student');
    }

    /**
     * Checks that email is unique
     *
     * If email is unique, it return true, otherwise return false
     *
     * @param string $email
     *
     * @return bool
     */
    public function isEmailUnique(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM `students` WHERE `email`=:email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return !boolval($stmt->fetchColumn());
    }

    /**
     * Checks auth token
     *
     * @param string $token
     *
     * @return bool
     */
    public function checkAuthToken(string $token): bool
    {
        $sql = "SELECT COUNT(*) FROM `students` WHERE `token`=:token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        return boolval($stmt->fetchColumn());
    }
}
