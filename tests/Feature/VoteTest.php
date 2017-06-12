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
            ->assertSeeText($message);
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_FirstLoad_NoExceptionMessageShown()
    {
        $this->get('vote')
            ->assertDontSee('bg-danger');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_MainLogoExists_ImageDisplayed()
    {
        $assetPath = 'img/manos-poster.jpg';

        config(['vote.branding.logo' => $assetPath]);

        $this->get('vote')->assertSee('img class="img-responsive" src="' . asset($assetPath) . '"');
    }

    /**
     * @group vote
     */
    public function test_GET_Vote_MainLogoDoesNotExist_NoImageDisplayed()
    {
        $assetPath = 'img/NON-EXISTENT.jpg';

        config(['vote.branding.logo' => $assetPath]);

        $this->get('vote')->assertDontSee(asset($assetPath));
    }
}
