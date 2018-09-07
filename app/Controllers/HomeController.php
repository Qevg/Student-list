<?php

namespace Students\Controllers;

use Students\Databases\StudentDataGateway;
use Students\Entity\Student;
use Students\Entity\Table;
use Students\Helpers\AuthHelper;
use Students\Helpers\CookieHelper;
use Students\Helpers\PaginationHelper;
use Students\Helpers\Util;
use Students\Validators\Validator;
use Students\Views\View;
use Students\Helpers\TableAndPagerLinkHelper;
use Pimple\Container;

/**
 * Class HomeController
 * @package Students\Controllers
 */
class HomeController
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
     * @var StudentDataGateway $studentGateway
     */
    private $studentGateway;

    /**
     * @var CookieHelper $cookieHelper
     */
    private $cookieHelper;

    /**
     * @var null|Student $user
     */
    private $user;

    /**
     * HomeController constructor.
     *
     * @param Container $c
     */
    public function __construct(Container $c)
    {
        $this->view = $c['view'];
        $this->authHelper = $c['AuthHelper'];
        $this->studentGateway = $c['StudentGateway'];
        $this->cookieHelper = $c['CookieHelper'];
        $this->user = $this->authHelper->getUser();
    }

    /**
     * Shows home page
     */
    public function __invoke(): void
    {
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 15; //students on page
        $offset = ($currentPage - 1) * $limit;

        $columns = array('firstName', 'lastName', 'groupNum', 'points');
        $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? strval($_GET['column']) : 'points';
        $orderBy = isset($_GET['orderBy']) && $_GET['orderBy'] === 'ASC' ? 'ASC' : 'DESC';
        $search = isset($_GET['search']) ? trim(strval($_GET['search'])) : null;

        $students = $this->studentGateway->getStudents($search, $limit, $offset, $column, $orderBy);
        $countStudent = $this->studentGateway->getCountStudents($search);

        $table = new Table($search, $column, $orderBy);
        $linkHelper = new TableAndPagerLinkHelper($search, $column, $orderBy, $currentPage);
        $pageHelper = new PaginationHelper($currentPage, $countStudent, $limit);
        $notify = isset($_COOKIE['notify']) ? strval($_COOKIE['notify']) : null;
        if ($notify !== null) {
            $this->cookieHelper->deleteCookieToClient('notify', CookieHelper::NOTIFY_LIFETIME);
        }

        $this->view->render('home', array(
            'page' => 'home',
            'user' => $this->user,
            'students' => $students,
            'table' => $table,
            'linkHelper' => $linkHelper,
            'pageHelper' => $pageHelper,
            'notify' => $notify
        ));

    }
}
