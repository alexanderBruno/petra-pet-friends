<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Image, Input, Carbon\Carbon, URL;

class EditpostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $post = DB::table('posts')
      ->leftJoin('users', 'posts.id_user', '=', 'users.id')
      ->select('posts.*', 'users.name'  )
      ->where('posts.id', $id)
      ->first();

      if (Auth::id() == $post->id_user or Auth::user()->type_user=="admin") {
        return view('editpost', ['post' => $post]);
      }
      else {
        return redirect()->action('HomeController@index')->with('confirmation', 'postnotedited');
      }

    }

    public function save(Request $request)
    {
      function generateRandomString($length = 10) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
      }
      $id = $request->input('editpost_id');
      $post = DB::table('posts')->where('id', $id)->first();
      $path = ("images/posts/".$post->id_user);
      if (Auth::id() == $post->id_user or Auth::user()->type_user=="admin") {
        if ($request->input('editpost_content')) {
          DB::table('posts')->where('id', $id)->update(['content' => $request->input('editpost_content')]);
        }
        if (Input::hasFile('editpost_photo')) {
          if ($post->photo==NULL) {
            $photo = generateRandomString().".png";
          } else {
            $photo = $post->photo;
          }
          Image::make(Input::file('editpost_photo'))->save($path.'/'.$photo);
          DB::table('posts')->where('id', $id)->update(['photo' => $photo]);
        }

        DB::table('posts')->where('id', $id)->update(['updated_at' => Carbon::now()]);

        $previousurl=parse_url($request->input('editpost_previousurl'), PHP_URL_PATH);
        if($previousurl=="/home" ) {
          return redirect()->action('HomeController@index')->with('confirmation', 'postedited');
        } elseif ($previousurl==("/profile"."/".$post->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $post->id_user])->with('confirmation', 'postedited');
        } elseif($previousurl=="/admin" ) {
          return redirect()->action('AdminController@index')->with('confirmation', 'postedited');
        } else {
          return redirect()->action('HomeController@index')->with('confirmation', 'error');
        }

      }

      $previousurl=parse_url($request->input('editpost_previousurl'), PHP_URL_PATH);
      if($previousurl=="/home" ) {
        return redirect()->action('HomeController@index')->with('confirmation', 'postnotedited');
      } elseif ($previousurl==("/profile"."/".$post->id_user)) {
        return redirect()->action('ProfileController@index', ['id' => $post->id_user])->with('confirmation', 'postnotedited');
      } elseif($previousurl=="/admin" ) {
        return redirect()->action('AdminController@index')->with('confirmation', 'postnotedited');
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'error');
      }
    }
}
