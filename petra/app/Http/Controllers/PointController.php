<?php

namespace App\Http\Controllers;

//Model Points
use App\Points;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Auth, Carbon\Carbon;


class PointController extends Controller
{

	/**
	 * Provisional
	 * el objetivo es poder acceder a los perfiles de los puntos de interes.
	 */
    public function getList()
    {

    	$points = Points::all();
    	return view('listPoints', ['points' => $points]);
    }

    /**
     * $id es la id que pasamos por la URL
     */
    public function profile($id)
    {

    	$point = Points::find($id);

    	$reviews = DB::table('reviews')
            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->where('reviews.id_point', $id)
            ->get();


    	return view('point', ['point' => $point, 'reviews' => $reviews]);

    }

    public function review($id, Request $request)
    {
      $confirmation = False;
      if ($request->input('point_review')) {
          DB::table('reviews')->insert(['id_user' => Auth::id(), 'id_point' => $request->input('point_review_id'), 'content' => $request->input('point_review'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
          $confirmation = True;
      }

      $point = Points::find($id);

    	$reviews = DB::table('reviews')
            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->where('reviews.id_point', $id)
            ->get();

    	return view('point', ['point' => $point, 'reviews' => $reviews, 'confirmation' => $confirmation]);
    }
}
