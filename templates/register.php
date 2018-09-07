<?php require_once __DIR__ . '/header.php' ?>
<?php /* @var \Students\Entity\Student $user */ ?>
    <div class="nav">
        <a href="/">Вернуться на главную</a>
    </div>
    <div class="container">
        <div class="row">
            <?php if ($user === null): ?>
                <h1>Регистрация</h1>
            <?php else: ?>
                <h1>Изменение данных о себе</h1>
            <?php endif; ?>
        </div>
        <form action="/register" method="POST">
            <div class="form-group">
                <label for="firstName">Имя</label>
                <input type="text" class="form-control" id="firstName" name="firstName"
                       minlength="1"
                       maxlength="60"
                       pattern="[А-ЯЁа-яё\s'-]+|[A-Za-z\s'-]+"
                       title="Имя должно состоять из кириллических или латинских символов и может содержать дефис, апостроф, пробел"
                    <?php if ($user !== null): ?>
                        value="<?= $this->html($user->getFirstName()) ?>"
                    <?php endif; ?>
                       required
                >
                <span class="text-danger">
                <?php if (isset($errors['firstName'])): ?><?= $this->html($errors['firstName']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <label for="lastName">Фамилия</label>
                <input type="text" class="form-control" id="lastName" name="lastName"
                       minlength="1"
                       maxlength="60"
                       pattern="[А-ЯЁа-яё\s'-]+|[A-Za-z\s'-]+"
                       title="Фамилия должна состоять из кириллических или латинских символов и может содержать дефис, апостроф, пробел"
                    <?php if ($user !== null): ?>
                        value="<?= $this->html($user->getLastName()) ?>"
                    <?php endif; ?>
                       required
                >
                <span class="text-danger">
                <?php if (isset($errors['lastName'])): ?><?= $this->html($errors['lastName']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <p><b>Пол</b></p>
                <div class="radio-inline">
                    <label for="male">
                        <input type="radio" id="male" name="gender" value="male" required
                            <?php if ($user !== null && $user->getGender() === 'male'): ?>
                                checked
                            <?php endif; ?>
                        >М
                    </label>
                </div>
                <div class="radio-inline">
                    <label for="female">
                        <input type="radio" id="female" name="gender" value="female" required
                            <?php if ($user !== null && $user->getGender() === 'female'): ?>
                                checked
                            <?php endif; ?>
                        >Ж
                    </label>
                </div>
                <span class="text-danger row">
                <?php if (isset($errors['gender'])): ?><?= $this->html($errors['gender']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <label for="groupNum">Номер группы</label>
                <input type="text" class="form-control" id="groupNum" name="groupNum"
                       minlength="1"
                       maxlength="5"
                       pattern="[А-ЯЁа-яё0-9-]+|[A-Za-z0-9-]+"
                       title="Номер группы должен состоять из кириллических или латинских символов, цифр и может содержать дефис"
                    <?php if ($user !== null): ?>
                        value="<?= $this->html($user->getGroupNum()) ?>"
                    <?php endif; ?>
                       required
                >
                <span class="text-danger">
                <?php if (isset($errors['groupNum'])): ?><?= $this->html($errors['groupNum']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <?php //type="email" work only in Latin ?>
                <input type="text" class="form-control" id="email" name="email"
                       minlength="3"
                       maxlength="120"
                       pattern=".+@.+"
                       title="Адрес электронной почты должен состоять из двух частей, разделённых символом «@». Например: name@example.com"
                    <?php if ($user !== null): ?>
                        value="<?= $this->html($user->getEmail()) ?>"
                    <?php endif; ?>
                       required
                >
                <span class="text-danger">
                <?php if (isset($errors['email'])): ?><?= $this->html($errors['email']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <label for="points">Суммарное число баллов на ЕГЭ</label>
                <input type="number" class="form-control" id="points" name="points"
                       min="0"
                       max="500"
                       pattern="[0-9]+"
                       title="Это поле должно содержать только цифры"
                    <?php if ($user !== null): ?>
                        value="<?= $this->html($user->getPoints()) ?>"
                    <?php endif; ?>
                       required
                >
                <span class="text-danger">
                <?php if (isset($errors['points'])): ?><?= $this->html($errors['points']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <label for="year">Год рождения</label>
                <input type="number" class="form-control" id="year" name="year"
                       min="1970"
                       max="2017"
                       pattern="[0-9]+"
                       title="Это поле должно содержать только цифры"
                    <?php if ($user !== null): ?>
                        value="<?= $this->html($user->getYear()) ?>"
                    <?php endif; ?>
                       required
                >
                <span class="text-danger">
                <?php if (isset($errors['year'])): ?><?= $this->html($errors['year']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <p><b>Проживание</b></p>
                <div class="radio-inline">
                    <label for="resident">
                        <input type="radio" id="resident" name="residence" value="resident" required
                            <?php if ($user !== null && $user->getResidence() === 'resident'): ?>
                                checked
                            <?php endif; ?>
                        >Местный
                    </label>
                </div>
                <div class="radio-inline">
                    <label for="nonresident">
                        <input type="radio" id="nonresident" name="residence" value="nonresident" required
                            <?php if ($user !== null && $user->getResidence() === 'nonresident'): ?>
                                checked
                            <?php endif; ?>
                        >Иногородний
                    </label>
                </div>
                <span class="text-danger row">
                <?php if (isset($errors['residence'])): ?><?= $this->html($errors['residence']) ?><?php endif; ?>
            </span>
            </div>
            <div class="form-group">
                <input type="hidden" name="csrf" value="<?= $this->html($this->getCsrfToken()) ?>">
            </div>
            <div class="text-center submit">
                <button type="submit" name="submit" class="btn btn-primary">Отправить</button>
            </div>
        </form>
    </div>
<?php require_once __DIR__ . '/footer.php' ?>