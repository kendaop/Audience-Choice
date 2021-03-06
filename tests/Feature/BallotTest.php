<?php

namespace Tests\Feature;

use App\Category;
use App\Film;
use App\Vote;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BallotTest extends VotingAppTest
{
    use DatabaseMigrations;

    const ALTERNATIVE_ACCESS_CODE_ID = 4;
    const ALTERNATIVE_CATEGORY_ID = 2;
    const ALTERNATIVE_FILM_ID = 6;

    /**
     * @group ballot
     */
    public function test_GET_Ballot_SquashedCategories_AllFilmNamesReferenceCategory0()
    {
        $this->squashedDbSetup();

        $this->withSession(['accessCodeId' => 1])
            ->get('ballot')
            ->assertSee('name="category-0-radios"')
            ->assertDontSee('name="category-1-radios"');
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_NoAccessCodeInSession_RedirectedToVote()
    {
        $this->get('ballot')->assertRedirect('vote');
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_AccessCodeInSession_200()
    {
        $this->withSession(['accessCodeId' => $this->accessCode->id])
            ->get('ballot')
            ->assertStatus(200);
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_AllCategory_PopulatedWithAllFilms()
    {
        $response = $this->withSession([
            'accessCodeId' => config('vote.test.allCategory.accessCodeId')
        ])->get('ballot');

        Category::all()->each(function($category) use ($response) {
            $category->getFilms()->each(function($film) use ($response) {
                $response->assertSeeText(htmlentities($film->title, ENT_QUOTES));
            });
        });
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_UnsquashedCategories_AllCategoriesForAccessCodeAreVisible()
    {
        $response = $this->withSession(['accessCodeId' => $this->accessCode->id])->get('ballot');

        Category::all()->each(function($category) use ($response) {
            $response->assertSeeText($category->name);
        });
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_SquashedCategories_AllCategoriesForAccessCodeAreVisible()
    {
        $this->squashedDbSetup();

        $response = $this->withSession(['accessCodeId' => $this->accessCode->id])->get('ballot');

        Category::all()->each(function($category) use ($response) {
            if($category->name !== 'Squashed') {
                $response->assertSeeText($category->name);
            }
        });
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_FilmHasSquashedVote_InputIsAlreadyChecked()
    {
        $this->squashedDbSetup();

        $vote = new Vote;
        $vote->film_id = $this->film->id;
        $vote->category_id = 0;
        $vote->access_code_id = $this->accessCode->id;
        $vote->save();

        $this->withSession(['accessCodeId' => $this->accessCode->id])
            ->get('ballot')
            ->assertSee('input type="radio" name="category-0-radios" value="' . $this->film->id . '" checked');
    }

    /**
     * @group ballot
     */
    public function test_GET_Ballot_FilmHasVote_InputIsAlreadyChecked()
    {
        $vote = new Vote;
        $vote->film_id = $this->film->id;
        $vote->category_id = $this->category->id;
        $vote->access_code_id = $this->accessCode->id;
        $vote->save();

        $this->withSession(['accessCodeId' => $this->accessCode->id])
            ->get('ballot')
            ->assertSee('input type="radio" name="category-' . $this->category->id . '-radios" value="' . $this->film->id . '" checked');
    }

    /**
     * @group ballot
     */
    public function test_SubmitBallot_NoVoteExists_VoteStoredInDb()
    {
        $this->post('submitBallot', [
            '_token'         => csrf_token(),
            $this->voteElem  => $this->film->id,
            'access-code-id' => $this->accessCode->id
        ]);

        $this->assertDatabaseHas('votes', [
            'category_id'    => $this->category->id,
            'film_id'        => $this->film->id,
            'access_code_id' => $this->accessCode->id
        ]);
    }

    /**
     * @group ballot
     */
    public function test_SubmitBallot_NoVoteExists_RedirectedToVote()
    {
        $response = $this->post('submitBallot', [
            '_token'         => csrf_token(),
            $this->voteElem  => $this->film->id,
            'access-code-id' => $this->accessCode->id
        ])->assertRedirect('vote');

        $this->followRedirect($response)->assertStatus(200);
    }

    /**
     * @group ballot
     */
    public function test_SubmitBallot_DuplicateVoteExists_NoChangeInDb()
    {
        $voteCount = $this->insertDefaultVote();

        $this->post('submitBallot', [
            '_token'         => csrf_token(),
            $this->voteElem  => $this->film->id,
            'access-code-id' => $this->accessCode->id
        ]);

        $this->assertDatabaseHas('votes', [
            'category_id'    => $this->category->id,
            'film_id'        => $this->film->id,
            'access_code_id' => $this->accessCode->id
        ]);
        $this->assertCount($voteCount, Vote::all());
    }

    /**
     * @group ballot
     */
    public function test_SubmitBallot_DuplicateVoteExists_RedirectedToVote()
    {
        $this->insertDefaultVote();

        $response = $this->post('submitBallot', [
            '_token'         => csrf_token(),
            $this->voteElem  => $this->film->id,
            'access-code-id' => $this->accessCode->id
        ])->assertRedirect('vote');

        $this->followRedirect($response)->assertStatus(200);
    }

    /**
     * @group ballot
     */
    public function test_SubmitBallot_VoteInSameCategoryExists_VoteUpdated()
    {
        $voteCount = $this->insertDefaultVote();

        $this->post('submitBallot', [
            '_token'         => csrf_token(),
            $this->voteElem  => self::ALTERNATIVE_FILM_ID,
            'access-code-id' => $this->accessCode->id
        ]);

        $this->assertDatabaseHas('votes', [
            'category_id'    => $this->category->id,
            'film_id'        => self::ALTERNATIVE_FILM_ID,
            'access_code_id' => $this->accessCode->id
        ]);
        $this->assertCount($voteCount, Vote::all());
    }

    /**
     * @group ballot
     */
    public function test_SubmitBallot_VoteInSameCategoryExists_RedirectedToVote()
    {
        $response = $this->post('submitBallot', [
            '_token'         => csrf_token(),
            $this->voteElem  => self::ALTERNATIVE_FILM_ID,
            'access-code-id' => $this->accessCode->id
        ])->assertRedirect('vote');

        $this->followRedirect($response)->assertStatus(200);
    }

    /**
     * Creates a default vote except for the given values in the array.
     *
     * @param array $except
     * @return int
     */
    protected function insertDefaultVote(array $except = [])
    {
        $vote = new Vote;
        $vote->category_id = $this->category->id;
        $vote->film_id = $this->film->id;
        $vote->access_code_id = $this->accessCode->id;

        foreach ($except as $key => $value) {
            $vote->$key = $value;
        }

        $vote->save();

        return Vote::all()->count();
    }
}
