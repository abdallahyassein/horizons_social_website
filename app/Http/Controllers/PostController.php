<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class PostController extends Controller
{
    public function new_post(Request $request){

        
        $request->validate([

           'description' => 'required',
           
        ]);


        $user = Auth::user();
        
           $post= new Post();
           $post->description=$request->description;
           $post->user_id=$user->id;
           
           $post->save();
           $post->tags()->attach($request->tags);
			
           $imagesdata = array();
          
           
           if($request->hasFile('images')){

           foreach ($request->file('images') as $imagesample){

           //   $image= new Image();  
          
               $imageName = $user->id.'_image'.time().Str::random(20).'.'.$imagesample->getClientOriginalExtension();
               $imagesample->storeAs('public/images/',$imageName);


               array_push($imagesdata,['post_id'=>$post->id, 'image_url'=>$imageName]);

              

           }

           

           

           Image::insert($imagesdata);

       }
          

       return redirect('profile/'.$user->username);

   }

   public function like($post_id)
  {

    if(!Auth::check()) {
        return view('auth.login');
    }
    $post = Post::where('id', $post_id)->first();
    $user = Auth::user();
    $likecheck = Like::where('post_id', $post->id)->where('user_id', $user->id)->first();
    
    if($likecheck==null)
    {
        $like= new Like();
        $like->user_id=$user->id;
        $like->post_id=$post->id;
        $like->save();

    }
    else
    {
        Like::where('user_id',$user->id)->where('post_id', $post->id)->first()->delete();
    }
    return redirect()->back();
    
   }

   public function comment(Request $request)
   {

    $request->validate([

        'comment' => 'required',
        
     ]);
 
     if(!Auth::check()) {
         return view('auth.login');
     }
    
     
    $comment=new Comment();
    $comment->user_id=$request->user_id;
    $comment->post_id=$request->post_id;
    $comment->comment=$request->comment;
    $comment->save();

     
     
    
     return redirect()->back();
     
    }


    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function posts()
    {

        $allPosts=array();

        $popularposts = Post::where('is_popular', 1)->orderBy('id', 'desc')->take(7)->get();
        $hitposts = Post::where('is_hit', 1)->orderBy('id', 'desc')->take(7)->get();

        foreach($popularposts as $post)
        {
            
            array_push($allPosts,$post);
        }

        foreach($hitposts as $post)
        {
            
            array_push($allPosts,$post);
        }

        if(Auth::check()){

        
        
    
    
        $friends=Auth::user()->friends;

        foreach($friends as $friend)
        {
            $posts= $friend->user->posts->take(7);

          

            foreach($posts as $post)
        {
            
            array_push($allPosts,$post);
        }

           
        }
     

    }

    
     
  //  shuffle($allPosts);   // Shuffle array elements

    $posts = new Collection();

    $numberOfPosts= count($allPosts);   

    for($i = 0; $i< $numberOfPosts ;$i++){


        
       

        $postModel=new Post();
        $postModel->fill([

        'id' => $allPosts[$i]['id'],  
        'user_id' => $allPosts[$i]['user_id'],
        'is_popular'=>$allPosts[$i]['is_popular'],
        'is_hit'=>$allPosts[$i]['is_hit'],
        'description'=>$allPosts[$i]['description']],

        );

         $posts->push($postModel);

    }



    $posts->sortByDesc('updated_at');

    $allpostspaginated = $this->paginate($posts);

    return view('post.posts')->with([

        'posts' => $allpostspaginated,
        
        
        
    ]);
}



}
