<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usersbbdd extends Controller
{
  public function select(){
    $users = DB::table('users')->get();
    return view('users', compact('users'));
  }

}
