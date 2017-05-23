<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Carbon\Carbon;
use App\User;


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
    public function index($id)
    {
      $user = DB::table('users')->where('id', $id)->first();

      $posts = DB::table('posts')
            ->leftJoin('users', 'posts.id_user', '=', 'users.id')
            ->select('posts.*', 'users.name', 'users.avatar', 'users.posts_privacy')
            ->where('posts.id_user', $id)
            ->orderBy('posts.id', 'desc')
            ->get();

      $likesdone = DB::table('likeposts_list')->where('id_user', $id)->get();

      $friendship = DB::table('friendships')->where('sender_id', Auth::id())->where('recipient_id', $id)->orWhere('recipient_id', Auth::id())->where('sender_id', $id)->first();

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
            ->where('reviews.id_user', $id)
						->orderBy('reviews.id', 'desc')
            ->get();

      $likesdonereview = DB::table('likereview_list')->where('id_user', Auth::id())->get();

      $yourpoints = DB::table('points')
            ->where('points.id_user', $id)
            ->where('points.published', 1)
            ->orderBy('points.id', 'desc')
            ->get();

      return view('profile', ['user' => $user, 'posts' => $posts, 'likesdone' => $likesdone, 'friendship' => $friendship, 'userE' => $userE, 'usersR' => $usersR, 'reviews' => $reviews, 'likesdonereview' => $likesdonereview, 'yourpoints' => $yourpoints]);
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
