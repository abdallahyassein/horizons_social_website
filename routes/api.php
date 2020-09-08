<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('updateavatar', 'API\UserController@update_avatar')->middleware('auth:api');
Route::post('updatebio', 'API\UserController@update_bio')->middleware('auth:api');
Route::post('updateaddress', 'API\UserController@update_address')->middleware('auth:api');
Route::get('details', 'API\UserController@details')->middleware('auth:api');
Route::get('profile/{id}','API\UserController@profile')->middleware('auth:api');

Route::get('tags/posts/{tag}','API\TagController@posts');

Route::post('new-post','API\PostController@new_post')->middleware('auth:api');
Route::post('like/{post_id}','API\PostController@like')->middleware('auth:api');
Route::post('comment','API\PostController@comment')->middleware('auth:api');
Route::get('postcomments/{postId}','API\PostController@postComments')->middleware('auth:api');
Route::get('postimages/{postId}','API\PostController@postImages')->middleware('auth:api');
Route::get('posts','API\PostController@posts')->middleware('auth:api');
Route::get('getuser/{id}','API\UserController@getUser')->middleware('auth:api');
Route::get('livesearch','API\LiveSearch@searchUser')->middleware('auth:api');
Route::post('friends','API\FriendController@friends');
Route::post('friendrequest','API\FriendRequestController@sendFriendRequest')->middleware('auth:api');
Route::post('checkfriendrequest','API\FriendRequestController@checkFriendRequest')->middleware('auth:api');
Route::get('friendrequests','API\FriendRequestController@friendRequests')->middleware('auth:api');
Route::post('acceptfriendrequest','API\FriendRequestController@acceptRequest')->middleware('auth:api');
Route::post('refusefriendrequest','API\FriendRequestController@refuseRequest')->middleware('auth:api');
Route::post('cancelfriendrequest','API\FriendRequestController@cancelFriendRequest')->middleware('auth:api');
Route::post('unfriend','API\FriendController@unFriend')->middleware('auth:api');
Route::post('messages','API\FriendController@messages')->middleware('auth:api');
Route::post('sendmessage','API\FriendController@sendMessage')->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
