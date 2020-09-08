<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        
        'description' => $faker->paragraph(),
        'is_popular' => $faker->boolean(),
        'is_hit' => $faker->boolean(),
        'user_id' => $faker->numberBetween(1,50),

       
    ];
});
