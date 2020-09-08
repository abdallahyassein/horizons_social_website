@extends('layouts.app')

@section('content')

<div class="container">

<div class="row justify-content-center pt-5">
    <form action="profile/updateavatar" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" class="form-control-file" name="pic_url" id="pic_url" aria-describedby="fileHelp">
            <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

        
    </form>
</div>
</div>

@endsection