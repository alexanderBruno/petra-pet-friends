<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, File;

class DeleteReviewController extends Controller
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
      $review = DB::table('reviews')->where('id', $id)->first();

      $path = ("images/reviews/".$review->id_user);

      if (Auth::id() == $review->id_user or Auth::user()->type_user=="admin") {
        DB::table('reviews')->where('id', $id)->delete();
        File::delete($path.'/'.$review->photo);

        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);

        if ($previousurl==("/point"."/".$review->id_point)) {
          return redirect()->action('PointController@profile', ['id' => $review->id_point])->with('confirmation', 'reviewdeleted');
        } elseif ($previousurl==("/profile"."/".$review->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $review->id_user])->with('confirmation', 'reviewdeleted');
        } elseif ($previousurl==("/home")) {
          return redirect()->action('HomeController@index')->with('confirmation', 'reviewdeleted');
        } elseif($previousurl=="/admin" ) {
          return redirect()->action('AdminController@index')->with('confirmation', 'reviewnotdeleted');
        } else {
          return redirect()->action('PointController@profile');
        }
      } else {
        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
        if ($previousurl==("/point"."/".$review->id_point)) {
          return redirect()->action('PointController@profile', ['id' => $review->id_point])->with('confirmation', 'reviewnotdeleted');
        } elseif ($previousurl==("/profile"."/".$review->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $review->id_user])->with('confirmation', 'reviewnotdeleted');
        } elseif ($previousurl==("/home")) {
          return redirect()->action('HomeController@index')->with('confirmation', 'reviewnotdeleted');
        } elseif($previousurl=="/admin" ) {
          return redirect()->action('AdminController@index')->with('confirmation', 'reviewnotdeleted');
        } else {
          return redirect()->action('PointController@profile');
        }
      }

    }
}
