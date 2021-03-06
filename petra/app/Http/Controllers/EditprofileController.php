<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Image, Input, Carbon\Carbon;

class EditprofileController extends Controller
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
      if (Auth::id() == $id or Auth::user()->type_user=="admin") {
        $user = DB::table('users')->where('id', $id)->first();
        return view('editprofile', ['user' => $user]);
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'error');
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
        $user = DB::table('users')->where('id', $id)->first();
        if ($request->input('editprofile_name')) {
          DB::table('users')->where('id', $id)->update(['name' => $request->input('editprofile_name')]);
        }
        if ($request->input('editprofile_description')) {
          DB::table('users')->where('id', $id)->update(['description' => $request->input('editprofile_description')]);
        }
        if (Input::hasFile('editprofile_avatar'))
        {
          if ($user->avatar=="defecte.png") {
            $avatar = generateRandomString().".png";
          } else {
            $avatar = $user->avatar;
          }
          Image::make(Input::file('editprofile_avatar'))->widen(150)->save('images/avatars/'.$avatar);
          DB::table('users')->where('id', $id)->update(['avatar' => $avatar]);
        }
        if ($request->input('editprofile_type_pet')) {
          DB::table('users')->where('id', $id)->update(['type_pet' => $request->input('editprofile_type_pet')]);
        }
        if ($request->input('editprofile_postprivacy')) {
          DB::table('users')->where('id', $id)->update(['posts_privacy' => $request->input('editprofile_postprivacy')]);
        }

        DB::table('users')->where('id', $id)->update(['updated_at' => Carbon::now()]);

        $user = DB::table('users')->where('id', $id)->first();
        return view('editprofile', ['user' => $user]);
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'error');
      }
    }


    public function deleteuser($id)
    {
      if (Auth::id() == $id or Auth::user()->type_user=="admin") {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('logout');
      } else {
        return redirect()->action('HomeController@index')->with('confirmation', 'usernotdeleted');
      }
    }
}
