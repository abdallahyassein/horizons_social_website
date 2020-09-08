@extends('layouts.app')

@section('content')



@foreach ($posts as $post)
<div class="container">
<div class="row justify-content-md-center">

<div class="col-md-10 pt-3">
    <div class="panel panel-white post "  style="background:#414152 ;opacity:0.95;">
        <div class="post-heading">
            <div class="pull-left image ">
                <img  src="{{url('storage/pic_url/'.$post->user->pic_url)}}" class="rounded-circle avatar" alt="user profile image">
            </div>
            <div class="pull-left meta">
                <div class="title h5">
                <a href="{{url('profile/'.$post->user->username)}}"><b>{{$post->user->name}}</b></a>
                    made a post.
                </div>
                <h6 class="text-muted time">{{$post->updated_at}}</h6>
            </div>
        </div>
        <div class="post-description">
        <p style="color:white;">{{$post->description}}</p>

        <div class="row">

        @foreach ($post->tags as $tag)

        <a href="{{url('tag/posts/'.$tag->tag)}}"><p class="mr-2 ml-3">#{{$tag->tag}}</p></a>


        @endforeach
    </div>
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



        <div class="post-footer">

        @auth
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
            <ul class="comments-list">
                <li class="comment">

                    @foreach ($post->comments as $comment)

                    <div class="comment-body">
                        <div class="comment-heading">

                            <img src="{{url('storage/pic_url/'.$comment->user->pic_url)}}" class="rounded-circle avatar" alt="user profile image">

                           <a href="{{url('profile/'.$comment->user->username)}}"><h4 class="user">{{$comment->user->name}}</h4></a>
                            <h5 class="time">{{$comment->updated_at}}</h5>
                        </div>
                        <p class="pl-5" style="color:white;">{{$comment->comment}}</p>
                    </div>

                    @endforeach

                </li>
            </ul>
        </div>
        @endauth

</div>
</div>

</div>

<hr>
@endforeach



<div class="container">
    <hr>
<div class="row justify-content-md-center">

{{$posts->links()}}
</div>
</div>


@endsection
