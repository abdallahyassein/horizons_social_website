@extends('layouts.app')

@section('content')


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ url('/css/messages_style.css') }}" />
<div class="container">

    <!-- Page header start -->
    <div class="page-title">
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h5 class="title">Chatting Room</h5>
            </div>
  
        </div>
    </div>
    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card m-0">

                    <!-- Row start -->
                    <div class="row no-gutters">
                        
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">
                            <div class="selected-user">
                                <span>To: <span class="name">{{$friend->name}}</span></span>
                            </div>
                            <div class="chat-container">
                                <ul class="chat-box chatContainerScroll">

                                    @foreach ($messages as $message)
                                    
                                    
                                    <li class="chat-left">
                                        <div class="chat-avatar">
                                            <img src="{{url('storage/pic_url/'.$message->user->pic_url)}}" class="rounded-circle avatar" alt="user profile image">
                                            <div class="chat-name">{{$message->user->name}}</div>
                                        </div>
                                    
                                        
                                            @if(Auth::user()->username==$message->user->username)
                                            <div class="chat-text" style="color:white; background-color:#7F93EF;"> {{$message->message}}</div>

                                            @else
                                            <div class="chat-text"> {{$message->message}}</div>
                                            @endif

                                     
                                    
                                        <div class="chat-hour">{{$message->updated_at}}</div>
                                    </li>

                                    @endforeach
                                    
                                </ul>
                                <div class="form-group mt-3 mb-0">
                                    <form action="{{route('send.message')}}"  method="post">
                                        @csrf
                                        <input type="hidden" id="friend_id" name="friend_id" value="{{$friend->id}}"> 
                                        <textarea id="message"  name="message" class="form-control" rows="3" placeholder="Type your message here..." required></textarea>
                                        <button  type="submit" class="btn btn-success ml-1 mt-3">Send Message</button>
                                        </form>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>

            </div>

        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->

</div>



@endsection