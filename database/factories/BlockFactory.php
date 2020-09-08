<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Block;
use Faker\Generator as Faker;

$factory->define(Block::class, function (Faker $faker) {
    return [
       
        'user_id' => $faker->numberBetween(1,50),
        'friend_id' => $faker->numberBetween(1,50),
    ];
});
