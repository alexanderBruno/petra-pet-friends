<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Points;

class MapController extends Controller
{
  public function mostra(){
    $all = Points::where('published', '1')->get();
    $all->toJson();
    return view('map', ['all' => $all]);
  }
}
