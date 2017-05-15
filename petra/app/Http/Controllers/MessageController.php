<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use Illuminate\Http\Request;
use Nahid\Talk\Facades\Talk;
use View;

class MessageController extends Controller
{
    protected $authUser;
    public function __construct()
    {
        $this->middleware('talk');

        Talk::setAuthUserId(Auth::id());

        View::composer('partials.peoplelist', function($view) {
            $threads = Talk::threads();
            $view->with(compact('threads'));
        });
    }

    public function index()
    {
        $users = User::all();
        return view('messages', compact('users'));
    }

    public function chatHistory($id)
    {
        $conversations = Talk::getMessagesByUserId($id);
        $user = '';
        $messages = [];
        if(!$conversations) {
            $user = User::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
        }

        return view('messages.conversations', compact('messages', 'user'));
    }

    public function ajaxSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'message-data'=>'required',
                '_id'=>'required'
            ];

            $this->validate($request, $rules);

            $body = $request->input('message-data');
            $userId = $request->input('_id');

            if ($message = Talk::sendMessageByUserId($userId, $body)) {
                $html = view('ajax.newMessageHtml', compact('message'))->render();
                return response()->json(['status'=>'success', 'html'=>$html], 200);
            }
        }
    }

    public function ajaxDeleteMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(Talk::deleteMessage($id)) {
                return response()->json(['status'=>'success'], 200);
            }

            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }

}
