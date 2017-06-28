<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CloudfrontTest extends VotingAppTest
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        config([
            'services.cloudfront.method' => 'http',
            'services.cloudfront.hostname' => 'cloudfront.net',
            'vote.branding.logo' => 'img/logo.png'
        ]);
    }

    /**
     * @group cloudfront
     */
    public function test_Vote_CloudfrontEnabled_LogoUrlFromCloudfront()
    {
        config(['services.cloudfront.enabled' => true]);

        $this->get('vote')
            ->assertSee('<img class="img-responsive" src="http://cloudfront.net/img/logo.png"/>');
    }

    /**
     * @group cloudfront
     */
    public function test_Vote_CloudfrontDisabled_LogoUrlFromPublicDirectory()
    {
        config(['services.cloudfront.enabled' => false]);

        $this->get('vote')
            ->assertSee('<img class="img-responsive" src="' . config('app.url') . '/img/logo.png"/>');
    }
}
