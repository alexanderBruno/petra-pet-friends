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
        return view('editpoint', ['point' => $point]);
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
      if (Auth::id() == $id or Auth::user()->type_user=="admin") {
        $point = DB::table('points')->where('id', $id)->first();
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
        }
        if ($request->input('editpoint_published')) {
          DB::table('points')->where('id', $id)->update(['published' => $request->input('editpoint_published')]);
        }

        DB::table('points')->where('id', $id)->update(['updated_at' => Carbon::now()]);

        $point = DB::table('points')->where('id', $id)->first();
        return view('editpoint', ['point' => $point]);
      } else {
        return redirect()->action('ProfileController@index', ['id' => Auth::id()])->with('confirmation', 'pointnotedited');
      }
    }
}
