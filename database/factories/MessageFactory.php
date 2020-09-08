<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
       
        'message' => $faker->sentence(),
        'user_id' => $faker->numberBetween(1,50),
        'friend_id' => $faker->numberBetween(1,50),
        
    ];
});
