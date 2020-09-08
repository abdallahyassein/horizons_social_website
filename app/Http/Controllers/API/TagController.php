<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Tag;
use App\Http\Resources\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TagController extends Controller
{


    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function posts($tag)
    {

        $tag = Tag::where('tag', $tag)->first();
		
		if($tag!=null){
			  $posts= $tag->posts;
        
        $allpostspaginated =$this->paginate($posts);
        
        return response()->json(['posts'=>$allpostspaginated]); 	
		}
      
			 return response()->json(['posts'=>"there is no tag with this name"]); 
    }
}
