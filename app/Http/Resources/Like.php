<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Like extends JsonResource
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
            
            'like_user_id' => $this->user_id,
            "user_name" => $this->user->name,
            "pic_url" => $this->user->pic_url,
            'like_post_id' => $this->post_id,

        ];
    }
}
