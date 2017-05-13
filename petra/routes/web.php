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

Route::get('/users', 'usersbbdd@select');

Route::get('/map', 'MapController@mostra');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/home', 'HomeController@post');

Route::get('/home/likepost/{id}', 'HomeController@likepost');

Route::get('/home/droplikepost/{id}', 'HomeController@droplikepost');

Route::get('/profile/{id}', 'ProfileController@index');

Route::get('/editprofile', 'EditprofileController@index');

Route::post('/editprofile', 'EditprofileController@save');

Route::get('/points','PointController@getList');//provisional

Route::get('/point/{id}','PointController@profile');

Route::post('/point/{id}','PointController@review');

Route::get('/editpost/{id}', 'EditpostController@index');

Route::post('/editpost/saved', 'EditpostController@save');

Route::get('/deletepost/{id}', 'DeletepostController@delete');
