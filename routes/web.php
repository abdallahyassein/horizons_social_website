<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('posts');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/profile/{username}','UserController@profile')->name('profile');


Route::get('/updateavatarpage', 'UserController@avatarPage')->name('updateavatarpage')->middleware('auth');
Route::post('profile/updateavatar', 'UserController@update_avatar')->middleware('auth');


Route::get('/updatebiopage', 'UserController@bioPage')->name('updatebiopage')->middleware('auth');
Route::post('profile/updatebio', 'UserController@update_bio')->middleware('auth');


Route::get('/updateaddresspage', 'UserController@addressPage')->name('updateaddresspage')->middleware('auth');
Route::post('profile/updateaddress', 'UserController@update_address')->middleware('auth');


Route::post('newpost', 'PostController@new_post')->name('newpost')->middleware('auth');
Route::get('like/{post_id}','PostController@like');
Route::post('comment','PostController@comment')->name('comment');

Route::get('tag/posts/{tag}','TagController@posts');

Route::get('posts','PostController@posts');


Route::get('friends/{username}','FriendController@friends');
Route::get('friendrequestspage','FriendRequestController@friendRequests')->middleware('auth');
Route::post('friendrequest','FriendRequestController@sendFriendRequest')->name('friendrequest')->middleware('auth');
Route::delete('friendrequest/{id}', 'FriendRequestController@destroy')->name('friendrequest.destroy');
Route::delete('frienddelete/{id}', 'FriendController@destroy')->name('friend.destroy');


Route::delete('friendrequestignore/{id}', 'FriendRequestController@refuseRequest')->name('friendrequest.refuserequest');
Route::post('friendrequestaccept/{id}', 'FriendRequestController@acceptRequest')->name('friendrequest.acceptrequest');

Route::get('messages/{friend_id}', 'FriendController@message')->name('friend.message');
Route::post('sendmessage','FriendController@sendMessage')->name('send.message');

Route::get('/search_friends', 'LiveSearch@index')->middleware('auth');
Route::get('/search_friends/action','LiveSearch@action')->name('live_search.action')->middleware('auth');
