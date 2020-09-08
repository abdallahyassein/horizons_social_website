<?php

namespace App\Http\Controllers;

use App\Friend;
use App\FriendRequest;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function profile($username){


        $user = User::where('username', $username)->firstOrFail();

        $tags=Tag::all();
        $isfriend=null;
        if(Auth::user()){

        $isfriend=Friend::where('friend_id', $user->id)->where('user_id', Auth::user()->id)->first();
        $sentrequest=FriendRequest::where('user_id', $user->id)->where('auth_id', Auth::user()->id)->first();
        $heSentRequest=FriendRequest::where('user_id', Auth::user()->id)->where('auth_id', $user->id)->first();

        if($sentrequest==null){

            $sentrequest='null';

        }
    }else{
        $sentrequest='null';
    }

    if($isfriend==null){

        $isfriend='null';

    }

    if($heSentRequest==null){

      $heSentReques='null';
    }



        return view('user.profile')->with([

            'user' => $user,
            'sentrequest' => $sentrequest,
            'tags' => $tags,
            'isfriend' => $isfriend,
            'heSentRequest' => $heSentRequest,
        ]);
    }

    public function avatarPage(){

        return view('user.update_avatar');
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

        return back();

    }

    public function bioPage(){

        return view('user.bio_page');
    }

    public function update_bio(Request $request){


        $request->validate([
            'bio' => 'required',
        ]);

        $user = Auth::user();


        $user->bio = $request->bio;
        $user->save();

        return redirect('profile/'.$user->username);;

    }

    public function addressPage(){

        return view('user.address_page');
    }

    public function update_address(Request $request){


        $request->validate([
            'address' => 'required',
        ]);

        $user = Auth::user();


        $user->address = $request->address;
        $user->save();

        return redirect('profile/'.$user->username);

    }




}
