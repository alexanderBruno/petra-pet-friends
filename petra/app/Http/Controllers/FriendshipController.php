<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, App\User, DB;

class FriendshipController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $yourfriends = DB::table('friendships')
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'friendships.sender_id')->orOn('users.id', '=', 'friendships.recipient_id');
            })
            ->select('friendships.sender_id', 'friendships.recipient_id', 'users.id', 'users.name', 'users.avatar')
            ->where('friendships.status', 1)->where('friendships.sender_id', Auth::id())->orWhere('friendships.recipient_id', Auth::id())
            ->orderBy('users.name')
            ->get();

      $yourpendingrequests = DB::table('friendships')
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'friendships.sender_id');
            })
            ->select('friendships.sender_id', 'friendships.recipient_id', 'users.id', 'users.name', 'users.avatar')
            ->where('friendships.status', 0)->where('users.id', '<>', Auth::id())
            ->orderBy('users.name')
            ->get();

      $yoursendrequests = DB::table('friendships')
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'friendships.recipient_id');
            })
            ->select('friendships.sender_id', 'friendships.recipient_id', 'users.id', 'users.name', 'users.avatar')
            ->where('friendships.status', 0)->where('users.id', '<>', Auth::id())
            ->orderBy('users.name')
            ->get();

      $allusers = User::orderBy('name')->get();

      $youcansendrequest = DB::table('friendships')->where('sender_id', Auth::id())->orWhere('recipient_id', Auth::id())->get();

      return view('friends', ['yourfriends' => $yourfriends, 'yourpendingrequests' => $yourpendingrequests, 'yoursendrequests' => $yoursendrequests, 'allusers' => $allusers, 'youcansendrequest' => $youcansendrequest]);
    }

    public function add($id)
    {
      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);

      $userE = User::where('id', Auth::id())->first();
      $userR = User::where('id', $id)->first();

      if($previousurl=="/friends" ) {
        if ($userE==$userR) {
          return redirect()->action('FriendshipController@index')->with('confirmation', 'addsameuser');
        } else {
          $add=$userE->befriend($userR);
          if ($add==null) {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'addalready');
          }
        }
        return redirect()->action('FriendshipController@index')->with('confirmation', 'addedfriend');
      }
      elseif ($previousurl==("/profile"."/".$id)) {
        if ($userE==$userR) {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'addsameuser');
        } else {
          $add=$userE->befriend($userR);
          if ($add==null) {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'addalready');
          }
        }
        return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'addedfriend');
      }
      else {
        return redirect()->action('FriendshipController@index')->with('confirmation', 'error');
      }
    }


    public function delete($id)
    {
      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);
      $currenturl=parse_url(url()->current(), PHP_URL_PATH);

      $userE = User::where('id', Auth::id())->first();
      $userR = User::where('id', $id)->first();

      if($previousurl=="/friends" ) {
        if ($userE==$userR) {
          if ($currenturl==("/friends/allowadd"."/".$id)) {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'allowaddsameuser');
          } elseif ($currenturl==("/friends/removeadd"."/".$id)) {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'removeaddsameuser');
          } elseif ($currenturl==("/friends/denyadd"."/".$id)) {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'denyaddsameuser');
          } else {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'deletesameuser');
          }
        } else {
          $del=$userE->unfriend($userR);
          if ($del==null) {
            if ($currenturl==("/friends/allowadd"."/".$id)) {
              return redirect()->action('FriendshipController@index')->with('confirmation', 'allowaddalready');
            } elseif ($currenturl==("/friends/removeadd"."/".$id)) {
              return redirect()->action('FriendshipController@index')->with('confirmation', 'removeaddalready');
            } elseif ($currenturl==("/friends/denyadd"."/".$id)) {
              return redirect()->action('FriendshipController@index')->with('confirmation', 'denyaddalready');
            } else {
              return redirect()->action('FriendshipController@index')->with('confirmation', 'deletealready');
            }
          }
        }
        if ($currenturl==("/friends/allowadd"."/".$id)) {
          return redirect()->action('FriendshipController@index')->with('confirmation', 'allowedadd');
        } elseif ($currenturl==("/friends/removeadd"."/".$id)) {
          return redirect()->action('FriendshipController@index')->with('confirmation', 'removedadd');
        } elseif ($currenturl==("/friends/denyadd"."/".$id)) {
          return redirect()->action('FriendshipController@index')->with('confirmation', 'deniedadd');
        } else {
        return redirect()->action('FriendshipController@index')->with('confirmation', 'deletedfriend');
        }
      }
      elseif ($previousurl==("/profile"."/".$id)) {
        if ($userE==$userR) {
          if ($currenturl==("/friends/allowadd"."/".$id)) {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'allowaddsameuser');
          } elseif ($currenturl==("/friends/removeadd"."/".$id)) {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'removeaddsameuser');
          } elseif ($currenturl==("/friends/denyadd"."/".$id)) {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'denyaddsameuser');
          } else {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'deletesameuser');
          }

        } else {
          $del=$userE->unfriend($userR);
          if ($del==null) {
            if ($currenturl==("/friends/allowadd"."/".$id)) {
              return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'allowaddalready');
            } elseif ($currenturl==("/friends/removeadd"."/".$id)) {
              return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'removeaddalready');
            } elseif ($currenturl==("/friends/denyadd"."/".$id)) {
              return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'denyaddalready');
            } else {
              return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'deletealready');
            }
          }
        }
        if ($currenturl==("/friends/allowadd"."/".$id)) {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'allowedadd');
        } elseif ($currenturl==("/friends/removeadd"."/".$id)) {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'removedadd');
        } elseif ($currenturl==("/friends/denyadd"."/".$id)) {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'deniedadd');
        } else {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'deletedfriend');
        }
      }
      else {
        return redirect()->action('ProfileController@index')->with('confirmation', 'error');
      }
    }


    public function acceptadd($id)
    {
      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);

      $userE = User::where('id', $id)->first();
      $userR = User::where('id', Auth::id())->first();

      if($previousurl=="/friends" ) {
        if ($userE==$userR) {
          return redirect()->action('FriendshipController@index')->with('confirmation', 'acceptaddsameuser');
        } else {
          $accept=$userR->acceptFriendRequest($userE);
          if ($accept==null) {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'acceptaddalready');
          }
        }
        return redirect()->action('FriendshipController@index')->with('confirmation', 'acceptedadd');
      }
      elseif ($previousurl==("/profile"."/".$id)) {
        if ($userE==$userR) {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'acceptaddsameuser');
        } else {
          $accept=$userR->acceptFriendRequest($userE);
          if ($accept==null) {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'acceptaddalready');
          }
        }
        return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'acceptedadd');
      }
      else {
        return redirect()->action('ProfileController@index')->with('confirmation', 'error');
      }
    }


    public function denyadd($id)
    {
      $previousurl=parse_url(url()->previous(), PHP_URL_PATH);

      $userE = User::where('id', $id)->first();
      $userR = User::where('id', Auth::id())->first();

      if($previousurl=="/friends" ) {
        if ($userE==$userR) {
          return redirect()->action('FriendshipController@index')->with('confirmation', 'denyaddsameuser');
        } else {
          $deny=$userR->denyFriendRequest($userE);
          if ($deny==null) {
            return redirect()->action('FriendshipController@index')->with('confirmation', 'denyaddalready');
          }
        }
        return redirect()->action('FriendshipController@index')->with('confirmation', 'deniedadd');
      }
      elseif ($previousurl==("/profile"."/".$id)) {
        if ($userE==$userR) {
          return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'denyaddsameuser');
        } else {
          $deny=$userR->denyFriendRequest($userE);
          if ($deny==null) {
            return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'denyaddalready');
          }
        }
        return redirect()->action('ProfileController@index', ['id' => $id])->with('confirmation', 'deniedadd');
      }
      else {
        return redirect()->action('ProfileController@index')->with('confirmation', 'error');
      }
    }

}
