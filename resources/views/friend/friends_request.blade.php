@extends('layouts.app')


@section('content')




@auth




<div class="row justify-content-md-center">
 <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
 <link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
 <link rel="stylesheet" type="text/css" href="{{ url('/css/post_style.css') }}" />
 <div class="container bootstrap snippet">

   <div class="header">
     <h3 class="text-muted prj-name">
         <span class="fa fa-users fa-2x principal-title"></span>
         Friend Requests
     </h3>
   </div>


   <div class="jumbotron list-content">
     <ul class="list-group">
       <li href="#" class="list-group-item title">
         Your friend Requests
       </li>


       @foreach ($friendrequests as $friendrequest)

       <li href="#" class="list-group-item text-left">
           <img class="img-thumbnail"  src="{{ url('storage/pic_url/'.$friendrequest->sender->pic_url) }}" width="60px" height="60">
           <label class="name">

            <a href="{{url('profile/'.$friendrequest->sender->username)}}"><h4 class="user">{{$friendrequest->sender->name}}</h4></a>

           </label>

         <label class="pull-right">

          <form class="pull-right" action="{{route('friendrequest.acceptrequest',['id'=>$friendrequest->sender->id])}}"  method="post">
            @csrf

        <button  type="submit" class="btn btn-success m-1">Accept</button>
      </form>

      <hr>

          <form action="{{route('friendrequest.refuserequest',['id'=>$friendrequest->sender->id])}}"  method="post">
            @csrf
            @method('delete')
        <button type="submit" class="btn btn-dark m-1" onclick="return confirm('Are you sure to delete?')">Ignore</button>
      </form>
         </label>

         <div class="break"></div>
       </li>
       @endforeach

     </ul>
   </div>
   </div>
 </div>
</div>








@endauth


@endsection
