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

      $path = ("images/posts/".Auth::id());

      if (Auth::id() == $post->id_user) {
        DB::table('posts')->where('id', $id)->delete();
        File::delete($path.'/'.$post->photo);

        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
        if($previousurl=="/home" ) {
          return redirect()->action('HomeController@index')->with('confirmation', 'postdeleted');
        } elseif ($previousurl==("/profile"."/".$post->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $post->id_user])->with('confirmation', 'postdeleted');
        } else {
          return redirect()->action('HomeController@index')->with('confirmation', 'error');
        }
      }

      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
      if($previousurl=="/home" ) {
        return redirect()->action('HomeController@index')->with('confirmation', 'postnotdeleted');
      } elseif ($previousurl==("/profile"."/".Auth::id())) {
        return redirect()->action('ProfileController@index', ['id' => Auth::id()])->with('confirmation', 'postnotdeleted');
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'error');
      }


    }
}
