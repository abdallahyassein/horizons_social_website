<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Friend extends JsonResource
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
            
            'friend' => $this ->user,
           

        ];
    }
}
