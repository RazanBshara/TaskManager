<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessAdminController extends Controller
{
    use destroyTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        //$this->middleware('IsAdmin');
        //$this->middleware('CheckPermission');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $processes = DB::table('processes')
            ->select(
                'processes.id',
                DB::raw("(SELECT tasks.name FROM tasks
                                WHERE tasks.id = processes.taskid) as Task"),
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = processes.userid) as User"),
                DB::raw("(SELECT process_types.type FROM process_types
                                WHERE process_types.id = processes.typeid) as Type"),
                DB::raw("(SELECT tickets.name FROM tickets
                                WHERE tickets.id = processes.ticketid) as Ticket"),
                'processes.isactive',
                'processes.priority',
                'processes.status',
                'processes.created_at'
            )
            ->orderBy('created_at','desc')
            ->paginate(10);

        return $processes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $tasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $tickets = DB::table('tickets')
        ->select(
            'tickets.id',
            'tickets.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $types = DB::table('types')
        ->select(
            'types.id',
            'types.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['tasks'=>$tasks , 'user'=>$user , 'tickets'=>$tickets , 'types'=>$types]);
        
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
            'taskid' => 'required',
            'userid' => 'required',
            'tecketid' => 'required',
            'typeid' => 'required',
            'priority' => 'required'
        ]);

        // Create processes
        $processes = new Processes;
        $processes->taskid = $request->input('taskid');
        $processes->tecketid = $request->input('tecketid');
        $processes->typeid = $request->input('typeid');
        $processes->userid = $request->input('userid');
        $processes->priority = $request->input('priority');
        $processes->status = $request->input('status');

        $processes->save();

        return  $processes;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $processes = DB::table('processes')
        ->select(
            'processes.id',
            DB::raw("(SELECT tasks.name FROM tasks
                            WHERE tasks.id = processes.taskid) as Task"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = processes.userid) as User"),
             DB::raw("(SELECT process_types.type FROM process_types
                            WHERE process_types.id = processes.typeid) as Type"),
            DB::raw("(SELECT tickets.name FROM tickets
                            WHERE tickets.id = processes.ticketid) as Ticket"),
            'processes.isactive',
            'processes.priority',
            'processes.status',
            'processes.created_at'
        )
        ->where('id', '=' , $id)
        ->get();

        return $processes;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $processes = DB::table('processes')
        ->select(
            'processes.id',
            DB::raw("(SELECT tasks.name FROM tasks
                            WHERE tasks.id = processes.taskid) as Task"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = processes.userid) as User"),
             DB::raw("(SELECT process_types.type FROM process_types
                            WHERE process_types.id = processes.typeid) as Type"),
            DB::raw("(SELECT tickets.name FROM tickets
                            WHERE tickets.id = processes.ticketid) as Ticket"),
            'processes.isactive',
            'processes.priority',
            'processes.status',
            'processes.created_at'
        )
        ->where('id', '=' , $id)
        ->get();

        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $tasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $tickets = DB::table('tickets')
        ->select(
            'tickets.id',
            'tickets.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $types = DB::table('types')
        ->select(
            'types.id',
            'types.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['tasks'=>$tasks , 'user'=>$user , 'tickets'=>$tickets , 'types'=>$types , 'processes'=>$processes]);        
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
            'taskid' => 'required',
            'userid' => 'required',
            'tecketid' => 'required',
            'typeid' => 'required',
            'priority' => 'required'
        ]);

         // Update processes
         $processes = Processes::find($id);
         $processes->taskid = $request->input('taskid');
         $processes->tecketid = $request->input('tecketid');
         $processes->typeid = $request->input('typeid');
         $processes->userid = $request->input('userid');
         $processes->priority = $request->input('priority');
         $processes->status = $request->input('status');
 
         $processes->save();
 
         return  $processes;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $process = Process::find($id);

        //Check if Task exists before deleting
        if (!isset($processes)){
            return 'No processes Found';
        }

        Process::destroy($id);

        return 'Process Removed Successfully';
    }
}
