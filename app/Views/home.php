<?php use Students\Helpers\Util; ?>
<?php extract($params); ?>
<?php if ($isAuth == true): ?>
    <div class="nav">
        <p style="margin-bottom: 0px"> Вы вошли как <?=Util::html($userName)?>
        <a href="/register"> Редактировать</a></p>
        <p><a href="/home?logout=true">Выйти</a></p>
    </div>
<?php elseif ($isAuth == false): ?>
    <div class="nav">
        <a class="nav" href="/register">Регистрация</a>
    </div>
<?php endif; ?>
<div class="container">
    <?php if (isset($message['addStudent'])): ?>
        <div class="alert alert-success custom-alert">Данные успешно добавлены</div>
    <?php elseif (isset($message['editStudent'])): ?>
        <div class="alert alert-success custom-alert">Данные успешно изменены</div>
    <?php endif; ?>
    <div class="row">
        <h1 class="col-lg-5 col-md-6 col-sm-7" style="margin-left: -15px">Список абитуриентов</h1>
        <form class="navbar-form navbar-right search" role="search" method="GET" action="">
            <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <input type="search" name="search" class="form-control" placeholder="Поиск">
            </div>
            <button type="submit" class="btn btn-default col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </form>
    </div>
    <?php if($search != NULL): ?>
        <div class="row">
            <?php if ($countStudent > 0): ?>
                <p>Показаны только абитуриенты, найденные по запросу &laquo<?=Util::html($search)?>&raquo <a href="home">
                        Показать всех абитуриентов</a></p>
            <?php elseif ($countStudent < 1): ?>
                <p>По запросу &laquo<?=Util::html($search)?>&raquo не было найдено студентов<a href="home">
                        Показать всех абитуриентов</a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-default">
            <tr>
                <th><a href="<?=Util::html($urlGenerator->generateSortUrl('firstname'))?>">
                        Имя <?=Util::html(Util::sort('firstname', array($column, $orderBy)))?></a></th>
                <th><a href="<?=Util::html($urlGenerator->generateSortUrl('lastname'))?>">
                        Фамилия <?=Util::html(Util::sort('lastname', array($column, $orderBy)))?></a></th>
                <th><a href="<?=Util::html($urlGenerator->generateSortUrl('groupNum'))?>">
                        Номер группы <?=Util::html(Util::sort('groupNum', array($column, $orderBy)))?></a></th>
                <th><a href="<?=Util::html($urlGenerator->generateSortUrl('points'))?>">
                        Баллы <?=Util::html(Util::sort('points', array($column, $orderBy)))?></a></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $key => $value): ?>
                <tr>
                    <td class="col-lg-2 col-md-3 col-sm-3 col-xs-3"><?=Util::highlight($search, Util::html($value['firstname']))?></td>
                    <td class="col-lg-2 col-md-3 col-sm-3 col-xs-3"><?=Util::highlight($search, Util::html($value['lastname']))?></td>
                    <td class="col-lg-2 col-md-3 col-sm-2 col-xs-2"><?=Util::highlight($search, Util::html($value['groupNum']))?></td>
                    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?=Util::highlight($search, Util::html($value['points']))?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination">
            <?php if($currentPage > 1): ?>
                <li class="page-item"><a class="page-link"
                    href="<?=Util::html($urlGenerator->generatePageUrl($currentPage - 1))?>">Предыдущая
                </a></li>
            <?php else: ?>
                <li class="page-item disabled"><a class="page-link">Предыдущая</a></li>
            <?php endif; ?>


            <?php $leftPage = 2; ?>
            <?php $rightPage = 2; ?>
            <?php if($currentPage + 1 >= $countPage): ?>
                <?php $leftPage++; ?>
            <?php endif; ?>
            <?php if($currentPage == $countPage): ?>
                <?php $leftPage++; ?>
            <?php endif; ?>

            <?php while($leftPage > 0): ?>
                <?php if($currentPage - $leftPage > 0): ?>
                    <li class="page-item"><a class="page-link"
                        href="<?=Util::html($urlGenerator->generatePageUrl($currentPage - $leftPage))?>">
                            <?=Util::html($currentPage - $leftPage)?>
                    </a></li>
                <?php else: ?>
                    <?php $rightPage++; ?>
                <?php endif; ?>
                <?php $leftPage--; ?>
            <?php endwhile; ?>

            <?php if ($currentPage < 1): ?><?php $currentPage = 1; ?><?php endif; ?>
            <li class="page-item active"><a class="page-link"
                href="<?=Util::html($urlGenerator->generatePageUrl($currentPage))?>">
                    <?=Util::html($currentPage)?>
            </a></li>


            <?php $i = 1; ?>
            <?php while($i <= $rightPage): ?>
                <?php if($currentPage + $i <= $countPage): ?>
                    <li class="page-item"><a class="page-link"
                        href="<?=Util::html($urlGenerator->generatePageUrl($currentPage + $i))?>">
                            <?=Util::html($currentPage + $i)?>
                    </a></li>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endwhile; ?>

            <?php if($currentPage != $countPage && $countPage > 1): ?>
                <li class="page-item"><a class="page-link"
                    href="<?=Util::html($urlGenerator->generatePageUrl($currentPage + 1))?>">Следующая
                </a></li>
            <?php else: ?>
                <li class="page-item disabled"><a class="page-link">Следующая</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
