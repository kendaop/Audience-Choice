<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryTags = config('seeds.categoryTags', []);

        foreach ($categoryTags as $categoryId => $tagIds) {
            Category::find($categoryId)->tags()->attach($tagIds);
        }
    }
}