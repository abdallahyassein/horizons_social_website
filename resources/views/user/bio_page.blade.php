@extends('layouts.app')

@section('content')

<div class="container">

<div class="row justify-content-center pt-5">
    <div class="col-md-offset-3 col-md-6 col-xs-12">
    <div class="well well-sm well-social-post">
    <form action="profile/updatebio" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">

            <label for="bio">Bio</label>
            <textarea class="form-control" name="bio" id="bio" rows="5"></textarea>
            
        </div>
        <hr>
        <div class="text-right p-1"> <button type="submit" class="btn btn-primary">Submit</button></div>

        
    </form>
</div>
</div>
</div>
</div>
@endsection