<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, File;

class DeletepostController extends Controller
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



    public function delete($id)
    {
      $post = DB::table('posts')->where('id', $id)->first();

      $path = ("images/posts/".$post->id_user);

      if (Auth::id() == $post->id_user or Auth::user()->type_user=="admin") {
        DB::table('posts')->where('id', $id)->delete();
        File::delete($path.'/'.$post->photo);

        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
        if($previousurl=="/home" ) {
          return redirect()->action('HomeController@index')->with('confirmation', 'postdeleted');
        } elseif ($previousurl==("/profile"."/".$post->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $post->id_user])->with('confirmation', 'postdeleted');
        } elseif($previousurl=="/admin" ) {
          return redirect()->action('AdminController@index')->with('confirmation', 'postdeleted');
        } else {
          return redirect()->action('HomeController@index');
        }
      }

      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
      if($previousurl=="/home" ) {
        return redirect()->action('HomeController@index')->with('confirmation', 'postnotdeleted');
      } elseif ($previousurl==("/profile"."/".$post->id_user)) {
        return redirect()->action('ProfileController@index', ['id' => $post->id_user])->with('confirmation', 'postnotdeleted');
      } elseif($previousurl=="/admin" ) {
        return redirect()->action('AdminController@index')->with('confirmation', 'postnotdeleted');
      } else {
        return redirect()->action('HomeController@index');
      }


    }
}
