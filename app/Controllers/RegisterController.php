<?php

namespace Students\Controllers;

use Students\Databases\StudentDataGateway;
use Students\Helpers\AuthHelper;
use Students\Entity\Student;
use Students\Helpers\CookieHelper;
use Students\Validators\StudentValidator;
use Students\Views\View;
use Pimple\Container;

/**
 * Class RegisterController
 * @package Students\Controllers
 */
class RegisterController
{
    /**
     * @var View $view
     */
    private $view;

    /**
     * @var AuthHelper $authHelper
     */
    private $authHelper;

    /**
     * @var StudentValidator $studentValidator
     */
    private $studentValidator;

    /**
     * @var StudentDataGateway $studentGateway
     */
    private $studentGateway;

    /**
     * @var CookieHelper $cookieHelper
     */
    private $cookieHelper;

    /**
     * @var null|Student
     */
    private $user;

    /**
     * @var array $errors
     */
    private $errors;

    /**
     * RegisterController constructor.
     *
     * @param Container $c
     */
    public function __construct(Container $c)
    {
        $this->view = $c['view'];
        $this->authHelper = $c['AuthHelper'];
        $this->studentValidator = $c['StudentValidator'];
        $this->studentGateway = $c['StudentGateway'];
        $this->cookieHelper = $c['CookieHelper'];
        $this->user = $this->authHelper->getUser();
    }

    /**
     * Shows register and update student page
     */
    public function __invoke(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student = new Student();
            $student->setValues($_POST);

            if ($this->authHelper->isAuth()) { // update student
                $this->errors = $this->studentValidator->validateUpdate($student);
                if (empty($this->errors)) {
                    $student->setId($this->user->getId());
                    $this->studentGateway->updateStudent($student);
                    $this->cookieHelper->setCookieToClient(CookieHelper::NOTIFY_NAME, 'updated', CookieHelper::NOTIFY_LIFETIME);
                    header('Location: /');
                    exit;
                }
            } else { // register student
                $this->errors = $this->studentValidator->validateRegister($student);
                if (empty($this->errors)) {
                    $student->setToken($this->authHelper->generateAuthToken());
                    $this->studentGateway->addStudent($student);
                    $this->cookieHelper->setCookieToClient(CookieHelper::AUTH_TOKEN_NAME, $student->getToken(), CookieHelper::AUTH_TOKEN_LIFETIME);
                    $this->cookieHelper->setCookieToClient(CookieHelper::NOTIFY_NAME, 'registered', CookieHelper::NOTIFY_LIFETIME);
                    header('Location: /');
                    exit;
                }
            }
        }
        $this->view->render('register', array('page' => 'register', 'user' => $this->user, 'errors' => $this->errors));
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->authHelper->isAuth()) {
                $this->cookieHelper->deleteCookieToClient(CookieHelper::AUTH_TOKEN_NAME, CookieHelper::AUTH_TOKEN_LIFETIME);
            }
        }

        header('Location: /');
        exit;
    }
}
