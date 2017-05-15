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
      $reviewPermission = False;
    	$point = Points::find($id);

    	$reviews = DB::table('reviews')
            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->where('reviews.id_point', $id)
            ->get();

      for ($i=0; $i < sizeof($reviews); $i++) { 
        if ($reviews[$i]->id_user == Auth::id()) {
          $reviewPermission = True;
        }
      }

      $score = $this -> getScore($id);

      DB::table('points')
            ->where('id', $id)
            ->update(['score' => $score]);

    	return view('point', ['point' => $point, 'reviews' => $reviews, 'score'=>$score,'reviewPermission'=> $reviewPermission, 'loged' => Auth::id()]);

    }

    public function review($id, Request $request)
    {
      $confirmation = False;
      //DD($request->input('rating'));
      if ($request->input('point_review') || $request->input('rating')) {
        $content = "";
        
        if ($request->input('point_review')) {
          $content = $request->input('point_review');
        }

          DB::table('reviews')->insert(['id_user' => Auth::id(), 'id_point' => $request->input('point_review_id'), 'content' => $content ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

          $last_review = DB::table('reviews')->orderBy('id', 'desc')->first();

          if ($request->input('rating')) {
            DB::table('scores_list')->insert(['id_user' => Auth::id(), 
            'id_point' => $request->input('point_review_id'),'id_review' =>
            $last_review->id, 'score'=>$request->input('rating'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
          }
          
          $confirmation = True;

      }

      $point = Points::find($id);

    	$reviews = DB::table('reviews')
            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->where('reviews.id_point', $id)
            ->get();

      $score = $this -> getScore($id);
    	return view('point', ['point' => $point, 'reviews' => $reviews, 'confirmation' => $confirmation, 'score'=>$score, 'loged' => Auth::id()]);
    }

    public function getScore($id)
    {
      $valoration = DB::table('scores_list')->select('scores_list.score')->where('id_point', $id)->get();
      $score_addition = 0;

      for ($i=0; $i < sizeof($valoration); $i++) { 
        $score_addition = $score_addition + $valoration[$i]->score;
      }

      if (sizeof($valoration) < 0) {
        $score = $score_addition/sizeof($valoration);
      return $score;
      }else{
        return 0;
      }
      
    }

}
