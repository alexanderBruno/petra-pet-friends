<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Image, Input, Carbon\Carbon;

class HomeController extends Controller
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
        return view('home');
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
        if (Input::hasFile('home_post_photo'))
        {
          $photo = generateRandomString().".png";
          Image::make(Input::file('home_post_photo'))->save('images/posts/'.$photo);
          DB::table('posts')->insert(['photo' => $photo, 'id_user' => Auth::id(), 'content' => $request->input('home_post'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
        else {
          DB::table('posts')->insert(['id_user' => Auth::id(), 'content' => $request->input('home_post'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
      }

      return view('home');
    }
}
