<?php

use Illuminate\Database\Seeder;

class AccessCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AccessCode::class, 200)->create();
    }
}
