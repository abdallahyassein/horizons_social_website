@extends('layouts.app')


@section('content')



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






                </div>




            </div>



        </div>

        <hr/>

    {{-- End profile picture and name  --}}


    {{-- Sending Friend Request  --}}

    <div class="container">
        <div class="row justify-content-md-center p-1">


    @auth


    @if($isfriend == 'null')

    @if(Auth::user()->username!=$user->username)

		@if ($heSentRequest !=null)

						<button type="submit" class="btn btn-secondary ml-1">Check Your Friend Requests Page</button>

        @elseif($sentrequest=="null")

        <form action="{{route('friendrequest')}}"  method="post">
            @csrf

        <div class="input-group">

             <input type="hidden" name="auth_id" value="{{Auth::user()->id}}">


             <input type="hidden" name="user_id" value="{{$user->id}}">




             <button type="submit" class="btn btn-success ml-1">Send Friend Request</button>
            </div>

        </form>



             @else


             <form action="{{route('friendrequest.destroy',['id'=>$user->id])}}"  method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-warning ml-1" onclick="return confirm('Are you sure to cancel?')">Your Friend Request Sent Successfully</button>
                </form>


            @endif


    @endif

    @else


    <form action="{{route('friend.destroy',['id'=>$user->id])}}"  method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-success ml-1" onclick="return confirm('Are you sure you want to unfriend?')">Unfriend</button>
        </form>

    @endif


    @endauth

      {{-- Messages Page  --}}

    @auth
    <a class="btn btn-info ml-1" href="{{route('friend.message',['friend_id'=>$user->id])}}">Message</a>
    @endauth

     {{-- End Messages  --}}

</div>
</div>


 {{-- End Sending Friend Request  --}}





          {{-- Showing friends list  --}}

          <div class="container">
            <div class="row justify-content-md-center p-1">

                <div class="col-md-offset-3 col-md-6 col-xs-12">
                    <div class="well well-sm well-social-post"  style="background:#414152 ;opacity:0.95;">


                    <div class="p-2"><a href="{{url('friends/'.$user->username)}}"><h3>see all friends</h3></a></div>


                    <hr>

                 <div class="row pl-5">

                    @foreach ($user->friends as $index=>$friend)


                 @if($index<6)
                        <div class="p-3">
                        <img class="rounded-circle ml-4" width="50px" height="50px" src="{{url('storage/pic_url/'.$friend->user->pic_url)}}" alt="user profile image">
                        <a href="{{url('profile/'.$friend->user->username)}}"><p class="user">{{$friend->user->name}}</p></a>
                        </div>
                 @endif
                        @endforeach




                    </div>
                </div>


                </div>

            </div>

            <hr>

            {{-- End Showing friends list  --}}

{{-- Adding a new Post  --}}
    @auth
    @if(Auth::user()->username==$user->username)

    <div class="container">

    <div class="row justify-content-md-center p-1">
        <div class="col-md-offset-3 col-md-8 col-xs-12">

    <form action="{{route('newpost')}}" method="post" enctype="multipart/form-data">
        @csrf




            <div class="well well-sm well-social-post"  style="background:#414152 ;opacity:0.95;">

            <ul class="list-inline" id='list_PostActions'>

                <li style="color:white;">Add photos</li>
                <input  type="file" class="form-control-file" name="images[]" id="images" multiple>

            </ul>

            <textarea  style="background:#414152 ;opacity:0.95; color:white;" name="description" id="description" class="form-control" placeholder="What's in your mind?" required></textarea>
          <hr>

         {{-- Showing tags  --}}
          <strong class="p-3">Tags</strong>
          <hr>
          <div class="text-center p-1">


          <select style="background:#414152 ;opacity:0.95; color:white;" name="tags[]" class="form-control"  style="width:100% ;" multiple>

            @for($i=0;$i<count($tags);$i++)
            <option value="{{$tags[$i]->id}}">{{$tags[$i]->tag}}</option>
            @endfor
          </select>

        </div>
       {{-- End sohwing tags --}}

            <div class="text-right p-1"><button type="submit" class="btn btn-primary">Post</button></div>



            </div>







</form>
</div>
</div>
</div>

<hr>

@endif

{{-- End Adding a new Post  --}}

@endauth




{{-- Showing User Posts  --}}

    @foreach ($user->posts as $post)

 <div class="container">


    <div class="row justify-content-md-center">
        <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

    <div  class="col-md-8">
        <div class="panel  post panel-shadow" style="background:#414152 ;opacity:0.95;">
            <div class="post-heading">
                <div class="pull-left image ">
                    <img  src="{{url('storage/pic_url/'.$user->pic_url)}}" class="rounded-circle avatar" alt="user profile image">
                </div>
                <div class="pull-left meta">

                    <a href="{{url('profile/'.$post->user->username)}}"><h5>{{$user->name}}</h5></a>


                    <h6 class="text-muted time">{{$post->updated_at}}</h6>
                </div>
            </div>
            <div class="post-description pull-left ">

            <hr>

            <h5 style="color:white">{{$post->description}}</h5>

            <div class="row">

            @foreach ($post->tags as $tag)

            <a href="{{url('tag/posts/'.$tag->tag)}}"><p class="mr-2 ml-3">#{{$tag->tag}}</p></a>


            @endforeach
        </div>

            {{-- Getting post images  --}}
            @if(count($post->images) > 1)
            <div class="row">
                @foreach ($post->images as $image)
                <div class="col-md-6">

                        <hr>
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
                    @auth
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">


                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    @endauth
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
                            <p class="pl-5" style="color:white">{{$comment->comment}}</p>
                        </div>

                        @endforeach

                    </li>
                </ul>
                {{-- End Showing Users Comments  --}}
            </div>

    </div>
</div>

</div>

<hr>

</div>
@endforeach

{{--End Showing User Posts  --}}

</div>

@endsection
