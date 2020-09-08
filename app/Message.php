<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message','user_id','friend_id',
    ]; 

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function friend(){

        return $this->belongsTo(User::class,'friend_id','id');
    }
    
   
}
