<?php

namespace Tests\Feature;

use App\LoginAttempt;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;

class LoginTest extends VotingAppTest
{
    use DatabaseMigrations;

    protected $accessCode;

    /**
     * @group login
     */
    public function test_POST_Login_WrongAccessCode_RedirectedToVote()
    {
        $request = $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => 'BAD'
        ]);

        $request->assertRedirect('vote');
    }

    /**
     * @group login
     */
    public function test_POST_Login_CorrectAccessCodeAndCsrfToken_RedirectedToBallot()
    {
        $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => $this->accessCode->code
        ])->assertRedirect('ballot');
    }

    /**
     * @group login
     */
    public function test_POST_Login_WrongCsrfToken_RedirectedtoVote()
    {
        $this->markTestSkipped('CSRF token verification is not enabled during tests.');

        $this->post('login', [
            '_token' => (csrf_token() . 'BAD'),
            'accessCode' => $this->accessCode->code
        ])->assertRedirect('vote');
    }

    /**
     * @group login
     */
    public function test_POST_Login_WrongAccessCodeAndCsrfToken_RedirectedtoVote()
    {
        $this->post('login', [
            '_token' => (csrf_token() . 'BAD'),
            'accessCode' => 'BAD'
        ])->assertRedirect('vote');
    }

    /**
     * @group login
     */
    public function test_Login_InvalidAccessCode_RedirectedToVoteWithMessage()
    {
        $response = $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => 'BAD'
        ]);

        $this->followRedirect($response)->assertStatus(200)->assertSeeText(config('vote.messages.invalidAccessCode'));
    }

    /**
     * @group login
     */
    public function test_Login_ValidAccessCodeAfterManyFailedAttempts_RedirectedToVote()
    {
        $loginAttempt = new LoginAttempt;
        $loginAttempt->attempts = config('vote.app.maxLoginAttempts');
        $loginAttempt->ip_address = '127.0.0.1';
        $loginAttempt->save();

        $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => $this->accessCode->code
        ])->assertRedirect('vote');
    }

    /**
     * @group login
     */
    public function test_Login_ManyFailedAttempts_RedirectedWithMessage()
    {
        $loginAttempt = new LoginAttempt;
        $loginAttempt->attempts = config('vote.app.maxLoginAttempts');
        $loginAttempt->ip_address = '127.0.0.1';
        $loginAttempt->save();

        $response = $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => $this->accessCode->code
        ]);

        $this->followRedirect($response)->assertStatus(200)->assertSeeText(config('vote.messages.rateLimited'));
    }

    /**
     * @group login
     */
    public function test_Login_ValidAccessCodeAndLockoutTimeExpired_RedirectedToBallot()
    {
        $loginAttempt = new LoginAttempt;
        $loginAttempt->attempts = config('vote.app.maxLoginAttempts');
        $loginAttempt->ip_address = '127.0.0.1';
        $loginAttempt->setUpdatedAt(Carbon::now()->subSeconds(config('vote.app.lockoutLength') + 1));
        $loginAttempt->save();

        $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => $this->accessCode->code
        ])->assertRedirect('ballot');
    }

    /**
     * @group login
     */
    public function test_Login_FirstFailedAttempt_IpAddressSavedInDb()
    {
        $this->assertEquals(0, LoginAttempt::all()->count());

        $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => 'BAD'
        ]);

        $this->assertEquals(1, LoginAttempt::all()->count());
    }

    /**
     * @group login
     */
    public function test_Login_AnotherFailedAttempt_AttemptsIncremented()
    {
        $loginAttempt = new LoginAttempt;
        $loginAttempt->attempts = 1;
        $loginAttempt->ip_address = '127.0.0.1';
        $loginAttempt->save();

        $this->assertEquals(0, LoginAttempt::where('attempts', 2)->count());

        $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => 'BAD'
        ]);

        $this->assertEquals(1, LoginAttempt::where('attempts', 2)->count());
    }

    /**
     * @group login
     */
    public function test_Login_LockoutTimeExpired_AttemptsReset()
    {
        $loginAttempt = new LoginAttempt;
        $loginAttempt->attempts = config('vote.app.maxLoginAttempts');
        $loginAttempt->ip_address = '127.0.0.1';
        $loginAttempt->save();

        $this->assertEquals(1, LoginAttempt::where('attempts', config('vote.app.maxLoginAttempts'))->count());

        $this->post('login', [
            '_token' => csrf_token(),
            'accessCode' => $this->accessCode->code
        ]);

        $this->assertEquals(0, LoginAttempt::where('attempts', config('vote.app.maxLoginAttempts'))->count());
    }

    protected function followRedirect(TestResponse $response)
    {
        if($response->isRedirect()) {
            return $this->get($response->headers->get('Location'));
        }
        throw new \Exception('Not a redirect.');
    }
}
