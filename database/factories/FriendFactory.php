<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Friend;
use Faker\Generator as Faker;

$factory->define(Friend::class, function (Faker $faker) {
    return [

        'user_id' => $faker->numberBetween(1,50),
        'friend_id' => $faker->numberBetween(1,50),
    ];
});
