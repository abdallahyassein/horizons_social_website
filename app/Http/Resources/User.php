<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        

        return [
            
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'pic_url' => $this->pic_url,
            'address' => $this->address,
            'bio' => $this->bio,
            'friends' => Friend::collection($this->friends),
            'posts' => Post::collection($this->posts),
            
        ];
    }
}
