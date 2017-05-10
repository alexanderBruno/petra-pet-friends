<?php

namespace App\Http\Controllers;

//Model Points
use App\Points;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


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

    	$comments = DB::table('comments')
            ->leftJoin('users', 'comments.id_user', '=', 'users.id')
            ->select('comments.*', 'users.name', 'users.avatar')
            ->where('comments.id_user', $id)
            ->get();


    	return view('point', ['point' => $point, 'comments'=>$comments]);
    	
    }
}
