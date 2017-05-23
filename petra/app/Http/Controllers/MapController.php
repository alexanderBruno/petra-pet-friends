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
    }else {
      $all = Points::where([
        ['published', '=', '1'],
        ['type_point', '=', $type],
        ])->get();
      $all->toJson();
    }
    $services = DB::table('services_list')->get();
    $markers = DB::table('markers_list')->get();

      return view('map', ['all' => $all, 'services' => $services, 'markers' => $markers]);
  }


  public function addMarker(Request $request)
  {
    return redirect()->action('MapController@mostra')->with('mesage', 'notLoged');
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if ($request->input('point_form')) {

      $path = ("images/avatars/");
      if (Auth::guest()){
        return redirect()->action('MapController@mostra')->with('mesage', 'notLoged');
      }else{
        $id_user = Auth::id();
      }


      //Must: point_name, latitude, longitude
      //May: point_description, point_photo, point_serveis, type_point
      if ($request->input('point_name') && $request->input('latitude') && $request->input('latitude')){
        if (Input::hasFile('point_photo'))
        {
          $photo = generateRandomString().".png";
          Image::make(Input::file('point_photo'))->save($path.$photo);
          DB::table('points')->insert(['photo' => $photo, 'id_user' => Auth::id(), 'content' => $request->input('home_post'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
        else {

          DB::table('posts')->insert(['id_user' => Auth::id(), 'content' => $request->input('home_post'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }

    }else{
      return redirect()->action('MapController@mostra')->with('mesage', 'faltaInfo');
    }

    return redirect()->action('MapController@mostra')->with('mesage', 'addmarker');
    }// formulari
  }// request


}
