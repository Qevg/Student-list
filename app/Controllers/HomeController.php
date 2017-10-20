<?php

namespace Students\Controllers;

use Students\Helpers\Authorization;
use Students\Helpers\Util;
use Students\Validators\Validator;
use Students\Views\View;
use Students\Helpers\UrlGenerator;

class HomeController extends Controller
{
    protected $authorization;
    protected $validator;

    public function __construct(\Pimple\Container $container)
    {
        $this->c = $container;
        $this->authorization = new Authorization();
        $this->validator = new Validator();
        $this->view = new View('home');
    }

    public function indexAction()
    {
        $isAuth = false;
        $userName = null;
        $message = [];

        $this->validator->validateSearch($this->c['StudentGateway'], $_GET);
        $search = $this->validator->getValidSearch();

        $limit = 15;
        $countStudent = $this->c['StudentGateway']->getCountStudent($search);
        $countPage = ceil($countStudent / $limit);

        $this->validator->validatePage($_GET, $countPage);
        $currentPage = $this->validator->getValidPage();

        $offset = ($currentPage - 1) * $limit;

        $this->validator->validateSort($_GET);
        $column = $this->validator->getValidColumn();
        $orderBy = $this->validator->getValidOrderBy();

        if (isset($_COOKIE['Auth'])) {
            $this->validator->validateCookie($_COOKIE['Auth']);
            $hash = $this->validator->getValidCookie();
            if ($this->authorization->checkAuth($this->c['StudentGateway'], $hash) == true) {
                if (isset($_GET['logout'])) {
                    $this->authorization->logOut($hash);
                    header("Location: home");
                } else {
                    $isAuth = true;
                    $userData = $this->c['StudentGateway']->getStudentByHash($hash);
                    $userName = $userData['firstname'] . ' ' . $userData['lastname'];
                }
            }
        }
        session_start();
        if (isset($_SESSION['addStudent']) && ($_SESSION['addStudent'] == true)) {
            $message['addStudent'] = true;
            unset($_SESSION['addStudent']);
        } elseif (isset($_SESSION['editStudent']) && ($_SESSION['editStudent'] == true)) {
            $message['editStudent'] = true;
            unset($_SESSION['editStudent']);
        }
        session_write_close();

        $students = $this->c['StudentGateway']->getStudent($search, $limit, $offset, $column, $orderBy);
        $urlGenerator = new UrlGenerator($search, $column, $orderBy, $currentPage);
        $this->view->render(
            compact(
                'students',
                'urlGenerator',
                'isAuth',
                'userName',
                'message',
                'countStudent',
                'countPage',
                'currentPage',
                'search',
                'column',
                'orderBy'
            )
        );
    }
}
