<?php

namespace App\Traits;

use App\Traits\LoginTimer;

use App\Models\Timer;

use Carbon\Carbon;
 
trait LoginTimer {

    public function UserTimerStore($user_id, $name)
    {
        //$data = $request->validate(['name' => 'required|between:3,100']);

        $mytime = Carbon::now();
        $currentdate = $mytime->toDateTimeString();

        $timer = new Timer();
        $timer->name =  $name;
        $timer->user_id = $user_id;
        $timer->started_at  = $currentdate;
        $timer->isactive = "True";
        
        $timer->save();
 
        return 'Login Timer started!';
    }


}