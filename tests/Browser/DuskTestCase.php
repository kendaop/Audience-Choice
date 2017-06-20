<?php

namespace Tests;

use App\AccessCode;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Vote;

abstract class DuskTestCase extends BaseTestCase
{
    protected $accessCode;

    use CreatesApplication;
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        self::seedDatabase();
        $this->retrieveDefaultProperties();
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    protected static function seedDatabase()
    {
        Artisan::call('db:seed');
    }

    protected function retrieveDefaultProperties()
    {
        $this->accessCode = AccessCode::find(config('vote.test.default.accessCodeId'));
    }

    protected function logIn(Browser $browser, $accessCode)
    {
        return $browser->visit(new Vote)
            ->type('accessCode', $accessCode)
            ->click('submitButton');
    }
}
