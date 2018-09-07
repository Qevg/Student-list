# Student List

## Used technologies

1. [Twitter Bootstrap]
2. [Pimple] dependency injection container
3. [Codeception] testing PHP framework

## Requirements

1. [PHP] >= 7.1
2. [MySQL]/[MariaDB]
3. [Composer]

## Installation

1. Use the `git clone https://github.com/Qevg/Student-list.git` command to clone the repository
2. Use the `composer install` command to install dependencies
3. Import database `students.sql` on your database
4. Change database settings in `config/config_production.json`
5. Set `public` directory as a document root on your web server

## Tests

1. Set environment to `testing` in the `config/config.json`
2. Create test database for tests
3. Change configuration in the `config/config_testing.json`, `codeception.yml` and `tests/*.suite.yml`

```
$ codecept run
```

## License
This application is licensed under the MIT license. For more information refer to [License file].

[Twitter Bootstrap]: <https://getbootstrap.com/>
[Pimple]: <https://pimple.symfony.com/>
[Codeception]: <https://codeception.com/>
[PHP]: <https://secure.php.net/>
[MySQL]: <https://www.mysql.com/>
[MariaDB]: <https://mariadb.org/>
[Composer]: <https://getcomposer.org/>
[License file]: <https://github.com/Qevg/Student-list/blob/master/LICENSE>