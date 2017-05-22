<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Points;
use Auth, DB, Image, Input, Carbon\Carbon;


class MapController extends Controller
{
  public function mostra($type=''){
    if ($type == ''){
      $all = Points::where('published', '1')->get();
      $all->toJson();
      return view('map', ['all' => $all]);
    }else {
      $all = Points::where([
        ['published', '=', '1'],
        ['type_point', '=', $type],
        ])->get();
      $all->toJson();
      return view('map', ['all' => $all]);
    }
  }
  public function post(Request $request)
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

    if ($request->input('home_post')) {

      $path = ("images/posts/".Auth::id());

      if(!File::exists($path)) {
        File::makeDirectory($path, 0775);
      }

      if (Input::hasFile('home_post_photo'))
      {
        $photo = generateRandomString().".png";
        Image::make(Input::file('home_post_photo'))->save($path.'/'.$photo);
        DB::table('posts')->insert(['photo' => $photo, 'id_user' => Auth::id(), 'content' => $request->input('home_post'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
      }
      else {
        DB::table('posts')->insert(['id_user' => Auth::id(), 'content' => $request->input('home_post'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
      }
    }

    return redirect()->action('HomeController@index')->with('confirmation', 'postposted');

  }


}
