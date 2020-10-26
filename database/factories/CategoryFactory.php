<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Category::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    $slug = \Illuminate\Support\Str::slug($name);
    return [
        'name' => $name,
        'slug' => $slug,
    ];
});
