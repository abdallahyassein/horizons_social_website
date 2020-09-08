<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
       
        'user_id' => $faker->numberBetween(1,50),
        'post_id' => $faker->numberBetween(1,100),
    ];
});
