<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ProfileController extends Controller
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

      $id = Auth::user()->id;
      $posts = DB::table('posts')
            ->leftJoin('users', 'posts.id_user', '=', 'users.id')
            ->select('posts.*', 'users.name', 'users.avatar')
            ->where('posts.id_user', $id)
            ->get();

      return view('profile', ['user' => $user, 'posts' => $posts]);
    }
}
