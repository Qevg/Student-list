<?php

class RegistrationPageCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function testSuccessfulRegistration(AcceptanceTester $I)
    {
        $I->wantTo('Test that registration works');
        $I->amOnPage('/register');
        $I->fillField('firstName', 'test');
        $I->fillField('lastName', 'test');
        $I->selectOption('form input[name=gender]', 'male');
        $I->fillField('groupNum', 'test');
        $I->fillField('email', 'test-registration@example.com');
        $I->fillField('points', 200);
        $I->fillField('year', 2000);
        $I->selectOption('form input[name=residence]', 'resident');
        $I->click('submit');
        $I->seeInCurrentUrl('/');
        $I->see('Данные успешно добавлены');
        $I->seeInDatabase('students', ['email' => 'test-registration@example.com']);
    }

    public function testUnsuccessfulRegistration(AcceptanceTester $I)
    {
        $I->wantTo('Test registration, if email is not unique');
        $I->amOnPage('/register');
        $I->fillField('firstName', 'test');
        $I->fillField('lastName', 'test');
        $I->selectOption('form input[name=gender]', 'male');
        $I->fillField('groupNum', 'test');
        $I->fillField('email', 'test@example.com');
        $I->fillField('points', 200);
        $I->fillField('year', 2000);
        $I->selectOption('form input[name=residence]', 'resident');
        $I->click('submit');
        $I->see('Этот email уже используется');
    }

    public function testUpdateDataStudent(AcceptanceTester $I)
    {
        $I->wantTo('Test that update data student works');
        $I->setCookie('auth', '4f0633b7cb2va6b0a743fbb50a220de2');
        $I->amOnPage('/register');
        $I->fillField('firstName', 'update-name');
        $I->click('submit');
        $I->seeInCurrentUrl('/');
        $I->see('Данные успешно изменены');
        $I->seeInDatabase('students', ['firstName' => 'update-name', 'email' => 'test@example.com']);
    }
}
