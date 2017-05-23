<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Carbon\Carbon;
use App\User;


class AdminController extends Controller
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
      if (Auth::user()->type_user=="admin") {
        $users = DB::table('users')->orderBy('users.name', 'asc')->get();

        $points = DB::table('points')->orderBy('points.name', 'asc')->get();

        $posts = DB::table('posts')
              ->leftJoin('users', 'posts.id_user', '=', 'users.id')
              ->select('posts.*', 'users.name', 'users.avatar')
              ->orderBy('users.name', 'asc')
              ->get();

        $reviews = DB::table('reviews')
              ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
  						->leftJoin('scores_list', function ($join) {
                  $join->on('reviews.id_user', '=', 'scores_list.id_user')->on('reviews.id_point', '=', 'scores_list.id_point');
              })
              ->leftJoin('points', 'reviews.id_point', '=', 'points.id')
              ->select('reviews.*', 'users.name', 'users.avatar', 'scores_list.score', 'points.name as namepoint')
  						->orderBy('users.name', 'asc')
              ->get();

        return view('admin', ['users' => $users, 'points' => $points, 'posts' => $posts, 'reviews' => $reviews]);
      } else {
        return redirect()->action('HomeController@index');
      }
    }

}
