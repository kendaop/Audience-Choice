<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = config('seeds.tags', []);

        foreach ($tags as $name => $description) {
            factory(App\Tag::class)->create([
                'name'        => $name,
                'description' => $description
            ]);
        }
    }
}
