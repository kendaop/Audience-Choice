<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Ballot;

class BallotTest extends DuskTestCase
{
    use DatabaseMigrations;

    const CATEGORY_SELECTOR_ONE = 'div#heading-1 a.category span.glyphicon-chevron-down';
    const CATEGORY_SELECTOR_TWO = 'div#heading-2 a.category span.glyphicon-chevron-down';
    const FILM_SELECTOR_ONE = 'a[aria-controls="film-collapse-1-1"] span.glyphicon-menu-down';
    const FILM_SELECTOR_TWO = 'a[aria-controls="film-collapse-1-2"] span.glyphicon-menu-down';
    const CATEGORY_GROUP_SELECTOR_ONE = 'div#collapse-1';
    const CATEGORY_GROUP_SELECTOR_TWO = 'div#collapse-2';
    const FILM_INFO_SELECTOR_ONE = 'div#film-collapse-1-1';
    const FILM_INFO_SELECTOR_TWO = 'div#film-collapse-1-2';

    /**
     * @group ballot
     */
    public function test_Ballot_ClickOnCategory_FilmHeadersDisplayed()
    {
        $this->browse(function(Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)
                ->on(new Ballot)
                ->click(self::CATEGORY_SELECTOR_ONE)
                ->assertVisible('div#collapse-1');
        });
    }

    /**
     * @group ballot
     */
    public function test_Ballot_ClickOnFilm_FilmInfoDisplayed()
    {
        $this->browse(function(Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)
                ->on(new Ballot)
                ->click(self::CATEGORY_SELECTOR_ONE)
                ->click(self::FILM_SELECTOR_ONE)
                ->assertVisible(self::FILM_INFO_SELECTOR_ONE);
        });
    }

    /**
     * @group ballot
     */
    public function test_Ballot_ClickOnCategoryThenAnother_NewFilmHeadersDisplayed()
    {
        $this->browse(function(Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)
                ->on(new Ballot)
                ->click(self::CATEGORY_SELECTOR_ONE)
                ->pause(300)
                ->click(self::CATEGORY_SELECTOR_TWO)
                ->pause(300)
                ->assertVisible(self::CATEGORY_GROUP_SELECTOR_TWO);
        });
    }

    /**
     * @group ballot
     */
    public function test_Ballot_ClickOnCategoryThenAnother_OriginalFilmHeadersHidden()
    {
        $this->browse(function(Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)
                ->on(new Ballot)
                ->click(self::CATEGORY_SELECTOR_ONE)
                ->pause(300)
                ->click(self::CATEGORY_SELECTOR_TWO)
                ->pause(300)
                ->assertMissing(self::CATEGORY_GROUP_SELECTOR_ONE);
        });
    }

    /**
     * @group ballot
     */
    public function test_Ballot_ClickOnFilmThenAnother_NewFilmInfoDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)
                ->on(new Ballot)
                ->click(self::CATEGORY_SELECTOR_ONE)
                ->click(self::FILM_SELECTOR_ONE)
                ->pause(300)
                ->click(self::FILM_SELECTOR_TWO)
                ->pause(300)
                ->assertVisible(self::FILM_INFO_SELECTOR_TWO);
        });
    }

    /**
     * @group ballot
     */
    public function test_Ballot_ClickOnFilmThenAnother_OriginalFilmInfoHidden()
    {
        $this->browse(function (Browser $browser) {
            $this->logIn($browser, $this->accessCode->code)
                ->on(new Ballot)
                ->click(self::CATEGORY_SELECTOR_ONE)
                ->click(self::FILM_SELECTOR_ONE)
                ->pause(300)
                ->click(self::FILM_SELECTOR_TWO)
                ->pause(300)
                ->assertMissing(self::FILM_INFO_SELECTOR_ONE);
        });
    }
}
