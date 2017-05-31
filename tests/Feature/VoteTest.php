<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VoteTest extends VotingAppTest
{
    use DatabaseMigrations;

    public function test_GET_Vote_200()
    {
        $this->get('vote')->assertStatus(200);
    }

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

    public function test_GET_Vote_FirstLoad_NoExceptionMessageShown()
    {
        $this->get('vote')
            ->assertDontSee('bg-danger');
    }
}
