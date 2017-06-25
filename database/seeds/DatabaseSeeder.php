<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(FilmSeeder::class);
        $this->call(CategoryTagSeeder::class);
        $this->call(FilmTagSeeder::class);
        $this->call(AccessCodeSeeder::class);
        $this->call(CategoryAccessCodeSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(VoteSeeder::class);
    }
}
