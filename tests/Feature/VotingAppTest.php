<?php

namespace Tests\Feature;

use App\AccessCode;
use App\Category;
use App\Film;
use App\Tag;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Session;

class VotingAppTest extends TestCase
{
    protected $category, $film, $tags, $accessCode, $voteElem;

    const DEFAULT_TAG_IDS = [1, 2, 6, 8];

    public function setUp()
    {
        parent::setUp();
        Session::start();

        $this->defaultDbSetup();
        $this->retrieveDefaultProperties();
    }

    protected function followRedirect(TestResponse $response)
    {
        if($response->isRedirect()) {
            return $this->get($response->headers->get('Location'));
        }
        throw new \Exception('Not a redirect.');
    }

    protected function defaultDbSetup()
    {
        Artisan::call('db:seed');
    }

    protected function retrieveDefaultProperties()
    {
        $this->category = Category::find(config('vote.test.default.categoryId'));
        $this->film = Film::find(config('vote.test.default.filmId'));
        $this->tags = Tag::find(config('vote.test.default.tagId'));
        $this->accessCode = AccessCode::find(config('vote.test.default.accessCodeId'));
        $this->voteElem = "category-{$this->category->id}-radios";
    }
}
