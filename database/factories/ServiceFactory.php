<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Service::class, function (Faker $faker) {
    $category_id = \App\Category::inRandomOrder()->first()->id;
    $name = $faker->unique()->word;
    $slug = \Illuminate\Support\Str::slug($name);
    $aka_1 = substr($faker->word(), 0, 2);
    return [
        'category_id' => $category_id,
        'name' => $name,
        'slug' => $slug,
        'aka_1' => $aka_1
    ];
});
