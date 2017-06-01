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

            Category::all()->each(function ($category) use ($tagCount) {
                $category->tags()->attach([random_int(1, $tagCount)]);
            });
        } else {
            foreach ($categoryTags as $categoryId => $tagIds) {
                Category::find($categoryId)->tags()->attach($tagIds);
            }
        }
    }
}