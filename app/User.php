<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password','pic_url','bio','address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


   public function posts(){

        return $this->hasMany(Post::class,'user_id','id')->orderBy('updated_at', 'desc');

   } 

   public function friends(){

    return $this->hasMany(Friend::class,'user_id','id');

} 

public function friendrequests(){

    return $this->hasMany(FriendRequest::class,'user_id','id');

} 

public function messages(){

    return $this->hasMany(Message::class,'user_id','id');

} 






}
