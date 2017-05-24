<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'IndexController@index');

Auth::routes();

Route::post('/map', 'MapController@addMarker');

Route::get('/map', 'MapController@mostra');

Route::get('/map/{type}', 'MapController@tria');

Route::get('/map/meus/{id}', 'MapController@meus');

Route::get('/home', 'HomeController@index');

Route::post('/home', 'HomeController@post');

Route::get('/home/likepost/{id}', 'HomeController@likepost');

Route::get('/home/droplikepost/{id}', 'HomeController@droplikepost');

Route::get('/profile/{id}', 'ProfileController@index');

Route::get('/profile/likepost/{id}', 'ProfileController@likepost');

Route::get('/profile/droplikepost/{id}', 'ProfileController@droplikepost');

Route::get('/editprofile/{id}', 'EditprofileController@index');

Route::post('/editprofile/{id}', 'EditprofileController@save');

Route::get('/editprofile/deleteuser/{id}', 'EditprofileController@deleteuser');

Route::get('/points','PointController@getList');//provisional

Route::get('/point/{id}','PointController@profile');

Route::post('/point/{id}','PointController@review');

Route::get('/point/likereview/{id}', 'PointController@likereview');

Route::get('/point/droplikereview/{id}', 'PointController@droplikereview');

Route::get('/editpoint/{id}', 'EditpointController@index');

Route::post('/editpoint/{id}', 'EditpointController@save');

Route::get('/deletepoint/{id}', 'DeletepointController@delete');

Route::get('/editreview/{id_point}/{id}', 'EditReviewController@index');

Route::post('/editreview/saved', 'EditReviewController@save');

Route::get('/deletereview/{id}', 'DeleteReviewController@delete');

Route::get('/editpost/{id}', 'EditpostController@index');

Route::post('/editpost/saved', 'EditpostController@save');

Route::get('/deletepost/{id}', 'DeletepostController@delete');

Route::get('/messages', 'MessageController@index');

Route::get('message/{id}', 'MessageController@chatHistory')->name('message.read');

Route::group(['prefix'=>'ajax', 'as'=>'ajax::'], function() {
   Route::post('message/send', 'MessageController@ajaxSendMessage')->name('message.new');
   Route::delete('message/delete/{id}', 'MessageController@ajaxDeleteMessage')->name('message.delete');
});

Route::get('/friends', 'FriendshipController@index');

Route::get('/friends/add/{id}', 'FriendshipController@add');

Route::get('/friends/delete/{id}', 'FriendshipController@delete');

Route::get('/friends/acceptadd/{id}', 'FriendshipController@acceptadd');

Route::get('/friends/denyadd/{id}', 'FriendshipController@denyadd');

Route::get('/friends/removeadd/{id}', 'FriendshipController@delete');

Route::get('/friends/allowadd/{id}', 'FriendshipController@delete');

Route::get('/contact', 'ContactController@index');

Route::post('/contact', 'ContactController@send');

Route::get('/admin', 'AdminController@index');
