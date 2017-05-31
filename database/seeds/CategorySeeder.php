<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = config('seeds.categories', []);

        foreach ($categories as $name => $description) {
            factory(Category::class)->create([
                'name'        => $name,
                'description' => $description
            ]);
        }

        if(config('vote.categories.squash')) {
            $this->createSquashedCategory();
        }
    }

    protected function createSquashedCategory()
    {
        $category = new Category;
        $category->name = 'Squashed';
        $category->description = 'All votes will be attached to this category. Other categories are only for visual display purposes.';
        $category->save();
        $category->id = 0;
        $category->save();
    }
}
