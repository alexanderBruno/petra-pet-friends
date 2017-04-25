<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Mapa extends Controller
{
  public function mostra(){
    return view('mapa');
  }
}
