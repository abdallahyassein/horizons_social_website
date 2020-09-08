@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-md-center p-1">

        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="well well-sm well-social-post" style="background:#414152 ;opacity:0.95;">



                <h1 class="p-1" style="color:white">All Friends</h1>

            <hr>


            @if(count($user->friends)<=0)

            <h3>There are no friends</h3>

            @endif

         <div class="row pl-5">

            @foreach ($user->friends as $index=>$friend)



                <div class="p-3">
                <img class="rounded-circle ml-4" width="50px" height="50px" src="{{url('storage/pic_url/'.$friend->user->pic_url)}}" alt="user profile image">
                <a href="{{url('profile/'.$friend->user->username)}}"><p class="user">{{$friend->user->name}}</p></a>
                </div>

                @endforeach




            </div>
        </div>

        </div>

    </div>


@endsection
