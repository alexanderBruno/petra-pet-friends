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

      $path = ("images/review/".$review->id."_".$review->id_point);

      if (Auth::id() == $review->id_user) {
        DB::table('reviews')->where('id', $id)->delete();
        File::delete($path.'/'.$review->photo);

        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);

        if ($previousurl==("/point"."/".$review->id_point)) {
          return redirect()->action('PointController@profile', ['id' => $review->id_point])->with('confirmation', 'reviewdeleted');
        } elseif ($previousurl==("/profile"."/".$review->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $review->id_user])->with('confirmation', 'reviewdeleted');
        } elseif ($previousurl==("/home")) {
          return redirect()->action('HomeController@index')->with('confirmation', 'reviewdeleted');
        } else {
          return redirect()->action('PointController@profile')->with('confirmation', 'error');
        }
      } else {
        $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
        if ($previousurl==("/point"."/".$review->id_point)) {
          return redirect()->action('PointController@profile', ['id' => $review->id_point])->with('confirmation', 'reviewnotdeleted');
        } elseif ($previousurl==("/profile"."/".$review->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $review->id_user])->with('confirmation', 'reviewnotdeleted');
        } elseif ($previousurl==("/home")) {
          return redirect()->action('HomeController@index')->with('confirmation', 'reviewnotdeleted');
        } else {
          return redirect()->action('PointController@profile')->with('confirmation', 'error');
        }
      }

    }
}
