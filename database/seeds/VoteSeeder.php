<?php

use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\AccessCode::with('categories')->get()->each(function($accessCode) {
            $this->createVote($accessCode);
        });
    }

    private function createVote($accessCode)
    {
        try {
            $category = $accessCode->categories->random(1)->first();

            $vote = new \App\Vote([
                'access_code_id' => $accessCode->id,
                'category_id'    => $category->id,
                'film_id'        => $category->getFilms()->random(1)->first()->id,
                'weight'         => rand(1, 5)
            ]);

            $accessCode->votes()->save($vote);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->errorInfo[1] !== 1062) {
                var_dump($ex->errorInfo[1]);
                throw $ex;
            }
        } catch(InvalidArgumentException $ex) {
            return;
        }
    }
}
