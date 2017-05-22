<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Image, Input, Carbon\Carbon, File;

class EditReviewController extends Controller
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

     public function index($id_point, $id)
    {
      $review = DB::table('reviews')
      ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
      ->select('reviews.*', 'users.name'  )
      ->where('reviews.id', $id)
      ->first();

      if (Auth::id() == $review->id_user) {
        return view('editreview', ['review' => $review]);
      }
      else {
        return redirect()->action('PointController@profile', ['id' => $id_point])->with('confirmation', 'reviewnotedited');
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
      $id = $request->input('editreview_id');
      $review = DB::table('reviews')->where('id', $id)->first();
      $path = ("images/reviews/".$review->id_point);

      if (Auth::id() == $review->id_user) {
        if ($request->input('editreview_content')) {
          DB::table('reviews')->where('id', $id)->update(['content' => $request->input('editreview_content')]);
        }

        if ($request->input('rating')) {

            DB::table('scores_list')->where('id_review',$id)->where('id_user',$review->id_user)
                    ->update(['score'=>intval($request->input('rating'))]);
          }

        if (Input::hasFile('editreview_photo')) {
          if ($review->photo==NULL) {
            $photo = generateRandomString().".png";

          } else {
            $photo = $review->photo;
          }
          Image::make(Input::file('editreview_photo'))->save($path.'/'.$photo);
          DB::table('reviews')->where('id', $id)->update(['photo' => $photo]);
        }

        DB::table('reviews')->where('id', $id)->update(['updated_at' => Carbon::now()]);

        $previousurl=parse_url($request->input('editreview_previousurl'), PHP_URL_PATH);
        if($previousurl==("/point"."/".$review->id_point)) {
          return redirect()->action('PointController@profile', ['id' => $review->id_point])->with('confirmation', 'reviewedited');
        } elseif ($previousurl==("/profile"."/".$review->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $review->id_user])->with('confirmation', 'reviewedited');
        } elseif ($previousurl==("/home")) {
          return redirect()->action('HomeController@index')->with('confirmation', 'reviewedited');
        } else {
          return redirect()->action('HomeController@index')->with('confirmation', 'error');
        }

      }

      $previousurl=parse_url($request->input('editreview_previousurl'), PHP_URL_PATH);

      if ($previousurl==("/point"."/".$review->id_point)) {
        return redirect()->action('PointController@profile', ['id' => $review->id_point])->with('confirmation', 'reviewnotedited');
      } elseif ($previousurl==("/profile"."/".$review->id_user)) {
        return redirect()->action('ProfileController@index', ['id' => $review->id_user])->with('confirmation', 'reviewnotedited');
      } elseif ($previousurl==("/home")) {
        return redirect()->action('HomeController@index')->with('confirmation', 'reviewnotedited');
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'error');
      }

    }
}
