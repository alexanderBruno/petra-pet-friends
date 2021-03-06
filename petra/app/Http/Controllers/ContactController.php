<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, DB, Carbon\Carbon, Mail, Input;


class ContactController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::guest()) {
        return view('contact', ['user' => null]);
      } else {
        $user = DB::table('users')->where('id', Auth::id())->first();
        return view('contact', ['user' => $user]);
      }
    }


    public function send(Request $request)
    {
      Mail::send('emailscontact',
          array(
              'name' => $request->get('contact_name'),
              'email' => $request->get('contact_email'),
              'user_message' => $request->get('contact_message'),
          ), function($message)
      {
        if (Input::hasFile('contact_photo')) {
          $message->attach(Input::file('contact_photo')->getRealPath(), array(
              'as' => 'contact_photo.' . Input::file('contact_photo')->getClientOriginalExtension(),
              'mime' => Input::file('contact_photo')->getMimeType())
          );
        }
        $message->from('contactepetra@gmail.com');
        $message->to('contactepetra@gmail.com')->subject('Formulari de contacte Petra');

      });

      return redirect()->action('ContactController@index')->with('confirmation', 'sended');
    }

}
