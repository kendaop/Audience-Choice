<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Ballot;
use Tests\Browser\Pages\Vote;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group login
     */
    public function test_Login_ValidAccessCode_RedirectedToBallot()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)->on(new Ballot);
        });
    }

    /**
     * @group login
     */
    public function test_Login_ValidAccessCode_CanSeeCategoryHeadings()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)->on(new Ballot)->assertVisible('categoryHeadings');
        });
    }

    /**
     * @group login
     */
    public function test_Login_InvalidAccessCode_RedirectedToVote()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, 'BAD_ACCESS_CODE')->on(new Vote);
        });
    }
}
