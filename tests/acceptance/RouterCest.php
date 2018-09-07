<?php

class RouterCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function testPageNotFound(AcceptanceTester $I)
    {
        $I->amOnPage('/qwerty');
        $I->seePageNotFound();
    }
}
