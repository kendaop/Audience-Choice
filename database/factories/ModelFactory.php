<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\AccessCode::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->unique()->ean8,
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
        'description' => $faker->unique()->sentence,
    ];
});

$factory->define(App\Film::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->company,
        'description' => $faker->unique()->catchPhrase,
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->paragraph,
    ];
});

$factory->define(App\Vote::class, function (Faker\Generator $faker) {
    return [
        'category_id' => function () {
             return factory(App\Category::class)->create()->id;
        },
        'film_id' => function () {
             return factory(App\Film::class)->create()->id;
        },
        'access_code_id' => function () {
             return factory(App\AccessCode::class)->create()->id;
        },
        'weight' => $faker->randomNumber(),
    ];
});

