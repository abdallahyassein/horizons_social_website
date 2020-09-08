<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    protected $fillable =[

        'user_id','auth_id'
        
    ];

   public function sender(){

    return $this->belongsTo(User::class,'auth_id','id');

   }
}
