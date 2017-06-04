<?php

namespace Tests\Browser;

use Tests\Browser\Pages\Ballot;
use Tests\Browser\Pages\Vote;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->retrieveDefaultProperties();
    }

    public function test_Login_ValidAccessCode_RedirectedToBallot()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)->on(new Ballot);
        });
    }

    public function test_Login_ValidAccessCode_CanSeeCategoryHeadings()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)->on(new Ballot)->assertVisible('categoryHeadings');
        });
    }

    public function test_Login_InvalidAccessCode_RedirectedToVote()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, 'BAD_ACCESS_CODE')->on(new Vote);
        });
    }

    protected function logIn(Browser $browser, $accessCode)
    {
        return $browser->visit(new Vote)
            ->type('accessCode', $accessCode)
            ->click('submitButton');
    }
}
