<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Tag;

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

        if (empty($categoryTags)) {
            $tagCount = Tag::all()->count();
            $index = 0;

            Category::all()->each(function ($category) use ($tagCount, $index) {
                $category->tags()->attach(($index++ % $tagCount) + 1);
            });
        } else {
            foreach ($categoryTags as $categoryId => $tagIds) {
                Category::find($categoryId)->tags()->attach($tagIds);
            }
        }
    }
}