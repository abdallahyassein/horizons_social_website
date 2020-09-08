<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
        $posts= $tag->posts;
        $allpostspaginated =$this->paginate($posts);
        
        return view('post.posts',with([

            'posts' => $allpostspaginated,

        ]));

    }
}
