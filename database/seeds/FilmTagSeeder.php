<?php

use Illuminate\Database\Seeder;
use App\Film;

class FilmTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filmTags = config('seeds.filmTags', []);

        foreach($filmTags as $filmId => $tagIds) {
            Film::find($filmId)->tags()->attach($tagIds);
        }
    }
}
