<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, File;

class DeletepointController extends Controller
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
      $point = DB::table('points')->where('id', $id)->first();

      $path = ("images/avatars/points/");

      if (Auth::id() == $point->id_user or Auth::user()->type_user=="admin") {
        DB::table('points')->where('id', $id)->delete();
        if ($point->avatar!="defecte_pi.png") {
          File::delete($path.'/'.$point->avatar);
        }
        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
        if($previousurl=="/home" ) {
          return redirect()->action('HomeController@index')->with('confirmation', 'pointdeleted');
        } elseif ($previousurl==("/profile"."/".$point->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $point->id_user])->with('confirmation', 'pointdeleted');
        } elseif($previousurl=="/admin" ) {
          return redirect()->action('AdminController@index')->with('confirmation', 'pointdeleted');
        } else {
          return redirect()->action('HomeController@index')->with('confirmation', 'error');
        }
      }

      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
      if($previousurl=="/home" ) {
        return redirect()->action('HomeController@index')->with('confirmation', 'pointnotdeleted');
      } elseif ($previousurl==("/profile"."/".$point->id_user)) {
        return redirect()->action('ProfileController@index', ['id' => $point->id_user])->with('confirmation', 'pointnotdeleted');
      } elseif($previousurl=="/admin" ) {
        return redirect()->action('AdminController@index')->with('confirmation', 'pointnotdeleted');
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'error');
      }


    }
}
