<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            
            'comment_user_id' => $this->user_id,
            "user_name" => $this->user->name,
            "pic_url" => $this->user->pic_url,
            'comment_post_id' => $this->post_id,
            'post_comment' => $this->comment,
            
           
        ];
    }
}
