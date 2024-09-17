<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reminder;


class ReminderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPermission');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminder = Reminder::orderBy('created_at','desc')->paginate(10);
        return view('reminder.index')->with('reminder', $reminder);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('reminder.create');
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
        ]); 

        // Create Reminder
        $reminder = new Reminder;
        $reminder->date = $request->input('date');
        $reminder->description = $request->input('description');


        $reminder->userid = auth()->user()->id;;

        $reminder->save();

        return redirect('/reminder')->with('success', 'Reminder Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reminder = Reminder::find($id);
        return view('reminder.show')->with('reminder', $reminder);
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
            return redirect('/reminder')->with('error', 'No Reminder Found');
        }

        return view('reminder.edit')->with('reminder', $reminder);
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
        ]);
    
        $reminder = Reminder::find($id);

        // Update Reminder
        $reminder->date = $request->input('date');
        $reminder->description = $request->input('description');
        
        $reminder->save();

        return redirect('/reminder')->with('success', 'Reminder Updated');
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
            return redirect('/reminder')->with('error', 'No Reminder Found');
        }
        
        $reminder->delete();

        return redirect('/reminder')->with('success', 'Reminder Removed');
    }
}
