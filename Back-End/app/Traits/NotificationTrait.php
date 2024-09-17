<?php

namespace App\Traits;

use Illuminate\Notifications\Notification;
use App\Notifications\NotificationAction;

use DB;
use App\Models\User;

 
trait NotificationTrait {

    public function SendNotification($userid , $message){          
            
        $user = User::find($userid);        
        $user->notify(new \App\Notifications\NotificationAction($message));

        return 'Notifications has been sent';

    }

}

