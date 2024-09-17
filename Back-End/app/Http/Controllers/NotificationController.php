<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use DB;

use App\Notifications\NotificationAction;
use App\Models\User;

use App\Traits\NotificationTrait;



class NotificationController extends Controller
{
    use NotificationTrait;

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('CheckPermission');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userid = [1,2,3]; //$request->input('userid');    
        $message = 'AZad dfk';

        return $this->SendNotification( $userid  , $message );

        return $notifications = DB::table('notifications')
        ->join('users', 'users.id', '=', 'notifications.notifiable_id')
        ->select('notifications.data')
        ->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userid = [1,2,3]; //$request->input('userid'); 
        $message = $request->input('message'); 

        for ($i=0; $i < count($userid) ; $i++) { 
            
            $user = User::find($userid[$i]);
            
            $user->notify(new \App\Notifications\NotificationAction($message));
        }

        return 'Notifications has been sent';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $notifications = DB::table('notifications')
        ->join('users', 'users.id', '=', 'notifications.notifiable_id')
        ->where('notifications.id' , '=' , $id )
        ->select('notifications.data')
        ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notifications = DB::table('notifications')
        ->join('users', 'users.id', '=', 'notifications.notifiable_id')
        ->where('notifications.id' , '=' , $id )
        ->delete();       

        return 'done';
    }

    public function markAsRead($id){

        $user->notifications->first()->markAsRead();

    }

    public function markAsUnread($id){

    }

    public function markallAsRead($id){

    }
    
    


}
