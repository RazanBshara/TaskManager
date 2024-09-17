<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reminder;


class ReminderAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('IsAdmin');
        $this->middleware('CheckPermission');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reminder::orderBy('created_at','desc')->paginate(10);
       // $reminder = Reminder::orderBy('created_at','desc')->paginate(10);
       // return view('reminderadmin.index')->with('reminder', $reminder);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('reminderadmin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'date' => 'required',   
            'userid' => 'required',
            'date' => 'required',
            'description' => 'required'
            
        ]);

        // Create Reminder 
        $reminder = new Reminder;
        $reminder->date = $request->input('date');
        $reminder->description = $request->input('description');
        $reminder->userid = $request->input('userid');

        $reminder->save();

        return redirect('/reminderadmin')->with('success', 'ReminderAdmin Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Reminder::find($id);

       // $reminder = Reminder::find($id);
        //return view('reminderadmin.show')->with('reminder', $reminder);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reminder = Reminder::find($id);
        
        //Check if Reminder exists before deleting
        if (!isset($reminder)){
            return redirect('/reminderadmin')->with('error', 'No ReminderAdmin Found');
        }

        return view('reminderadmin.edit')->with('reminder', $reminder);
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
        $this->validate($request, [
            //'date' => 'required'
            'userid' => 'required',
            'date' => 'required',
            'description' => 'required'
        ]);
    
        $reminder = Reminder::find($id);

        // Update Reminder
        $reminder->date = $request->input('date');
        $reminder->description = $request->input('description');
        $reminder->userid = $request->input('userid');  

        $reminder->save();

        return $reminder;
        
       // return redirect('/reminderadmin')->with('success', 'ReminderAdmin Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reminder = Reminder::find($id);
        
        //Check if Reminder exists before deleting
        if (!isset($reminder)){
            return redirect('/reminderadmin')->with('error', 'No ReminderAdmin Found');
        }
        
        $reminder->delete();

        return redirect('/reminderadmin')->with('success', 'ReminderAdmin Removed');
    }
}
