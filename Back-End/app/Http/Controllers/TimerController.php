<?php

namespace App\Http\Controllers;


use DB;
use Session;
use Illuminate\Http\Request;
use App\Models\Timer;
use Carbon\Carbon;

class TimerController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:sanctum');
       // $this->middleware('CheckPermission');
    }

    // Task Timer

    //ADD Pause function or process it from the front

    public function TaskTimerStore(Request $request, int $task_id)
    {
        $data = $request->validate(['name' => 'required|between:3,100']);

        $user_id =  auth()->user()->id;

        $usertimers = Timer::where('user_id', '=', $user_id)
                        ->where('stopped_at', '=', Null)
                        ->get();

        if ($usertimers != '[]') {
            
            foreach ($usertimers as $usertimer) {
            
                $this->TaskTimerStopRunning($usertimer->id);            
    
            }

        }

        $currentdate = Carbon::now();
        $currentdate = $currentdate->toDateTimeString();

        $timer = new Timer();
        $timer->name =  $request->input('name');
        $timer->task_id = $task_id;
        $timer->user_id = $user_id;
        $timer->started_at  = $currentdate;
        $timer->isactive = "True";

        $timer->save();

        return $timer;
    }

    public function TaskTimerRunning()
    {
        return Timer::with('task')/*->mine()*/->running()->first() ?? [];
    }

    public function TaskTimerStopRunning($timer_id, $duration = null)
    {

        $currentdate = Carbon::now();
        $currentdate = $currentdate->toDateTimeString();

        $timer = Timer::find($timer_id);
        $timer->started_at  = $timer->started_at;
        $timer->stopped_at  = $currentdate;
        $timer->duration = $duration;
        $timer->isactive = "False";

        $timer->save();

        return $timer;
    }

    

    // User Timer

    public function UserTimerStore($name)
    {
        //$data = $request->validate(['name' => 'required|between:3,100']);

        $user_id =  auth()->user()->id;

        $mytime = Carbon::now();
        $currentdate = $mytime->toDateTimeString();

        $timer = new Timer();
        $timer->name =  $name;
        $timer->user_id = $user_id;
        $timer->started_at  = $currentdate;
        $timer->isactive = "True";
        
        $timer->save();
 
        return $timer;
    }

    public function UserTimerRunning()
    {
        return Timer::with('user')->mine()->running()->first() ?? [];
    }

    public function UserTimerStopRunning(Request $request, $timer_id)
    {
        $timer = Timer::find($timer_id);
        $timer->stopped_at  = new Carbon;
        $timer->duration = $request->duration;
        $timer->isactive = "False";
        $timer->save();
        return $timer;

    }
}
