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
     * $id es la id que pasamos por la URL
     */
    public function profile($id)
    {
			$point = Points::find($id);

			if ($point->published!=1) {
				$previousurl=parse_url(url()->previous(),PHP_URL_PATH);
        if($previousurl=="/home" ) {
          return redirect()->action('HomeController@index')->with('confirmation', 'pointnotpublic');
        } elseif ($previousurl==("/profile"."/".$point->id_user)) {
          return redirect()->action('ProfileController@index', ['id' => $point->id_user])->with('confirmation', 'pointnotpublic');
        } elseif($previousurl=="/admin" ) {
          return redirect()->action('AdminController@index')->with('confirmation', 'pointnotpublic');
        } elseif($previousurl=="/map" ) {
          return redirect()->action('MapController@mostra')->with('confirmation', 'pointnotpublic');
        } else {
          return redirect()->action('HomeController@index');
        }

			} else {
	    	$reviews = DB::table('reviews')
	            ->leftJoin('users', 'reviews.id_user', '=', 'users.id')
							->leftJoin('scores_list', function ($join) {
	                $join->on('reviews.id_user', '=', 'scores_list.id_user')->on('reviews.id_point', '=', 'scores_list.id_point');
	            })
							->leftJoin('points', 'reviews.id_point', '=', 'points.id')
	            ->select('reviews.*', 'users.name', 'users.avatar','scores_list.score', 'points.name as namepoint')
	            ->where('reviews.id_point', $id)
							->orderBy('reviews.id', 'desc')
	            ->get();

	      $reviewPermission = DB::table('reviews')
	          ->where([['id_user', Auth::id()],['id_point', $id]])
	          ->count();

	      $likesdone = DB::table('likereview_list')->where('id_user', Auth::id())->get();

	      $score = $this -> getScore($id);

	      //actualizar la puntuacion de cada punto
	      DB::table('points')
	            ->where('id', $id)
	            ->update(['score' => $score]);

	      $services = $this -> getIconsServices($point->services_list);
	      //si hay un comentario con el id del usuario, no podra volver a comentar

				$point = Points::find($id);

				$favsdone = DB::table('favpoints_list')->where('id_user', Auth::id())->get();

	    	return view('point', ['point' => $point, 'reviews' => $reviews, 'score' => $score, 'reviewPermission' => $reviewPermission, 'loged' => Auth::id(), 'services' => $services, 'likesdone' => $likesdone, 'favsdone' => $favsdone]);
			}
    }

    public function review($id, Request $request)
    {

			//path a la carpeta donde guardamos las imagenes en este ejemplo /images/reviews/1
      $path = ("images/reviews/".Auth::id());

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

					return redirect()->action('PointController@profile', ['id' => $id])->with('confirmation', 'reviewcreated');

      } else {
				return redirect()->action('PointController@profile', ['id' => $id])->with('confirmation', 'reviewnotcreated');
      }
    }

     public function likereview($id)
    {
      $existslike = DB::table('likereview_list')->where('id_user', Auth::id())->where('id_review', $id)->first();

      if (count($existslike)==0) {
        DB::table('reviews')->where('id', $id)->increment('likes', 1);
        DB::table('likereview_list')->insert(['id_user' => Auth::id(), 'id_review' => $id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
      }
    }

    public function droplikereview($id)
    {
      $existslike = DB::table('likereview_list')->where('id_user', Auth::id())->where('id_review', $id)->first();

      if (count($existslike)!=0) {
        DB::table('reviews')->where('id', $id)->decrement('likes', 1);
        DB::table('likereview_list')->where('id_user', Auth::id())->where('id_review', $id)->delete();
      }
    }

		public function favpoint($id)
    {
      $existsfav = DB::table('favpoints_list')->where('id_user', Auth::id())->where('id_point', $id)->first();

      if (count($existsfav)==0) {
        DB::table('favpoints_list')->insert(['id_user' => Auth::id(), 'id_point' => $id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
      }
    }

    public function dropfavpoint($id)
    {
      $existsfav = DB::table('favpoints_list')->where('id_user', Auth::id())->where('id_point', $id)->first();

      if (count($existsfav)!=0) {
        DB::table('favpoints_list')->where('id_user', Auth::id())->where('id_point', $id)->delete();
      }
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
