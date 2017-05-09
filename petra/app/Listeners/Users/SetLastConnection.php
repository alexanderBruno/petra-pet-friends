<?php

namespace App\Listeners\Users;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB, Carbon\Carbon;

class SetLastConnection
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // $event->user->last_connection = Carbon::now();
        // $event->user->save();
        DB::table('users')->where('email', $event->user->email)->update(['last_connection' => Carbon::now()]);
    }
}
