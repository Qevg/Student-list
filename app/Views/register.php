<?php use Students\Helpers\Util; ?>
<?php extract($params); ?>
<div class="nav">
    <a href="/home">Вернуться на главную</a>
</div>
<div class="container">
    <div class="row">
        <?php if ($isAuth == false): ?>
            <h1>Регистрация</h1>
        <?php elseif ($isAuth == true): ?>
            <h1>Изменение данных о себе</h1>
        <?php endif; ?>
    </div>
    <form action="" method="POST">
        <div class="form-group">
            <label for="firstname" class="">Имя</label>
            <input type="text" class="form-control" id="firstname" name="firstname"
                   value="<?= Util::html($userData['firstname']) ?>"
                   minlength="<?= Util::html($studentValidator->getMin('firstname')) ?>"
                   maxlength="<?= Util::html($studentValidator->getMax('firstname')) ?>"
                   pattern="<?= Util::html($studentValidator->getRegexpForClient('firstname')) ?>"
                   title="<?= Util::html($studentValidator->getMessage('firstname')) ?>"
                   required
                <?php if (count($error) == 0): ?> autofocus <?php endif; ?>
                <?php if (isset($error['firstname'])): ?> autofocus <?php endif; ?>
            >
            <span class="text-danger">
                <?php if (isset($error['firstname'])): ?> <?= Util::html($error['firstname']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="lastname">Фамилия</label>
            <input type="text" class="form-control" id="lastname" name="lastname"
                   value="<?= Util::html($userData['lastname']) ?>"
                   minlength="<?= Util::html($studentValidator->getMin('lastname')) ?>"
                   maxlength="<?= Util::html($studentValidator->getMax('lastname')) ?>"
                   pattern="<?= Util::html($studentValidator->getRegexpForClient('lastname')) ?>"
                   title="<?= Util::html($studentValidator->getMessage('lastname')) ?>"
                   required
                <?php if (isset($error['lastname'])): ?> autofocus <?php endif; ?>
            >
            <span class="text-danger">
                <?php if (isset($error['lastname'])): ?> <?= Util::html($error['lastname']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <p><b>Пол</b></p>
            <div class="radio-inline">
                <label for="male">
                    <input type="radio" id="male" name="gender" value="male" required
                        <?php if (isset($userData['gender']) && $userData['gender'] == 'male'): ?>
                            checked
                        <?php endif; ?>
                    >М
                </label>
            </div>
            <div class="radio-inline">
                <label for="female">
                    <input type="radio" id="female" name="gender" value="female" required
                        <?php if (isset($userData['gender']) && $userData['gender'] == 'female'): ?>
                            checked
                        <?php endif; ?>
                    >Ж
                </label>
            </div>
            <span class="text-danger row">
                <?php if (isset($error['gender'])): ?> <?= Util::html($error['gender']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="groupNum">Номер группы</label>
            <input type="text" class="form-control" id="groupNum" name="groupNum"
                   value="<?= Util::html($userData['groupNum']) ?>"
                   minlength="<?= Util::html($studentValidator->getMin('groupNum')) ?>"
                   maxlength="<?= Util::html($studentValidator->getMax('groupNum')) ?>"
                   pattern="<?= Util::html($studentValidator->getRegexpForClient('groupNum')) ?>"
                   title="<?= Util::html($studentValidator->getMessage('groupNum')) ?>" required
                <?php if (isset($error['groupNum'])): ?> autofocus <?php endif; ?>
            >
            <span class="text-danger">
                <?php if (isset($error['groupNum'])): ?> <?= Util::html($error['groupNum']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <?php //type="email" work only in Latin?>
            <input type="text" class="form-control" id="email" name="email"
                   value="<?= Util::html($userData['email']) ?>"
                   minlength="<?= Util::html($studentValidator->getMin('email')) ?>"
                   maxlength="<?= Util::html($studentValidator->getMax('email')) ?>"
                   pattern="<?= Util::html($studentValidator->getRegexpForClient('email')) ?>"
                   title="<?= Util::html($studentValidator->getMessage('email')) ?>" required
                <?php if (isset($error['email'])): ?> autofocus <?php endif; ?>
            >
            <span class="text-danger">
                <?php if (isset($error['email'])): ?> <?= Util::html($error['email']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="points">Суммарное число баллов на ЕГЭ</label>
            <input type="number" class="form-control" id="points" name="points"
                   value="<?= Util::html($userData['points']) ?>"
                   min="<?= Util::html($studentValidator->getMin('points')) ?>"
                   max="<?= Util::html($studentValidator->getMax('points')) ?>"
                   pattern="<?= Util::html($studentValidator->getRegexpForClient('points')) ?>"
                   title="<?= Util::html($studentValidator->getMessage('points')) ?>" required
                <?php if (isset($error['points'])): ?> autofocus <?php endif; ?>
            >
            <span class="text-danger">
                <?php if (isset($error['points'])): ?> <?= Util::html($error['points']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="year">Год рождения</label>
            <input type="number" class="form-control" id="year" name="year"
                   value="<?= Util::html($userData['year']) ?>"
                   min="<?= Util::html($studentValidator->getMin('year')) ?>"
                   max="<?= Util::html($studentValidator->getMax('year')) ?>"
                   pattern="<?= Util::html($studentValidator->getRegexpForClient('year')) ?>"
                   title="<?= Util::html($studentValidator->getMessage('year')) ?>"
                   required
                <?php if (isset($error['year'])): ?> autofocus <?php endif; ?>
            >
            <span class="text-danger">
                <?php if (isset($error['year'])): ?> <?= Util::html($error['year']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <p><b>Проживание</b></p>
            <div class="radio-inline">
                <label for="resident">
                    <input type="radio" id="resident" name="residence" value="resident" required
                        <?php if (isset($userData['residence']) && $userData['residence'] == 'resident'): ?>
                            checked
                        <?php endif; ?>
                    >Местный
                </label>
            </div>
            <div class="radio-inline">
                <label for="nonresident">
                    <input type="radio" id="nonresident" name="residence" value="nonresident" required
                        <?php if (isset($userData['residence']) && $userData['residence'] == 'nonresident'): ?>
                            checked
                        <?php endif; ?>
                    >Иногородний
                </label>
            </div>
            <span class="text-danger row">
                <?php if (isset($error['residence'])): ?> <?= Util::html($error['residence']) ?><?php endif; ?>
            </span>
        </div>
        <div class="form-group">
            <input type="hidden" name="token" value="<?= Util::html($token) ?>">
        </div>
        <div class="text-center submit">
            <?php if ($isAuth == false): ?>
                <button type="submit" class="btn btn-primary">Отправить</button>
            <?php elseif ($isAuth == true): ?>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            <?php endif; ?>
        </div>
    </form>
</div>