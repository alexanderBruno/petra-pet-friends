<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Image, Input, Carbon\Carbon, File;
use App\User;

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
      $lastposts = DB::table('posts')
            ->leftJoin('users', 'posts.id_user', '=', 'users.id')
            ->select('posts.*', 'users.name', 'users.avatar', 'users.posts_privacy')
            ->orderBy('posts.id', 'desc')
            ->limit(10)
            ->get();

      $likesdone = DB::table('likeposts_list')->where('id_user', Auth::id())->get();

      $userE = User::where('id', Auth::id())->first();

      $usersR = User::leftJoin('posts', 'posts.id_user', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.avatar', 'users.posts_privacy')
            ->get();

      $reviews = DB::table('reviews')
            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
						->leftJoin('scores_list', function ($join) {
                $join->on('reviews.id_user', '=', 'scores_list.id_user')->on('reviews.id_point', '=', 'scores_list.id_point');
            })
            ->leftJoin('points', 'reviews.id_point', '=', 'points.id')
            ->select('reviews.*', 'users.name', 'users.avatar', 'scores_list.score', 'points.name as namepoint')
						->orderBy('reviews.id', 'desc')
            ->limit(10)
            ->get();

      $likesdonereview = DB::table('likereview_list')->where('id_user', Auth::id())->get();

      $up = DB::table('posts')
            ->leftJoin('users', 'posts.id_user', '=', 'users.id')
            ->select('posts.*', 'users.name', 'users.avatar', 'users.posts_privacy')
            ->orderBy('posts.id', 'desc')
            ->limit(20)
            ->get();

      $ur = DB::table('reviews')
            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
						->leftJoin('scores_list', function ($join) {
                $join->on('reviews.id_user', '=', 'scores_list.id_user')->on('reviews.id_point', '=', 'scores_list.id_point');
            })
            ->leftJoin('points', 'reviews.id_point', '=', 'points.id')
            ->select('reviews.*', 'users.name', 'users.avatar', 'scores_list.score', 'points.name as namepoint')
						->orderBy('reviews.id', 'desc')
            ->limit(20)
            ->get();

      $updates = collect();
      $updates->push($up);
      $updates->push($ur);
      $updates = $updates->sortByDesc('created_at');
      $updates = $updates->all();

      return view('home', ['lastposts' => $lastposts, 'likesdone' => $likesdone, 'userE' => $userE, 'usersR' => $usersR, 'reviews' => $reviews, 'likesdonereview' => $likesdonereview, 'updates' => $updates]);
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

    public function likepost($id)
    {
      $existslike = DB::table('likeposts_list')->where('id_user', Auth::id())->where('id_post', $id)->first();

      if (count($existslike)==0) {
        DB::table('posts')->where('id', $id)->increment('likes', 1);
        DB::table('likeposts_list')->insert(['id_user' => Auth::id(), 'id_post' => $id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
      }
    }

    public function droplikepost($id)
    {
      $existslike = DB::table('likeposts_list')->where('id_user', Auth::id())->where('id_post', $id)->first();

      if (count($existslike)!=0) {
        DB::table('posts')->where('id', $id)->decrement('likes', 1);
        DB::table('likeposts_list')->where('id_user', Auth::id())->where('id_post', $id)->delete();
      }
    }
}
