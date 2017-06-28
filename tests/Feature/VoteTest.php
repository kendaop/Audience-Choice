<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VoteTest extends VotingAppTest
{
    use DatabaseMigrations;

    /**
     * @group vote
     */
    public function test_GET_Vote_200()
    {
        $this->get('vote')->assertStatus(200);
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_ExceptionMessagePassed_ExceptionMessageDisplayed()
    {
        $message = 'Something bad happened';

        $this->withSession([
            'message' => $message,
            'messageType' => 'exception'
        ])
            ->get('vote')
            ->assertSeeText($message)
            ->assertSee('alert alert-danger');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_FirstLoad_NoExceptionOrSuccessMessageShown()
    {
        $this->get('vote')
            ->assertDontSee('alert alert-danger')
            ->assertDontSee('alert alert-success');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_FirstLoad_WelcomeMessageDisplayed()
    {
        $this->get('vote')
            ->assertSeeText(config('vote.messages.welcome'))
            ->assertSee('alert alert-warning');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_MainLogoExists_ImageDisplayed()
    {
        $assetPath = 'img/posters/1.jpg';

        config(['vote.branding.logo' => $assetPath]);

        $this->get('vote')->assertSee('img class="img-responsive" src="' . asset($assetPath) . '"');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_SuccessMessagePassed_SuccessMessageDisplayed()
    {
        $message = 'Success!';

        $this->withSession([
            'message' => $message,
            'messageType' => 'success'
        ])
            ->get('vote')
            ->assertSeeText($message)
            ->assertSee('alert alert-success');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_SuccessMessagePassed_NoWelcomeMessageDisplayed()
    {
        $message = 'Success!';

        $this->withSession([
            'message' => $message,
            'messageType' => 'success'
        ])
            ->get('vote')
            ->assertDontSeeText(config('vote.messages.welcome'));
    }
}
