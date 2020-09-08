<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
       'user_id','friend_id',
    ];

    public function  blocks (){

        return $this->hasMany(User::class,'user_id','id');
    }
}
