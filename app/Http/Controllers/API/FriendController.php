<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Resources\Friend as FriendResourse;
use App\User;
use Illuminate\Http\Request;
use App\Friend;
use App\Http\Resources\Message as ResourcesMessage;
use App\Message;
use Illuminate\Support\Facades\Auth;


class FriendController extends Controller
{
    public function friends(Request $request){

        
        $user= User::where('username', $request->username)->firstOrFail(); 
        $friends= $user->friends;
    
        return response()->json(['friends'=> FriendResourse::collection($friends)]); 

    }

    public function unFriend(Request $request){

       
        $friend= Friend::where('user_id', Auth::user()->id)->where('friend_id', $request->friend_id)->first();
        $friend2= Friend::where('friend_id', Auth::user()->id)->where('user_id', $request->friend_id)->first();

        if($friend !=null && $friend !=null)
        { 

            $friend->delete();
            $friend2->delete();
            return response()->json(['success'=> "You are now not friends"]); 

        }

    
        return response()->json(['success'=> "You already are not friend"]); 
     }


     public function messages(Request $request){


        $friend= User::where('id',$request->friend_id)->first();

        $messages=Message::where('user_id', Auth::user()->id)->where('friend_id', $request->friend_id)->orWhere('user_id', '=', $request->friend_id)
        ->where('friend_id', '=',Auth::user()->id)->orderBy('updated_at','asc')->paginate(20);

        return response()->json(['messages'=> ResourcesMessage::collection($messages)]); 
            


     }

     public function sendMessage(Request $request){


        $request->validate([

            'message' => 'required',
            'friend_id' => 'required',
            
         ]);


        $message=new Message();
        $message->user_id=Auth::user()->id;
        $message->friend_id=$request->friend_id;
        $message->message=$request->message;
        $message->save();


        

            
        return response()->json(['success'=> "Message is Sent Successfully"]); 


     }
}
