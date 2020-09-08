<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $this->call(FriendSeeder::class);

        factory(\App\User::class,100)->create();

            
        factory(\App\Post::class,500)->create();

        factory(\App\Friend::class,300)->create();

        factory(\App\Message::class,300)->create();

        factory(\App\Like::class,300)->create();

        factory(\App\Tag::class,50)->create();

        factory(\App\Block::class,10)->create();

        factory(\App\Image::class,200)->create();
        

        factory(\App\Comment::class,500)->create();

        for ($x = 0; $x <= 500; $x++) {
       
       

        DB::table('post_tag')->insert([

            'post_id' => mt_rand(1, 500),
            'tag_id' => mt_rand(1, 500),
            
        ]);

    }

    }
}
