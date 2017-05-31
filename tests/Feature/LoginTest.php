<?php

namespace Tests\Feature;

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
    public function test_Login_InvalidCsrfToken_RedirectedToVoteWithMessage()
    {
        $response = $this->post('login', [
            '_token' => 'BAD' . csrf_token(),
            'accessCode' => $this->accessCode->code
        ]);

        $this->followRedirect($response)->assertSeeText(config('vote.messages.invalidSession'));
    }

    protected function followRedirect(TestResponse $response)
    {
        if($response->isRedirect()) {
            return $this->get($response->headers->get('Location'));
        }
        throw new \Exception('Not a redirect.');
    }
}
