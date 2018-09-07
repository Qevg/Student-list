<?php require_once __DIR__ . '/header.php' ?>
<?php
/* @var \Students\Entity\Student $user */
/* @var \Students\Helpers\PaginationHelper $pageHelper */
/* @var \Students\Helpers\TableAndPagerLinkHelper $linkHelper */
/* @var \Students\Entity\Table $table */
?>
<?php if ($user === null): ?>
    <div class="nav">
        <a class="nav" href="/register">Регистрация</a>
    </div>
<?php else: ?>
    <div class="nav">
        <p class="nav-login"> Вы вошли как <?= $this->html($user->getFirstName() .' '. $user->getLastName()) ?>
            <a href="/register"> Редактировать</a>
        </p>
        <form action="/logout" method="post">
            <input type="hidden" name="csrf" value="<?= $this->html($this->getCsrfToken()) ?>">
            <button type="submit" name="logout" class="btn btn-link btn-log-out">Выйти</button>
        </form>
    </div>
<?php endif; ?>
<div class="container">
    <?php if ($notify === 'registered'): ?>
        <div id="notify-registered" class="alert alert-success" role="alert">
            <button type="button" class="close" aria-label="Close" onclick="document.getElementById('notify-registered').remove()"><span aria-hidden="true">&times;</span></button>
            Данные успешно добавлены
        </div>
    <?php elseif ($notify === 'updated'): ?>
        <div id="notify-updated" class="alert alert-success" role="alert">
            <button type="button" class="close" aria-label="Close" onclick="document.getElementById('notify-updated').remove()"><span aria-hidden="true">&times;</span></button>
            Данные успешно изменены
        </div>
    <?php endif; ?>
    <div class="row">
        <h1 class="student-list-heading col-lg-5 col-md-6 col-sm-7">Список абитуриентов</h1>
        <form class="navbar-form navbar-right search" role="search" method="GET" action="/">
            <div class="form-group col-xs-10">
                <input type="search" name="search" class="form-control" placeholder="Поиск">
            </div>
            <button type="submit" name="submit-search" class="btn btn-default col-xs-2">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </form>
    </div>
    <?php if (!empty($table->getSearch())): ?>
        <div class="row">
            <?php if (!empty($students)): ?>
                <p>Показаны только абитуриенты, найденные по запросу &laquo;<?= $this->html($table->getSearch()) ?>&raquo;<a href="/">
                        Показать всех абитуриентов</a></p>
            <?php else: ?>
                <p>По запросу &laquo;<?= $this->html($table->getSearch()) ?>&raquo; не было найдено студентов<a href="/">
                        Показать всех абитуриентов</a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-default">
            <tr>
                <th><a href="<?= $this->html($linkHelper->generateSortUrl('firstName')) ?>">
                        Имя <?= $this->html($table->showSortOrder('firstName')) ?></a></th>
                <th><a href="<?= $this->html($linkHelper->generateSortUrl('lastName')) ?>">
                        Фамилия <?= $this->html($table->showSortOrder('lastName')) ?></a></th>
                <th><a href="<?= $this->html($linkHelper->generateSortUrl('groupNum')) ?>">
                        Номер группы <?= $this->html($table->showSortOrder('groupNum')) ?></a></th>
                <th><a href="<?= $this->html($linkHelper->generateSortUrl('points')) ?>">
                        Баллы <?= $this->html($table->showSortOrder('points')) ?></a></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $key => $value): ?>
                <tr>
                    <td>
                        <?= $table->highlight($this->html($value->getFirstName())) ?></td>
                    <td>
                        <?= $table->highlight($this->html($value->getLastName())) ?></td>
                    <td>
                        <?= $table->highlight($this->html($value->getGroupNum())) ?></td>
                    <td>
                        <?= $table->highlight($this->html($value->getPoints())) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination">
            <?php if ($pageHelper->getPreviousPage() !== null): ?>
                <li class="page-item"><a class="page-link" href="<?= $this->html($linkHelper->generatePageUrl($pageHelper->getPreviousPage())) ?>">Предыдущая</a></li>
            <?php else: ?>
                <li class="page-item disabled"><a class="page-link">Предыдущая</a></li>
            <?php endif; ?>

            <?php foreach ($pageHelper->generatePageNumbers() as $number): ?>
                <?php if ($number === $pageHelper->getCurrentPage()): ?>
                    <li class="page-item active"><a class="page-link" href="<?= $this->html($linkHelper->generatePageUrl($number)) ?>"><?= $this->html($number) ?></a></li>
                <?php else: ?>
                    <li class="page-item"><a class="page-link" href="<?= $this->html($linkHelper->generatePageUrl($number)) ?>"><?= $this->html($number) ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($pageHelper->getNextPage() !== null): ?>
                <li class="page-item"><a class="page-link" href="<?= $this->html($linkHelper->generatePageUrl($pageHelper->getNextPage())) ?>">Следующая</a></li>
            <?php else: ?>
                <li class="page-item disabled"><a class="page-link">Следующая</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<?php require_once __DIR__ . '/footer.php' ?>