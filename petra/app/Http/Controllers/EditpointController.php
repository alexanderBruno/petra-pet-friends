<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Image, Input, Carbon\Carbon, URL;

class EditpointController extends Controller
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
      $point = DB::table('points')
      ->where('points.id', $id)
      ->first();

      if (Auth::id() == $point->id_user or Auth::user()->type_user=="admin") {
        $services = DB::table('services_list')->get();

        return view('editpoint', ['point' => $point, 'services' => $services]);
      }
      else {
        return redirect()->action('ProfileController@index', ['id' => Auth::id()])->with('confirmation', 'pointnotedited');
      }

    }

    public function save($id, Request $request)
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

      $point = DB::table('points')->where('id', $id)->first();

      if (Auth::id() == $point->id_user or Auth::user()->type_user=="admin") {
        if ($request->input('editpoint_name')) {
          DB::table('points')->where('id', $id)->update(['name' => $request->input('editpoint_name')]);
        }
        if ($request->input('editpoint_description')) {
          DB::table('points')->where('id', $id)->update(['description' => $request->input('editpoint_description')]);
        }
        if (Input::hasFile('editpoint_avatar'))
        {
          if ($point->avatar=="defecte_pi.png") {
            $avatar = generateRandomString().".png";
          } else {
            $avatar = $point->avatar;
          }
          Image::make(Input::file('editpoint_avatar'))->widen(150)->save('images/avatars/points/'.$avatar);
          DB::table('points')->where('id', $id)->update(['avatar' => $avatar]);
        }
        if ($request->input('editpoint_lat')) {
          DB::table('points')->where('id', $id)->update(['latitude' => $request->input('editpoint_lat')]);
        }
        if ($request->input('editpoint_lon')) {
          DB::table('points')->where('id', $id)->update(['longitude' => $request->input('editpoint_lon')]);
        }
        if ($request->input('editpoint_type_point')) {
          DB::table('points')->where('id', $id)->update(['type_point' => $request->input('editpoint_type_point')]);
          $flag = DB::table('markers_list')
            ->select('marker_img')
            ->where('marker_code', $request->input('editpoint_type_point'))
            ->get();
          $flag = $flag[0]->marker_img;
          DB::table('points')->where('id', $id)->update(['flag' => $flag]);
        }
        if ($request->input('editpoint_published')) {
          DB::table('points')->where('id', $id)->update(['published' => $request->input('editpoint_published')]);
        }
        $serveis = '';
        $id_check = 1;
        $primer = 0;
        while ($id_check <= 20){
          if ($request->input('edit_point_serveis'.$id_check)){
            if ($primer == 0){
              $serveis .= $request->input('edit_point_serveis'.$id_check);
            }else{
              $serveis .='-'.$request->input('edit_point_serveis'.$id_check);
            }
              $primer += 1;
          }
          $id_check += 1;
        }
        //dd($serveis);

        DB::table('points')->where('id', $id)->update(['services_list' => $serveis]);



        DB::table('points')->where('id', $id)->update(['updated_at' => Carbon::now()]);

        $point = DB::table('points')->where('id', $id)->first();
        $services = DB::table('services_list')->get();
        return view('editpoint', ['point' => $point, 'services' => $services]);
      } else {
        return redirect()->action('ProfileController@index', ['id' => Auth::id()])->with('confirmation', 'pointnotedited');
      }
    }
}
