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
        $films = config('seeds.films', []);
        $tags = config('seeds.tags', []);

        if (empty($films)) {
            $tagCount = Tag::all()->count();

            Film::all()->each(function ($film) use ($tagCount) {
                $film->tags()->attach([random_int(1, $tagCount)]);
            });
        } else {
            $dbTags = Tag::all();
            Film::all()->each(function($film) use($films, $tags, $dbTags) {
                if(in_array($film->title, array_keys($films)) && (count($films[$film->title]['tags']) > 0)) {
                    foreach($films[$film->title]['tags'] as $tag) {
                        if(is_int($tag)) {
                            $film->tags()->attach($tag);
                        }

                        if(is_string($tag)) {
                            $film->tags()->attach($dbTags->where('name',  $tag)->first()->id);
                        }
                    }
                }
            });
        }
    }
}
