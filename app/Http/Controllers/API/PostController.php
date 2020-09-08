<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as ResourcesComment;
use App\Http\Resources\Like as ResourcesLike;
use App\Image;
use App\Like;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
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
          // return $request->tags;
           $post->save();
           $post->tags()->attach($request->tags);
       
           $imagesdata = array();
          
           $files = $request->file('images');

			if(!empty($files)){
					
				foreach($files as $file){
             
         
           $imageName = $user->id.'_image'.time().Str::random(20).'.'.$file->getClientOriginalExtension();
           $file->storeAs('public/images/',$imageName);
           array_push($imagesdata,['post_id'=>$post->id, 'image_url'=>$imageName]);

         }

           Image::insert($imagesdata);
				
	}
       

        
       return response()->json(['success'=>"post added"]); 

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
		 return response()->json(['success'=>"post liked"]);
 
     }
     else
     {
         Like::where('user_id',$user->id)->where('post_id', $post->id)->first()->delete();
		 return response()->json(['success'=>"post Unliked"]);
     }
     
		 return response()->json(['success'=>"post Unliked"]);
    }


    public function comment(Request $request)
    {
 
     $request->validate([
 
         'comment' => 'required',
         
      ]);
  
      $user = Auth::user();
     
      
     $comment=new Comment();
     $comment->user_id=$user->id;
     $comment->post_id=$request->post_id;
     $comment->comment=$request->comment;
     $comment->save();
 
      
   
      return response()->json(['success'=>"post commented"]); 
      
     }

     public function paginate($items, $perPage = 5, $page = null)
     {
         $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
         $items = $items instanceof Collection ? $items : Collection::make($items);
         return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
             'path' => Paginator::resolveCurrentPath()
         ]);
     }
 
     public function posts(
	 )
     {
 
        $allPosts=array();

        $popularposts = Post::where('is_popular', 1)->orderBy('id', 'desc')->take(5)->get();
        $hitposts = Post::where('is_hit', 1)->orderBy('id', 'desc')->take(5)->get();

        foreach($popularposts as $post)
        {
            
            array_push($allPosts,$post);
        }

        foreach($hitposts as $post)
        {
            
            array_push($allPosts,$post);
        }

      
        $friends=Auth::user()->friends;

        foreach($friends as $friend)
        {
            $posts= $friend->user->posts->take(5);

          

            foreach($posts as $post)
        {
            
            array_push($allPosts,$post);
        }

           
        }
     

    
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

     $checkLiked= Like::where('user_id', Auth::user()->id)->where('post_id', $postModel->id)->first();
	 $isLiked=null;
	if($checkLiked==null){
		
		$isLiked=false;
	}else{
		
		$isLiked=true;
		
	}
	 
     $comments=ResourcesComment::collection($postModel->comments);
     $likes=ResourcesLike::collection($postModel->likes);
     $images=$postModel->images;
     $posts->push(["post"=>$postModel,"user"=>$postModel->user,"comments"=>$comments,"likes"=>$likes,"images"=>$images,"is_liked"=>$isLiked]);

    }

    
    
    $posts->sortByDesc('updated_at');
   //  $allpostspaginated = $this->paginate($posts);
     return response()->json(['posts'=>$posts ]); 
 }


 public function postComments($postId)
 {

    $comments = Comment::where('post_id', $postId)->get();
     
     if($comments!=null){
     
     
     return response()->json(['comments'=>ResourcesComment::collection($comments)]); 	
     }
   
          return response()->json(['comments'=>"there is no comment"]); 
 }

 public function postImages($postId)
 {

    $images = Image::where('post_id', $postId)->get();
     
     if($images!=null){
     
     
     return response()->json(['images'=>$images]); 	
     }
   
          return response()->json(['images'=>"there is no image "]); 
 }

}
