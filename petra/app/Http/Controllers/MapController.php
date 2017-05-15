<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Points;

class MapController extends Controller
{
  public function mostra(){
    $all = Points::all();
    $all->toJson();
    return view('map', ['all' => $all]);
  }
}
