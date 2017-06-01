<?php

use Illuminate\Database\Seeder;
use App\Film;
use App\Tag;

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

        if (empty($filmTags)) {
            $tagCount = Tag::all()->count();

            Film::all()->each(function ($film) use ($tagCount) {
                $film->tags()->attach([random_int(1, $tagCount)]);
            });
        } else {
            Film::all()->each(function($film) use($filmTags) {
                $film->tags()->attach($filmTags[$film->id]);
            });
        }
    }
}
