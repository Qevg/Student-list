<?php
namespace Students\Controllers;

use Students\Helpers\Authorization;
use Students\Entity\Student;
use Students\Exceptions\BadRequestException;
use Students\Helpers\CSRFProtection;
use Students\Validators\Validator;
use Students\Views\View;
use Students\Helpers\Util;

class RegisterController extends Controller {
    protected $student;
    protected $authorization;
    protected $validator;
    protected $CSRFProtection;

    public function __construct(\Pimple\Container $container) {
        $this->c = $container;
        $this->student = new Student();
        $this->authorization = new Authorization();
        $this->validator = new Validator();
        $this->CSRFProtection = new CSRFProtection();
        $this->view = new View('register');
    }

	public function indexAction() {
	    $isAuth = false;
	    $userData = null;
        $token = $this->CSRFProtection->setCSRFToken();
        $error = null;
        if (isset($_COOKIE['Auth'])) {
            $this->validator->validateCookie($_COOKIE['Auth']);
            $hash = $this->validator->getValidCookie();
            if ($this->authorization->checkAuth($this->c['StudentGateway'], $hash) == true) {
                $isAuth = true;
                $userData = $this->c['StudentGateway']->getStudentByHash($hash);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->CSRFProtection->checkCSRFToken() == false) {
                throw new BadRequestException();
            }
            $this->c['StudentValidator']->setData($_POST);
            $this->c['StudentValidator']->filter();
            $this->c['StudentValidator']->validate();
            if ($isAuth == true) {
                $this->c['StudentValidator']->isEmailUsed($userData['id']);
            } else {
                $this->c['StudentValidator']->isEmailUsed();
            }

            if ($this->c['StudentValidator']->getCountError() == 0) {
                if ($isAuth == true) {
                    $this->student->setValue($this->c['StudentValidator']->getValue());
                    $this->student->setHash($hash);
                    $this->c['StudentGateway']->editStudent($this->student);
                    session_start();
                    $_SESSION['editStudent'] = true;
                    session_write_close();
                } else {
                    $this->student->setValue($this->c['StudentValidator']->getValue());
                    $this->student->setHash(Util::randHash());
                    $this->c['StudentGateway']->addStudent($this->student);
                    $this->authorization->logIn($this->student->getHash());
                    session_start();
                    $_SESSION['addStudent'] = true;
                    session_write_close();
                }
                header("Location: home");
            } else {
                $error = $this->c['StudentValidator']->getError();
                $userData = $this->c['StudentValidator']->getData();
            }
        }

        $studentValidator = $this->c['StudentValidator'];
        $this->view->render(compact('userData', 'isAuth', 'token', 'error', 'studentValidator'));
	 }
}