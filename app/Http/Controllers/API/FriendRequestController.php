<?php

namespace App\Http\Controllers\API;

use App\Friend;
use App\FriendRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{

    
    public function sendFriendRequest(Request $request){

        
        $request->validate([
 
            'user_id' => 'required',
            
         ]);

         $checkFriendRequest= FriendRequest::where('user_id', $request->user_id)->where('auth_id', Auth::user()->id)->first();

         if($checkFriendRequest!=null){
            return response()->json(['success'=>"Friend Request is Sent Before"]); 
         }

        $friendrequest=new FriendRequest();
        
        $user = Auth::user();
        $friendrequest->user_id=$request->user_id;
        $friendrequest->auth_id=$user->id;
        $friendrequest->save();
 
      
        
 
        return response()->json(['success'=>"Friend Request Sent"]); 
 
     }

     public function checkFriendRequest(Request $request){

        
        $request->validate([
 
            'user_id' => 'required',
            
         ]);

         $checkFriendRequest= FriendRequest::where('user_id', $request->user_id)->where('auth_id', Auth::user()->id)->first();

         if($checkFriendRequest!=null){
            return response()->json(['success'=>"Friend Request is Sent Before"]); 
         }



 
        return response()->json(['success'=>"Send Friend Request"]); 
 
     }

          
    public function friendRequests(){

        
        $requests_details=[];
        
        $friendrequests=FriendRequest::where('user_id', Auth::user()->id)->get(); 
        foreach($friendrequests as $friend){

            array_push($requests_details,$friend->sender);

        }
        return response()->json(['users'=>$requests_details]); 
       
 
     }

     public function acceptRequest(Request $request){



        $friendrequest= FriendRequest::where('user_id', Auth::user()->id)->where('auth_id', $request->auth_id)->first();

        if($friendrequest !=null){

        $friendrequest->delete();


        
        $friend = new Friend();
        $friend->user_id=Auth::user()->id;
        $friend->friend_id=$request->auth_id;
        $friend->save();

        $friend2 = new Friend();
        $friend2->friend_id=Auth::user()->id;
        $friend2->user_id=$request->auth_id;
        $friend2->save();

        return response()->json(['success'=>"You are now Friends"]); 
        
    }


    return response()->json(['success'=>"There is No Request"]);   
 
     }


     public function refuseRequest(Request $request){


        $friendrequest= FriendRequest::where('user_id', Auth::user()->id)->where('auth_id', $request->auth_id)->first();

        if($friendrequest !=null){

        $friendrequest->delete();
        return response()->json(['success'=>"Friend Request Refused"]);      

        }


        return response()->json(['success'=>"There is No Request"]);    
        
  



     }
	 
	   public function cancelFriendRequest(Request $request){


        $friendrequest= FriendRequest::where('auth_id', Auth::user()->id)->where('user_id', $request->user_id)->first();


  

         if($friendrequest !=null){

        $friendrequest->delete();
        return response()->json(['success'=>"Friend Request Cancel"]);      

        }

	  return response()->json(['success'=>"There is No Request"]);  
     }
 

  

}
