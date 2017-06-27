<?php

use Illuminate\Database\Seeder;
use App\AccessCode;
use App\Category;

class CategoryAccessCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryIds = Category::orderBy('id')->select('id')->where('id', '>', 0)->get()->toArray();
        $index = 0;

        AccessCode::all()->each(function ($accessCode) use ($categoryIds, &$index) {
            // Attach the first AccessCode to all Categories
            if ($accessCode->id === 1) {
                $accessCode->categories()->attach(range(1, count($categoryIds)));
            } else {
                $accessCode->categories()->attach([
                    $categoryIds[$index++ % count($categoryIds)]['id'],
                    $categoryIds[$index++ % count($categoryIds)]['id']
                ]);
            }
        });
    }
}
