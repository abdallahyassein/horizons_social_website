<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;
use App\FriendRequest;
use App\User;

use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{


    public function destroy($id)
    {
        $friendrequest= FriendRequest::where('user_id', $id)->where('auth_id', Auth::user()->id)->first();


        $friendrequest->delete();
 
        $user=User::where('id', $id)->firstOrFail(); 
         
  
         return redirect()->route('profile', ['username' =>  $user->username]);
    }


    public function sendFriendRequest(Request $request){

        
        $friendrequest=new FriendRequest();
        $friendrequest->user_id=$request->user_id;
        $friendrequest->auth_id=$request->auth_id;
        $friendrequest->save();
 
        $user=User::where('id', $request->user_id)->firstOrFail(); 
        
 
        return redirect()->route('profile', ['username' =>  $user->username]);
 
     }

     
    public function friendRequests(){

        
       
        
        $friendrequests=FriendRequest::where('user_id', Auth::user()->id)->get(); 

        


 
        return view('friend.friends_request')->with([

            "friendrequests" => $friendrequests,
            

        ]);
 
     }

     public function acceptRequest($id){

        $friendrequest= FriendRequest::where('user_id', Auth::user()->id)->where('auth_id', $id)->first();

        $friendrequest->delete();
       
        
        $friend = new Friend();
        $friend->user_id=Auth::user()->id;
        $friend->friend_id=$id;
        $friend->save();

        $friend2 = new Friend();
        $friend2->friend_id=Auth::user()->id;
        $friend2->user_id=$id;
        $friend2->save();


 
    
        $friendrequests=FriendRequest::where('user_id', Auth::user()->id)->get(); 

        
 
        return view('friend.friends_request')->with([

            "friendrequests" => $friendrequests,
            

        ]);
 
     }


     public function refuseRequest($id){


        $friendrequest= FriendRequest::where('user_id', Auth::user()->id)->where('auth_id', $id)->first();


        $friendrequest->delete();


        $friendrequests=FriendRequest::where('user_id', Auth::user()->id)->get(); 

        
        return view('friend.friends_request')->with([

            "friendrequests" => $friendrequests,
            

        ]);


     }
 
}
