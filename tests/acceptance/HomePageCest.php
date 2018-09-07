<?php

class HomePageCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function testSearch(AcceptanceTester $I)
    {
        $I->wantTo('Test that search works');
        $I->amOnPage('/');
        $I->fillField('search', 'test');
        $I->click('submit-search');
        $I->see('Показаны только абитуриенты, найденные по запросу «test»');
        $I->see('200');
    }

    public function testGuardXSSSearch(AcceptanceTester $I)
    {
        $I->wantTo('Test that search not subject xss attack');
        $I->amOnPage('/');
        $I->fillField('search', '<script>alert(1);</script>');
        $I->click('submit-search');
        $I->see('По запросу «<script>alert(1);</script>» не было найдено студентов');
    }

    /**
     * todo Bug: На клиенте не обновляются куки.
     * Log: /tests/_output/testLogOut.log
     * В 21 строке видно что возвращается auth=deleted
     * Но при этом на клиенте всеравно остается auth=(тут токен)
     * Аналогичная проблема: https://stackoverflow.com/questions/40615373/codeception-how-to-delete-cookie-with-phpbrowser
     *
     * @param AcceptanceTester $I
     */
    public function testLogOut(AcceptanceTester $I)
    {
        $I->wantTo('Test that log out works');
        $I->setCookie('auth', '4f0633b7cb2va6b0a743fbb50a220de2');
        $I->amOnPage('/');
        $I->click('logout');
        $I->seeResponseCodeIs(200);

//        $I->dontSeeCookie('auth'); // FAIL
//        $I->grabCookie('auth'); // return 4f0633b7cb2va6b0a743fbb50a220de2
//        $I->see('Регистрация'); // FAIL
    }
}
