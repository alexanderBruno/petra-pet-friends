<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Points;
use Auth, DB, Image, Input, Carbon\Carbon;


class MapController extends Controller
{

  public function mostra(){
    $all = Points::where('published', '1')->get();
    $all->toJson();
    $services = DB::table('services_list')->get();
    $markers = DB::table('markers_list')->get();

    return view('map', ['all' => $all, 'services' => $services, 'markers' => $markers]);
  }

  public function tria($type=''){
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

  public function meus($id){
    if ($id == Auth::id()){
      $all = Points::where([
        ['published', '=', '1'],
        ['id_user', '=', $id],
        ])->get();
      $all->toJson();
    }else{
      return redirect()->action('MapController@mostra')->with('mesage', 'diferentID');
    }
    $services = DB::table('services_list')->get();
    $markers = DB::table('markers_list')->get();

      return view('map', ['all' => $all, 'services' => $services, 'markers' => $markers]);
  }

  public function addMarker(Request $request)
  {
    //return redirect()->action('MapController@mostra')->with('mesage', 'notLoged');
    // return redirect()->action('HomeController@index');//->with('mesage', 'notLoged');
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //if ($request->input('point_form')) {

      $path = ("images/avatars/points/");

      if (Auth::guest()){
        return redirect()->action('MapController@mostra')->with('mesage', 'notLoged');
      }else{
        $id_user = Auth::id();
      }


      //Must: point_name, latitude, longitude
      //May: point_description, point_photo, point_serveis, type_point
      if (strlen($request->input('point_name')) > 1 and strlen($request->input('latitude')) >= 6 and strlen($request->input('longitude')) >= 6){

        $flag = NULL;
        if (strlen($request->input('type_point')) > 1 and $request->input('type_point') != 'NULL'){
          $flag = DB::table('markers_list')
            ->select('marker_img')
            ->where('marker_code', $request->input('type_point'))
            ->get();
          $flag = $flag[0]->marker_img;

        }
        $serveis = '';
        $id_check = 1;
        if (strlen($request->input('point_serveis'.$id_check)) >= 1){

          do {
            if ($id_check == 1){
              $serveis .= $request->input('point_serveis'.$id_check);
            }else{
              $serveis .='-'.$request->input('point_serveis'.$id_check);
            }
              $id_check += 1;
          } while ($request->input('point_serveis'.$id_check));
        }

        //dd($serveis);
        $description = '';
        if (strlen($request->input('point_description')) > 0){
          $description = $request->input('point_description');
        }

        if (Input::hasFile('point_photo')){
          $photo = generateRandomString().".png";
          Image::make(Input::file('point_photo'))->save($path.$photo);

          DB::table('points')->insert(['name' => $request->input('point_name'),
          'description' => $description,
          'services_list' => $serveis,
          'type_point' => $request->input('type_point'),
          'published' => 2,
          'latitude' => floatval($request->input('latitude')),
          'longitude' => floatval($request->input('longitude')),
          'avatar' => $photo,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          'flag' => $flag,
          'id_user' => $id_user]);

        }else{
          DB::table('points')->insert(['name' => $request->input('point_name'),
          'description' => $description,
          'services_list' => $serveis,
          'type_point' => $request->input('type_point'),
          'published' => 2,
          'latitude' => floatval($request->input('latitude')),
          'longitude' => floatval($request->input('longitude')),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          'flag' => $flag,
          'id_user' => $id_user]);
        }




    }else{
      return redirect()->action('MapController@mostra')->with('mesage', 'faltaInfo');
    }

    return redirect()->action('MapController@mostra')->with('mesage', 'addMarker');

 }
}
