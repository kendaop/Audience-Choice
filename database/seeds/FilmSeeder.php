<?php

use Illuminate\Database\Seeder;
use App\Film;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $films = config('seeds.films', []);

        if(empty($films)) {
            factory(Film::class, 30)->create();
        } else {
            foreach ($films as $title => $info) {
                factory(App\Film::class)->create([
                    'title'       => $title,
                    'description' => $info['description']
                ]);
            }
        }
    }
}
