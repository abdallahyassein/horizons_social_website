<!DOCTYPE html>
<html>
 <head>
  <title>Search Friends</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 </head>

 <body style="background-image: url('/images/social_media2.jpg');
 background-position: center;
 background-repeat: no-repeat;
 background-size: cover;">

  <br />
  <div class="container box">

    <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark" style="background:#4B97CA ; opacity:0.98;">


            <h1 align="center" class="display-5 font-italic" style="color:#FFFFFF;">Search Friends</h1>


    </div>

   <div class="panel panel-primary " >
    <div class="panel-heading">Search Friends</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="Search Friends" />
     </div>
     <div class="table-responsive">
      <h3 align="center">Total Data : <span id="total_records"></span></h3>
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
         <th>Name</th>
         <th>username</th>
         <th>Address</th>

        </tr>
       </thead>
       <tbody>

       </tbody>
      </table>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('live_search.action') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>
