<?php

namespace App\Http\Controllers\API;

use App\Friend;
use App\FriendRequest;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Facades\Auth; 
use Validator;


class UserController extends Controller
{
    public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
			$success['user'] =  $user;
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'username' => 'required|unique:users',  
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['user'] =  $user;
       
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 


    public function update_avatar(Request $request){

        
        $request->validate([
            'pic_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
      
        $avatarName = $user->id.'_pic_url'.time().'.'.$request->pic_url->getClientOriginalExtension();

        $request->pic_url->storeAs('public/pic_url/',$avatarName);

        $user->pic_url = $avatarName;
        $user->save();

        return response()->json(['success' => "Your Profile Picture Updated Successfully"]); 

    }

    
    public function update_bio(Request $request){

        
        $request->validate([
            'bio' => 'required',
        ]);

        $user = Auth::user();
      
    
        $user->bio = $request->bio;
        $user->save();

        return response()->json(['success' => "Bio Updated Successfully"]); 

    }

    public function profile($id){

        
    
       $user=User::find($id);

       $checkIffriend= Friend::where('user_id', Auth::user()->id)->where('friend_id', $id)->first();
        $is_friend=false;
        $sent_friend_request=false;
		$user_sent_request=false;
       if($checkIffriend!=null){
          $is_friend=true;
       }

       $checkFriendRequest= FriendRequest::where('user_id', $id)->where('auth_id', Auth::user()->id)->first();

       if($checkFriendRequest!=null){
         $sent_friend_request=true;
       }
	   
	   
       $checkIfUserSentRequest= FriendRequest::where('auth_id', $id)->where('user_id', Auth::user()->id)->first();

       if($checkIfUserSentRequest!=null){
         $user_sent_request=true;
       }

      return  response()->json(['user'=>new UserResource($user),"is_friend" => $is_friend,"sent_friend_request" =>$sent_friend_request,"user_sent_request"=>$user_sent_request]);  

    }

    public function update_address(Request $request){

        
        $request->validate([
            'address' => 'required',
        ]);

        $user = Auth::user();
      
    
        $user->address = $request->address;
        $user->save();

        return response()->json(['success' => "Address Updated Successfully"]); 

    }
	
	
	public function getUser($id)
 {

    $user = User::where('id', $id)->firstOrFail();
     
     if($user!=null){
     
     
     return response()->json(['user'=>$user]); 	
     }
   
          return response()->json(['user'=>"there is no user with this id "]); 
 }



}
