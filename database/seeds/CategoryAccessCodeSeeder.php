<?php

use Illuminate\Database\Seeder;

class CategoryAccessCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryIds = App\Category::orderBy('id')->select('id')->where('id', '>', 0)->get()->toArray();
        $index = 0;

        App\AccessCode::all()->each(function($accessCode) use ($categoryIds, &$index) {

            $accessCode->categories()->attach([
                $categoryIds[$index++ % count($categoryIds)]['id'],
                $categoryIds[$index++ % count($categoryIds)]['id']
            ]);
        });
    }
}
