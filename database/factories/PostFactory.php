<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    $users = \App\User::all()->pluck('id');
    $user_id = $users[$faker->unique()->numberBetween(0, count($users))];
    $zipcode = \App\Zipcode::inRandomOrder()->first();
    $city_id = $zipcode->city->id;
    $country_id = $zipcode->city->country->id;
    $description = $faker->text(150);
    $hourly_rate = $faker->numberBetween(5, 100);
    $experience = $faker->numberBetween(1, 20);
    $phone = $faker->phoneNumber;
    $onsite_service = $faker->numberBetween(0, 1);
    $reference = $faker->unique()->name;
    $verified_at = $faker->boolean ? now() : null;
    $reupdated_at = $verified_at && $faker->boolean ? now() : null;
    $featured = $verified_at ? $faker->boolean : 0;
    return [
        'user_id' => $user_id,
        'country_id' => $country_id,
        'city_id' => $city_id,
        'zipcode_id' => $zipcode->id,
        'description' => $description,
        'hourly_rate' => $hourly_rate,
        'experience' => $experience,
        'phone' => $phone,
        'onsite_service' => $onsite_service,
        'reference' => $reference,
        'verified_at' => $verified_at,
        'reupdated_at' => $reupdated_at,
        'deleted_at' => $faker->boolean ? now() : null,
        'featured' => $featured
    ];
});
