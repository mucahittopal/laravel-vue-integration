<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Review::class, function (Faker $faker) {
    return [
        'post_id' => 50,
        'user_id' => $faker->unique()->numberBetween(35,50),
        'rate' => $faker->numberBetween(1,5),
        'text' => $faker->text(150)
    ];
});
