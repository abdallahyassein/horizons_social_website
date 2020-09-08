<?php

namespace App\Http\Controllers;

use App\Friend;
use App\FriendRequest;
use App\Message;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function friends($username){

        
        $user = User::where('username', $username)->firstOrFail(); 
        
        

        return view('friend.friends')->with([

            'user' => $user,
            
        ]);
    }

    public function destroy($id){


        $friend= Friend::where('user_id', Auth::user()->id)->where('friend_id', $id)->first();
        $friend2= Friend::where('friend_id', Auth::user()->id)->where('user_id', $id)->first();

        $friend->delete();
        $friend2->delete();


        $user=User::where('id', $id)->firstOrFail(); 
         
  
        return redirect()->route('profile', ['username' =>  $user->username]);


     }


 
     public function message($friend_id){


        $friend= User::where('id',$friend_id)->first();

        $messages=Message::where('user_id', Auth::user()->id)->where('friend_id', $friend_id)->orWhere('user_id', '=', $friend_id)
        ->where('friend_id', '=',Auth::user()->id)->orderBy('updated_at','asc')->paginate(20);


       
            
            return view('messages.messages')->with([
               "friend" => $friend,
               "messages" =>$messages,
            ]);


     }

     
     public function sendMessage(Request $request){


        $request->validate([

            'message' => 'required',
            
         ]);


        $message=new Message();
        $message->user_id=Auth::user()->id;
        $message->friend_id=$request->friend_id;
        $message->message=$request->message;
        $message->save();


        

        
       
            
            return redirect()->back();


     }





    
}
