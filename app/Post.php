<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'description','is_popular','is_hit','user_id','id',
    ];

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function images(){

        return $this->hasMany(Image::class,'post_id','id');
    }

    public function videos(){

        return $this->hasMany(Video::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class)->orderBy('updated_at', 'desc');;
    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }

    public function likes(){

        return $this->hasMany(Like::class);
    }






}
