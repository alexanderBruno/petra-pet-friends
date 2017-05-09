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
    public function index()
    {
      $email = Auth::user()->email;
      $user = DB::table('users')->where('email', $email)->first();
      return view('editprofile', ['user' => $user]);
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
      $email = Auth::user()->email;
      $user = DB::table('users')->where('email', $email)->first();
      if ($request->input('editprofile_name')) {
        DB::table('users')->where('email', $email)->update(['name' => $request->input('editprofile_name')]);
      }
      if ($request->input('editprofile_description')) {
        DB::table('users')->where('email', $email)->update(['description' => $request->input('editprofile_description')]);
      }
      if (Input::hasFile('editprofile_avatar'))
      {
        if ($user->avatar=="defecte.png") {
          $avatar = generateRandomString().".png";
        } else {
          $avatar = $user->avatar;
        }
        Image::make(Input::file('editprofile_avatar'))->widen(150)->save('images/avatars/'.$avatar);
        DB::table('users')->where('email', $email)->update(['avatar' => $avatar]);
      }
      if ($request->input('editprofile_type_pet')) {
        DB::table('users')->where('email', $email)->update(['type_pet' => $request->input('editprofile_type_pet')]);
      }

      DB::table('users')->where('email', $email)->update(['updated_at' => Carbon::now()]);

      $user = DB::table('users')->where('email', $email)->first();
      return view('editprofile', ['user' => $user]);
    }
}
