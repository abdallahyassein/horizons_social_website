<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Like as LikeModel;
use Illuminate\Support\Facades\Auth; 

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        $checkIfUserLiked= LikeModel::where('user_id', Auth::user()->id)->where('post_id',$this->id)->first();
        $isLiked=false;

        if($checkIfUserLiked!=null){

            $isLiked=true;
        }
   
       
        return [
            
            'id' => $this->id,
            'user_id' => $this->user_id,
            'is_popular' => $this->is_popular,
            'is_hit' => $this->is_hit,
            'description' => $this->description,
			'user' => $this->user,
            'images' => Image::collection($this->images),
            'comments' => Comment::collection($this->comments),
			'likes' => Like::collection($this->comments),
            'is_liked' => $isLiked,
            
            
            

        ];
    }
}
