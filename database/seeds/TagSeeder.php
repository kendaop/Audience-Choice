<?php

use Illuminate\Database\Seeder;
use App\Tag;

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

        if (empty($tags)) {
            factory(Tag::class, 20)->create();
        } else {
            foreach ($tags as $name => $description) {
                factory(Tag::class)->create([
                    'name' => $name,
                    'description' => $description
                ]);
            }
        }
    }
}
