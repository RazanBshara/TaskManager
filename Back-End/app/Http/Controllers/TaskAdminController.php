<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\UserTask;

class TaskAdminController extends Controller
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
        return Task::orderBy('created_at','desc')->paginate(10);
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
        $this->validate($request, [
            'name' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'userid' => 'required'
        ]);

        // Create Task
        $task = new Task;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->startdate = $request->input('startdate');
        $task->enddate = $request->input('enddate');
        $task->userid = $request->input('userid');
        $task->projectid = $request->input('projectid');

        $task->save();

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Task::find($id);
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
        $this->validate($request, [
            'name' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'projectid' => 'required',
        ]);

        $task = Task::find($id);

        // Update task
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->startdate = $request->input('startdate');
        $task->enddate = $request->input('enddate');
        $task->userid = $request->input('userid');
        $task->projectid = $request->input('projectid');

        $task->save();

        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

         $task = Task::find($id);

        //Check if task exists before deleting
        if (!isset($task)){
            return 'No Task Found';
        }

        //delete all tasks UserTask
        UserTask::where('taskid' , '=' , $id)->delete();

        return Task::destroy($id);

    }
}
