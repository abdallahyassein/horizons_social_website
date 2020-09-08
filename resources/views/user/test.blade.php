@extends('layouts.app')


@section('content')

<link rel="stylesheet" type="text/css" href="{{ url('/css/post_style.css') }}" />

<div class="container">


    {{-- profile Picture and name  --}}
	
	<div class="row justify-content-md-center">
        
   
          
                <div class="col-md-4">
                   
                <div class="all_profile" style="position: relative; width: 200px; height: 200px;">
                <img class="rounded-circle" src="{{ url('storage/pic_url/'.$user->pic_url) }}" width="200px" height="200" style="position: relative; z-index: 1;">
                @auth
                @if(Auth::user()->username==$user->username)
                <a href="{{route('updateavatarpage')}}"><img class="rounded-circle" src="{{ url('storage/pic_url/cam-icon.png') }}" width="40px" height="40px" style="position: absolute;right:25px; bottom: 10px;z-index: 10;"></a>
                @endif
                @endauth
                </div>
                  
                    <h2 class="pb-3 pt-2 ">{{$user->name}}</h2>

                     {{-- Bio Data  --}}
                    @if($user->bio =="")
                    @if(Auth::user()->username==$user->username)
                    <a href="{{route('updatebiopage')}}"> <p><strong>Bio: </strong> Click to add bio </p></a>
                    @endif
                    @else
                    <div class="row">
                        
                            <p><strong>Bio: </strong> {{$user->bio}} </p>
                       

                            <div class="col-md-5">
                            <a href="{{route('updatebiopage')}}"><p>Edit</p></a>
                        </div>
                      
                    </div>
                    
                    @endif

                     {{-- End Bio Data  --}}
                    
                {{-- Address Data  --}} 
                    @if($user->address =="")
                    @if(Auth::user()->username==$user->username)
                    <a href="{{route('updateaddresspage')}}"> <p><strong>Address: </strong> Click to add addrees </p></a>
                    @endif
                    @else
                    <div class="row">
                        
                        <p><strong>Address: </strong> {{$user->address}} </p>
                   

                        <div class="col-md-5">
                        <a href="{{route('updateaddresspage')}}"><p>Edit</p></a>
                    </div>
                  
                </div>
                    @endif
                 {{-- End Address Data  --}}
                    <hr/>
                    
                </div>
                 
            </div>
    @auth
    {{-- End profile picture and name  --}}


    {{-- Adding a new Post  --}}          

    @if(Auth::user()->username==$user->username)

    <form action="{{route('newpost')}}" method="post" enctype="multipart/form-data">
        @csrf


      {{-- Showing friends list  --}}   
    <div class="row justify-content-md-center p-1">

        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="well well-sm well-social-post">
      
           
            <div class="p-2"><a href=""><h3>see all friends</h3></a></div>
            <hr>
            
         <div class="row p-3">

            @foreach ($user->friends as $index=>$friend)
                
   
         @if($index<6)
                <div class="p-3">          
                <img class="rounded-circle ml-4" width="50px" height="50px" src="{{url('storage/pic_url/'.$friend->user->pic_url)}}" alt="user profile image">
                <a href=""><p class="user">{{$friend->user->name}}</p></a>
                </div>  
         @endif   
                @endforeach 
    
                         

                                 
            </div>
        </div>
         
        </div>

        {{-- End Showing friends list  --}} 


        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="well well-sm well-social-post">
      
            <ul class="list-inline" id='list_PostActions'>
               
                <li>Add photos</li>
                <input type="file" class="form-control-file" name="images[]" id="images" multiple>
                
            </ul>
            
            <textarea name="description" id="description" class="form-control" placeholder="What's in your mind?" required></textarea>
          <hr>

         {{-- Showing tags  --}}   
          <strong class="p-3">Tags</strong>
          <hr>
          <div class="text-center p-1">

        
          <select name="tags[]" class="form-control"  style="width:100% ;" multiple>
           
            @for($i=0;$i<count($tags);$i++)
            <option value="{{$tags[$i]->id}}">{{$tags[$i]->tag}}</option>
            @endfor
          </select>
      
        </div>
       {{-- End sohwing tags --}} 

            <div class="text-right p-1"><button type="submit" class="btn btn-primary">Post</button></div> 

           

            </div>
         
        </div>

        
    </div>
</form>
@endif

{{-- End Adding a new Post  --}} 

@endauth


{{-- Showing User Posts  --}} 

    @foreach ($user->posts as $post)
        
 
    <div class="row justify-content-md-center">
        <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

    <div  class="col-sm-6">
        <div class="panel panel-white post panel-shadow">
            <div class="post-heading">
                <div class="pull-left image ">
                    <img  src="{{url('storage/pic_url/'.$user->pic_url)}}" class="rounded-circle avatar" alt="user profile image">
                </div>
                <div class="pull-left meta">
                    <div class="title h5">
                    <a href="{{url('profile/'.$post->user->username)}}"><b>{{$user->name}}</b></a>
                        made a post.
                    </div>
                    <h6 class="text-muted time">{{$post->updated_at}}</h6>
                </div>
            </div> 
            <div class="post-description"> 
            <p>{{$post->description}}</p>

            <div class="row">
                
            @foreach ($post->tags as $tag)
            
            <a href="{{url('tag/posts/'.$tag->tag)}}"><p class="mr-2 ml-3">#{{$tag->tag}}</p></a> 
            

            @endforeach
        </div>

            {{-- Getting post images  --}} 
            @if(count($post->images) > 1)
            <div class="row">
                @foreach ($post->images as $image)
                <div class="col-md-5">
                    
                        <img  src="{{url('storage/images/'.$image->image_url)}}" width="200" height="200" alt="user profile image">
                        <hr>
                       
                    </div>
                    @endforeach
                </div>
            @else

      
             <div class="row">
                @foreach ($post->images as $image)
                <div class="col-md-1">
                    
                        <img class="ml-4" src="{{url('storage/images/'.$image->image_url)}}" width="400" height="400" alt="user profile image">
                        
                       
                    </div>
                    @endforeach
                </div>
            @endif
            
            <hr>
           
                <div class="stats text-center">
                <a href="{{url('like/'.$post->id)}}" class="btn btn-default stat-item">
                        <i class="fa fa-thumbs-up icon"></i>{{count($post->likes)}}
                    </a>

                    
                
                </div>
            </div>

             {{--End Getting post images  --}} 


            {{-- Adding Comment  --}} 

            <div class="post-footer">
                
            <form action="{{route('comment')}}"  method="post" enctype="multipart/form-data" >
                @csrf
             
                <div class="input-group">   
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                   
                    
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    
               <div class="input-group">
                    <div class="form-group input-group">

                    <input class="form-control" name="comment"  placeholder="Add a comment" type="text">
                    <button type="submit" class="btn btn-success ml-1">Comment</button>
                     </div>

              
                  
             
               
                </div>
                


            </form>
        </div>


        {{-- End Adding Comment  --}} 


                {{-- Showing Users Comments  --}} 
                <ul class="comments-list">
                    <li class="comment">
                      
                        @foreach ($post->comments as $comment)
                         
                        <div class="comment-body">
                            <div class="comment-heading">
                                
                                <img src="{{url('storage/pic_url/'.$comment->user->pic_url)}}" class="rounded-circle avatar" alt="user profile image">
         
                               <a href="{{url('profile/'.$comment->user->username)}}"><h4 class="user">{{$comment->user->name}}</h4></a>
                                <h5 class="time">{{$comment->updated_at}}</h5>
                            </div>
                            <p class="pl-5">{{$comment->comment}}</p>
                        </div>
                        
                        @endforeach
                     
                    </li>
                </ul>
                {{-- End Showing Users Comments  --}} 
            </div>

    </div>
</div>
            
        
</div>
@endforeach

{{--End Showing User Posts  --}} 

</div>

@endsection