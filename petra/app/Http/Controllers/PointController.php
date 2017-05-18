<?php

namespace App\Http\Controllers;

//Model Points
use App\Points;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, DB, Image, Input, Carbon\Carbon, File;


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
            ->join('users', 'reviews.id_user', '=', 'users.id')
            ->join('scores_list','reviews.id_user','=','scores_list.id_user')
            ->select('reviews.*', 'users.name', 'users.avatar','scores_list.score')
            ->where('reviews.id_point', $id)
            ->get();

      $score = $this -> getScore($id);

      DB::table('points')
            ->where('id', $id)
            ->update(['score' => $score]);

      $services = $this -> getIconsServices($point->services_list);


    	return view('point', ['point' => $point, 'reviews' => $reviews, 'score'=>$score,'reviewPermission'=> $reviewPermission, 'loged' => Auth::id(), 'services'=>$services]);

    }

    public function review($id, Request $request)
    {
      
      $review = DB::table('reviews')->where('id', $id)->first();
      $confirmation = False;
//path a la carpeta donde guardamos las imagenes en este ejemplo /images/reviews/1
      $path = ("images/reviews/".$id);

      if ($request->input('point_review') || $request->input('rating')) {
        $content = "";
        
        //en caso de que no exista el directorio para este ounto, lo creamos
        if(!File::exists($path)) {
          File::makeDirectory($path, 0775);
        }
        //si el campo point_review esta lleno se coge el valor, en caso e que sea null, se queda el de la variable $content
        if ($request->input('point_review')) {
          $content = $request->input('point_review');
        }

        if (Input::hasFile('point_review_photo')){
            
          $photo = $this -> generateRandomString().".png";
         
          Image::make(Input::file('point_review_photo'))->save($path.'/'.$photo);
          DB::table('reviews')->insert(['id_user' => Auth::id(), 'id_point' => $request->input('point_review_id'), 'content' => $content ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'photo' => $photo]);
        }
        else {
          DB::table('reviews')->insert(['id_user' => Auth::id(), 'id_point' => $request->input('point_review_id'), 'content' => $content ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
          

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
      $services = $this -> getIconsServices($point->services_list);

    	return view('point', ['point' => $point, 'reviews' => $reviews, 'confirmation' => $confirmation, 'score'=>$score, 'loged' => Auth::id(), 'services' => $services]);
    }

    public function generateRandomString($length = 10) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
      }

    public function getScore($id)
    {
      $valoration = DB::table('scores_list')->select('scores_list.score')->where('id_point', $id)->get();
      $score_addition = 0;

      for ($i=0; $i < sizeof($valoration); $i++) { 
        $score_addition = $score_addition + $valoration[$i]->score;
      }

      if (sizeof($valoration) > 0) {
        $score = $score_addition/sizeof($valoration);
        return $score;
      }else{
        return 0;
      }
      
    }

    public function getIconsServices($serv){

      $splits = explode("-", $serv);
      
      $services = DB::table('services_list')
                ->whereIn('service_code', $splits)
                ->get();
      return $services;
    }

}
