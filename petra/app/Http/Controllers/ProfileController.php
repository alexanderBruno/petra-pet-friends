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

      return view('profile', ['user' => $user, 'posts' => $posts, 'likesdone' => $likesdone, 'friendship' => $friendship, 'userE' => $userE, 'usersR' => $usersR]);
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
