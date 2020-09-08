<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\User;
use Illuminate\Http\Request;

class LiveSearch extends Controller
{
    function searchUser(Request $request)
    {
   
        $data = $request->get('data');

        $users = User::where('name', 'like', "%{$data}%")
                         ->orWhere('username', 'like', "%{$data}%")
                         ->paginate(10);
        
                         return response()->json(['users'=>$users]); 

    }
}
