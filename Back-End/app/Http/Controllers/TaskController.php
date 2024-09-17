<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

use App\Traits\TaskWorkflow;
use App\Traits\destroyTrait;

use App\Http\Requests\TaskRequest;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\Process;
use App\Models\RoleGroupCompany;
use App\Models\UserRoleGroupCompany;
use App\Models\WorkflowUpperLevel;
use App\Models\CompanyWorkflow;


class TaskController extends Controller
{
    use TaskWorkflow;
    use destroyTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        //$this->middleware('CheckPermission');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function TaskIndex($projectid)
    {
        $projecttask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
            WHERE users.id = tasks.createdby) as CreatedBy")
        )
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.projectid' , '=' , $projectid)
        ->where('tasks.isdeleted' , '=' , Null)

        ->orderBy('tasks.created_at','desc')
        ->get();

        $CompletedProjectTask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
            WHERE users.id = tasks.createdby) as CreatedBy")
        )
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.projectid' , '=' , $projectid)
        ->where('tasks.isdeleted' , '=' , Null)
        ->where('tasks.status' , '=' , 'Done')

        ->orderBy('tasks.created_at','desc')
        ->get();

        $mytasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            'tasks.status',
            DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
        )
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)
        ->where('tasks.createdby' , '=' , auth()->user()->id)
        ->where('tasks.projectid' , '=' , $projectid)

        ->orderBy('tasks.created_at','desc')
        ->get();


        $NotAssignedTask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
            WHERE users.id = tasks.createdby) as CreatedBy")
        )
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.projectid' , '=' , $projectid)
        ->where('tasks.isdeleted' , '=' , Null)

        //and not exists in user tasks

        ->whereNotExists(function($query)
                {
                    $query->select(DB::raw(1))
                          ->from('tasks')
                          ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
                          ->where('tasks.isactive' , '=' , 'active')
                          ->where('tasks.isdeleted' , '=' , Null);
                })

        ->orderBy('tasks.created_at','desc')
        ->get();

        return (['projecttask'=>$projecttask, 'CompletedProjectTask'=>$CompletedProjectTask, 'mytasks'=>$mytasks, 'NotAssignedTask'=>$NotAssignedTask]);

    }

    public function index()
    {
        $user = User::find( auth()->user()->id);

        $ticket = DB::table('tickets')
        ->select(
            'tickets.id',
            //DB::raw('CONCAT(tickets.name, " ", tickets.type) AS Ticket'),
            DB::raw('tickets.name AS Ticket'),
            'tickets.description',
            'tickets.startdate',
            'tickets.enddate',
            'tickets.type',
            'tickets.status',
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
        )
        ->join('processes', 'processes.ticketid', '=', 'tickets.id')
        ->join('process_types', 'process_types.id', '=', 'processes.typeid')
        ->join('user_tickets', 'user_tickets.ticketid', '=', 'tickets.id')
        ->join('users', 'tickets.createdby', '=', 'users.id')

        ->where('processes.userid' , '=' , auth()->user()->id)
        ->where('processes.status' , 'LIKE' , '%Pending%')
        ->where('processes.isactive' , '=' , 'active')

        ->orderBy('tickets.created_at','desc')
        ->get();

        $approveprocesstask = DB::table('tasks')
        ->select(
            'tasks.id',
             DB::raw('CONCAT(tasks.name, " ", tasks.relatedto) AS Task'),
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            //'tasks.projectid',
            //DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
            'tasks.priority',
            //'tasks.status',
            //'tasks.isactive',
            //'processes.priority',
            'processes.status as status',
            'process_types.type',
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')

        )
        ->join('processes', 'processes.taskid', '=', 'tasks.id')
        ->join('process_types', 'process_types.id', '=', 'processes.typeid')
        ->join('users', 'users.id', '=', 'tasks.createdby')

        ->where('processes.status' , 'LIKE' , '%Pending Approve%')
        ->where('processes.userid' , '=' , auth()->user()->id)
        ->where('processes.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)

        ->orderBy('processes.priority','desc')
        ->get();


        $confirmprocesstask = DB::table('tasks')
        ->select(
            'tasks.id',
             DB::raw('CONCAT(tasks.name, " ", tasks.relatedto) AS Task'),
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            //'tasks.projectid',
            //DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
            'tasks.priority',
            //'tasks.status',
            //'tasks.isactive',
            //'processes.priority',
            'processes.status as status',
            'process_types.type',
             DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')

        )
        ->join('processes', 'processes.taskid', '=', 'tasks.id')
        ->join('process_types', 'process_types.id', '=', 'processes.typeid')
        ->join('users', 'users.id', '=', 'tasks.createdby')

        ->where('processes.status' , 'LIKE' , '%Pending Confirm%')
        ->where('processes.userid' , '=' , auth()->user()->id)
        ->where('processes.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)

        ->orderBy('processes.priority','desc')
        ->get();

        $projecttask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            'tasks.status',
            DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
        )
        ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
        ->join('users', 'tasks.createdby', '=', 'users.id')

        ->where('user_tasks.userid' , '=' , auth()->user()->id)
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)

      /*  ->whereNotExists(function($query)
                {
                    $query->select(DB::raw(1))
                          ->from('processes')
                          ->whereRaw('processes.taskid = tasks.id')
                          ->where('processes.status' , 'LIKE' , '%Pending Review%');
                })*/

        ->orderBy('tasks.created_at','desc')
        ->get();

        //
        $mytasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            'tasks.status',
            DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
        )
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)
        ->where('tasks.createdby' , '=' , auth()->user()->id)

        ->orderBy('tasks.created_at','desc')
        ->get();

        $NotAssignedTask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
            WHERE users.id = tasks.createdby) as CreatedBy")
        )
        ->join('users', 'tasks.createdby', '=', 'users.id')

        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)
        ->get();

        //and not exists in user tasks

        /*->whereNotExists(function($query)
                {
                    $query->select(DB::raw(1))
                          ->from('tasks')
                          ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
                          ->where('tasks.isactive' , '=' , 'active')
                          ->where('tasks.isdeleted' , '=' , Null);
                })

        ->orderBy('tasks.created_at','desc')
        ->get();*/

        //project
        $project = DB::table('projects')
        ->select(
            'projects.id',
            'projects.name',
            'projects.description',
            'projects.startdate',
            'projects.enddate',
            'projects.status',
            'projects.label',
            'projects.workspaceid',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = projects.pmid) as ProjectManager")
        )
        //->join('project_department_unit_section_users', 'projects.id', '=', 'project_department_unit_section_users.projectid')
       // ->join('workspaces', 'workspaces.id', '=', 'projects.workspaceid')

       // ->where('projects.isactive' , '=' , 'active')
        //->where('projects.workspaceid' , '=' ,  $workspaceid)
        //->where('projects.isdeleted' , '=' , Null)
      /*  ->whereRaw('(project_department_unit_section_users.userid = ? or
                    project_department_unit_section_users.sectionid = ? or
                    project_department_unit_section_users.unitid = ? or
                    project_department_unit_section_users.departmentid = ?
                    )', [$user->id, $user->sectionid , $user->unitid , $user->departmentid])*/

        ->distinct()
        ->get();


        return (['project'=>$project,'NotAssignedTask'=>$NotAssignedTask, 'mytasks'=>$mytasks, 'confirmprocesstask'=>$confirmprocesstask , 'approveprocesstask'=>$approveprocesstask , 'projecttask'=>$projecttask , 'ticket'=>$ticket]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectid)
    {
        $tasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
        )
        ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
        ->join('users', 'tasks.createdby', '=', 'users.id')

        ->where('user_tasks.userid' , '=' , auth()->user()->id)
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.projectid' , '=' , $projectid)
        ->where('tasks.isdeleted' , '=' , Null)

        ->orderBy('tasks.created_at','desc')
        ->get();

        //

        $userid = auth()->user()->id;

        $user = User::find($userid);

        $rolegroupid = UserRoleGroupCompany::where('userid' , '=' ,  $userid)->min('rolegroupcompanyid');

        $roles = RoleGroupCompany::where('id' , '>' , $rolegroupid)->get();

        $UserRolegroupCompany = RoleGroupCompany::where('id' , '=' , $rolegroupid)->first();

        switch ($UserRolegroupCompany) {

            case 'Head Of Section(HOS)':

                $users = DB::table('users')
                        ->select(
                            'users.id',
                            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                        ->where('sectionid', '=', $user->sectionid)
                        ->orderBy('users.created_at','desc')
                        ->get();

                    return (['tasks'=>$tasks , 'roles'=>$roles , 'users'=>$users]);

                break;
            case 'Head Of Unit(HOU)':

                    $users = DB::table('users')
                        ->select(
                            'users.id',
                            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                        ->where('unitid', '=', $user->unitid)
                        ->orderBy('users.created_at','desc')
                        ->get();

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users]);

                break;
            case 'Director (Department Manager)':

                    $users = DB::table('users')
                    ->select(
                        'users.id',
                        DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                    ->where('departmentid', '=', $user->departmentid)
                    ->orderBy('users.created_at','desc')
                    ->get();

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users]);

                break;

            case 'Manager':

                    $users = DB::table('users')
                    ->select(
                        'users.id',
                        DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                    ->where('departmentid', '=', $user->departmentid)
                    ->orderBy('users.created_at','desc')
                    ->get();

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users]);

                break;


            default:

                    if ($UserRolegroupCompany != 'Project Manager') {

                        $users = User::where('companyid', '=', $user->companyid)->pluck('id', DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'));

                        $users = DB::table('users')
                                ->select(
                                    'users.id',
                                    DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                                ->where('departmentid', '=', $user->departmentid)
                                ->orderBy('users.created_at','desc')
                                ->get();

                    }else {

                        $users = '';
                    }

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users]);

                break;
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        if ($request->AssignedUserId == null && $request->Role == null) {

            $assignedid = '';//array of assignedid IDs

        }else if ($request->AssignedUserId != null && $request->Role == null){

            $assignedid = $request->AssignedUserId;//array of assignedid IDs
        }
        else if ($request->AssignedUserId == null && $request->Role != null){

            $rolegroupid = $request->Role;

            $AssignedRoleId =  DB::table('users')
            ->select(
                'users.id'
            )
            ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
            ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

            ->where('user_role_group_companies.rolegroupcompanyid' , '>' , $rolegroupid)

            ->orderBy('users.created_at','asc')
            ->get()
            ->toArray();

            for ($i=0; $i < count($AssignedRoleId) ; $i++) {

                $assignedid[$i] = $AssignedRoleId[$i]->id;
            }

        }else {

            $rolegroupid = $request->Role;

            $AssignedRoleId =  DB::table('users')
            ->select(
                'users.id'
            )
            ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
            ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

            ->where('user_role_group_companies.rolegroupcompanyid' , '>' , $rolegroupid)

            ->orderBy('users.created_at','asc')
            ->get()
            ->toArray();


            $AssignedUserId = $request->AssignedUserId;

            for ($i=0; $i < count($AssignedRoleId) ; $i++) {


                $assignedid[$i] = $AssignedRoleId[$i]->id;

            }

            for ($c= 0; $c < count($AssignedUserId) ; $c++) {

                $assignedid[$i] = $AssignedUserId[$c];
                $i ++;


            }

        }

        //check if end date of parent task > end date of subtask
        if ($request->parent != Null) {

            $parenttask = Task::find($request->parent);

            if ($parenttask->status == 'Rejected') {

                return 'You cant create subtask, The Parent task is Rejected!!!';
            }

            if ($request->enddate > $parenttask->enddate ) {

                return 'The End Date of subtask large than end date of Parent Task';
            }
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheckProject = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'projecttask')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $CompanyWorkflowCheckCustom = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'customtask')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        if ($request->projectid != '') {

            $projecttype = 'project';

        }else {

            $projecttype = 'custom';

        }

        // Create Task
        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->startdate = $request->startdate;
        $task->enddate = $request->enddate;
        $task->label = $request->label;
        $task->createdby = auth()->user()->id;
        if ( $projecttype == 'project') {
            $task->type = 'project';
            $task->projectid = $request->projectid;
            //$task->projectid = Session::get('projectid');

            if ($CompanyWorkflowCheckProject == '') {

                $task->isactive = 'active';
            }
        }else {
            $task->type = 'custom';

            if ($CompanyWorkflowCheckCustom == '') {

                $task->isactive = 'active';
            }
        }
        $task->priority = $request->priority;
        $task->dependontask = $request->dependontask;

        $task->save();

        if($request->parent && $request->parent !== 'none') {
            //  Here we define the parent for new created task
            $node = Task::find($request->parent);

            $node->appendNode($task);
        }

        $this->AssignTaskToUsers( auth()->user()->id , $assignedid, $task->id);

        //workflow
        if ( $projecttype == 'project') {

            if ($CompanyWorkflowCheckProject != '') {

                $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Project Task')->first();

                if ($WorkflowUpperLevel != '') {

                    $upperlevel = $WorkflowUpperLevel->upperlevel;

                }
            }
        }else {
            if ($CompanyWorkflowCheckCustom != '') {

                $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Custom Task')->first();

                if ($WorkflowUpperLevel != '') {

                    $upperlevel = $WorkflowUpperLevel->upperlevel;

                }
            }else {
                $upperlevel = 0;
            }
        }


        if ($request->parent != null) {

            if ( $projecttype == 'project') {

                if ($CompanyWorkflowCheckProject != '') {

                    $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'task' , $task->id, $request->parent, Null, $request->assignedtype);
                }

            }else {

                if ($CompanyWorkflowCheckCustom != '') {

                    $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'task' , $task->id, $request->parent, Null, $request->assignedtype);
                }
            }

        }else {


            if ( $projecttype == 'project') {

                if ($CompanyWorkflowCheckProject != '') {

                    $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'task' , $task->id, Null, Null, $request->assignedtype);
                }

            }else {

                if ($CompanyWorkflowCheckCustom != '') {

                    $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'task' , $task->id, Null, Null, $request->assignedtype);
                }
            }

        }


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
        //check if active
        $Taskcheckactive = Task::find($id);

        if ($Taskcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $tasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy'),
            DB::raw("(SELECT t.name FROM tasks t
                                WHERE t.id = tasks.parent_id) as ParentTask"),
            DB::raw("(SELECT tt.name FROM tasks tt
                                WHERE tt.id = tasks.dependontask) as DependOnTask")
        )
        ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
        ->join('users', 'tasks.createdby', '=', 'users.id')

        ->where('user_tasks.userid' , '=' , auth()->user()->id)
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)

        ->orderBy('tasks.created_at','desc')
        ->get();

        return $tasks;

        return (['tasks'=>$tasks, 'Taskcheckactive'=>$Taskcheckactive]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $OrginalTask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            'tasks.projectid',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
            WHERE users.id = " . auth()->user()->id . ") as CreatedBy")
        )
        ->where('id' , '=' , $id)
        ->where('tasks.isdeleted' , '=' , Null)
        ->first();


        $tasks = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
        )
        ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
        ->join('users', 'tasks.createdby', '=', 'users.id')

        ->where('user_tasks.userid' , '=' , auth()->user()->id)
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.projectid' , '=' , $OrginalTask->projectid)
        ->where('tasks.isdeleted' , '=' , Null)

        ->orderBy('tasks.created_at','desc')
        ->get();

        // //

        $userid = auth()->user()->id;

        $user = User::find($userid);

        $rolegroupid = UserRoleGroupCompany::where('userid' , '=' ,  $userid)->min('rolegroupcompanyid');

        $UserRolegroupCompany = RoleGroupCompany::where('id' , '=' , $rolegroupid)->first();


        $roles =  DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            DB::raw(' role_group_companies.adjictive AS Role'),

        )
        ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
        ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

        ->where('user_role_group_companies.rolegroupcompanyid' , '>' , $rolegroupid)

        ->orderBy('users.created_at','asc')
        ->paginate(5);

        switch ($UserRolegroupCompany) {

            case 'Head Of Section(HOS)':

                    $users = DB::table('users')
                    ->select(
                        'users.id',
                        DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                    ->where('sectionid', '=', $user->sectionid)
                    ->orderBy('users.created_at','desc')
                    ->paginate(5);

                    return (['tasks'=>$tasks , 'roles'=>$roles , 'users'=>$users , 'OrginalTask'=>$OrginalTask]);

                break;
            case 'Head Of Unit(HOU)':

                    $users = DB::table('users')
                    ->select(
                        'users.id',
                        DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                    ->where('unitid', '=', $user->unitid)
                    ->orderBy('users.created_at','desc')
                    ->paginate(5);

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users, 'OrginalTask'=>$OrginalTask]);

                break;
            case 'Director (Department Manager)':

                    $users = DB::table('users')
                    ->select(
                        'users.id',
                        DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                    ->where('departmentid', '=', $user->departmentid)
                    ->orderBy('users.created_at','desc')
                    ->paginate(5);

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users, 'OrginalTask'=>$OrginalTask]);

                break;

            case 'Manager':

                    $users = DB::table('users')
                    ->select(
                        'users.id',
                        DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                    ->where('departmentid', '=', $user->departmentid)
                    ->orderBy('users.created_at','desc')
                    ->paginate(5);

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users, 'OrginalTask'=>$OrginalTask]);

                break;


            default:

                    if ($UserRolegroupCompany != 'Project Manager') {

                        $users = DB::table('users')
                        ->select(
                            'users.id',
                            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'))
                        ->where('companyid', '=', $user->companyid)
                        ->orderBy('users.created_at','desc')
                        ->paginate(5);

                    }else {

                        $users = '';
                    }

                    return (['tasks'=>$tasks, 'roles'=>$roles , 'users'=>$users, 'OrginalTask'=>$OrginalTask]);

                break;
        }
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
            'enddate' => 'required'
        ]);

        if ($request->AssignedUserId == null && $request->Role == null) {

            $assignedid = '';//array of assignedid IDs

        }else if ($request->AssignedUserId != null && $request->Role == null){

            $assignedid = $request->AssignedUserId;//array of assignedid IDs
        }
        else if ($request->AssignedUserId == null && $request->Role != null){

            $rolegroupid = $request->Role;

            $AssignedRoleId =  DB::table('users')
            ->select(
                'users.id'
            )
            ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
            ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

            ->where('user_role_group_companies.rolegroupcompanyid' , '>' , $rolegroupid)

            ->orderBy('users.created_at','asc')
            ->get()
            ->toArray();

            for ($i=0; $i < count($AssignedRoleId) ; $i++) {

                $assignedid[$i] = $AssignedRoleId[$i]->id;
            }

        }else {

            $rolegroupid = $request->Role;

            $AssignedRoleId =  DB::table('users')
            ->select(
                'users.id'
            )
            ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
            ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

            ->where('user_role_group_companies.rolegroupcompanyid' , '>' , $rolegroupid)

            ->orderBy('users.created_at','asc')
            ->get()
            ->toArray();


            $AssignedUserId = $request->AssignedUserId;

            for ($i=0; $i < count($AssignedRoleId) ; $i++) {


                $assignedid[$i] = $AssignedRoleId[$i]->id;

            }

            for ($c= 0; $c < count($AssignedUserId) ; $c++) {

                $assignedid[$i] = $AssignedUserId[$c];
                $i ++;


            }

        }

        //check if active
        $Taskcheckactive = Task::find($id);

        if ($Taskcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheckProject = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'projecttask')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $CompanyWorkflowCheckCustom = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'customtask')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $orginaltask = Task::find($id);

        if ($orginaltask->projectid != '') {

            $projecttype = 'project';
        }else {
            $projecttype = 'custom';
        }


        if ($orginaltask->type == 'project') {

            if ($CompanyWorkflowCheckProject == '[]') {

                $orginaltask->name = $request->name;
                $orginaltask->description = $request->description;
                $orginaltask->enddate = $request->enddate;
                $orginaltask->priority = $request->priority;
                $orginaltask->label = $request->label;
                $orginaltask->type = $projecttype;

                $orginaltask->save();

                return $orginaltask;
            }
        }else {

            if ($CompanyWorkflowCheckCustom == '[]') {

                $orginaltask->name = $request->name;
                $orginaltask->description = $request->description;
                $orginaltask->enddate = $request->enddate;
                $orginaltask->priority = $request->priority;
                $orginaltask->label = $request->label;
                $orginaltask->type = $projecttype;

                $orginaltask->save();

                return $orginaltask;
            }
        }


        // Update task
        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->enddate = $request->enddate;
        $task->priority = $request->priority;
        $task->label = $request->label;

        $task->startdate = $orginaltask->startdate;
        $task->createdby = $orginaltask->createdby;
        $task->type = $projecttype;

        if ($request->dependontask != '') {

            $task->dependontask = $request->dependontask;
        }

        if($request->parent && $request->parent !== 'none') {
            //  Here we define the parent for new created task
            $node = Task::find($request->parent);

            $node->appendNode($task);
        }

        $task->updatingfor = $id;
        $task->save();

        //workflow
        if ( $projecttype == 'project') {

            if ($CompanyWorkflowCheckProject != '') {

                $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Project Task')->first();

                if ($WorkflowUpperLevel != '') {

                    $upperlevel = $WorkflowUpperLevel->upperlevel;

                }
            }
        }else {
            if ($CompanyWorkflowCheckCustom != '') {

                $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Custom Task')->first();

                if ($WorkflowUpperLevel != '') {

                    $upperlevel = $WorkflowUpperLevel->upperlevel;

                }
            }else {
                $upperlevel = 0;
            }
        }


        $this->AssignTaskToUsers( auth()->user()->id ,  $assignedid, $task->id);


        if ($request->parent != null) {

            if ( $projecttype == 'project') {

                if ($CompanyWorkflowCheckProject != '') {

                    $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'task' , $id , $request->parent, Null, $request->assignedtype);
                }

            }else {

                if ($CompanyWorkflowCheckCustom != '') {

                    $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'task' , $id , $request->parent, Null, $request->assignedtype);
                }
            }

        }else {


            if ( $projecttype == 'project') {

                if ($CompanyWorkflowCheckProject != '') {

                    $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'task' , $id, Null, Null, $request->assignedtype);
                }

            }else {

                if ($CompanyWorkflowCheckCustom != '') {

                    $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'task' , $id, Null, Null, $request->assignedtype);
                }
            }

        }



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
        //check if active
        $Taskcheckactive = Task::find($id);

        if ($Taskcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $task = Task::find($id);

        //Check if Task exists before deleting
        if (!isset($task)){
            return 'No Task Found';
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheckProject = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'projecttask')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $CompanyWorkflowCheckCustom = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'customtask')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        if ($CompanyWorkflowCheckProject == '[]') {

            UserTask::where('taskid' , '=' , $id)->delete();

            Task::descendantsOf($id)->delete();

            Task::destroy($id);

            return 'Task Removed Successfully';
        }else {
            if ($CompanyWorkflowCheckCustom == '[]') {

                UserTask::where('taskid' , '=' , $id)->delete();

                Task::descendantsOf($id)->delete();

                Task::destroy($id);

                return 'Task Removed Successfully';
            }
        }

        $task->isdeleted = '1';
        $task->save();

        if ($task->projectid != '') {

            $projecttype = 'project';
        }else {
            $projecttype = 'custom';
        }

        //workflow
        if ( $projecttype == 'project') {

            if ($CompanyWorkflowCheckProject != '') {

                $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Project Task')->first();

                if ($WorkflowUpperLevel != '') {

                    $upperlevel = $WorkflowUpperLevel->upperlevel;

                }
            }
        }else {
            if ($CompanyWorkflowCheckCustom != '') {

                $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Custom Task')->first();

                if ($WorkflowUpperLevel != '') {

                    $upperlevel = $WorkflowUpperLevel->upperlevel;

                }
            }else {
                $upperlevel = 0;
            }
        }


        if ($task->parent_id != null) {

            if ( $projecttype == 'project') {

                if ($CompanyWorkflowCheckProject != '') {

                    $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'task' , $id);
                }

            }else {

                if ($CompanyWorkflowCheckCustom != '') {

                    $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'task' , $id);                 }
            }

        }else {


            if ( $projecttype == 'project') {

                if ($CompanyWorkflowCheckProject != '') {

                    $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'task' , $id);
                }

            }else {

                if ($CompanyWorkflowCheckCustom != '') {

                    $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'task' , $id);
                }
            }

        }



        return 'Task Assigned';
    }

    //User Actiones;

    public function approvetask(Request $request){

        $taskid  =  $request->taskid;

        $process = Process::where('taskid' , '=' , $taskid)->where('userid' , '=' , auth()->user()->id)->where('status' , '=' , 'Pending Approve')->first();

        //Check if process exists before approved
        if (!isset($process)){
            return 'No Task Found';
        }

        $process->status = 'Approved';
        $process->save();

        $checkwaitingapprove = Process::where('taskid' , '=' , $taskid)->where('status' , '=' , 'Waiting Approve')->orderby('priority')->first();
        $checkwaitingconfirm = Process::where('taskid' , '=' , $taskid)->where('status' , '=' , 'Waiting Confirm')->get();

        if ($checkwaitingapprove != '') {

            $checkwaitingapprove->status = 'Pending Approve';
            $checkwaitingapprove->save();

        }elseif($checkwaitingconfirm != '') {

            foreach ($checkwaitingconfirm as $checkwaitingconfirms) {

                $checkwaitingconfirms->status = 'Pending Confirm';
                $checkwaitingconfirms->save();
           }

        }else {

            $this->updatetaskstatus($taskid , 'Approved');
        }

        return 'Approved';

    }

    public function confirmtask(Request $request){

        $taskid  =  $request->taskid;

        $process = Process::where('taskid' , '=' , $taskid)
        ->where('userid' , '=' , auth()->user()->id)
        ->where('status' , '=' , 'Pending Confirm')
        ->first();
        $checkpendingconfirm = Process::where('taskid' , '=' , $taskid)
        ->where('status' , '=' , 'Pending Confirm')
        ->get();

        //Check if process exists before Confirmed
        if (!isset($process)){
            return 'No Task Found';
        }

        if ($checkpendingconfirm != Null) {

            $process->status = 'Confirmed';
            $process->save();

            $this->updatetaskstatus($taskid , 'Confirmed');

        }

        return 'Confirmed';

    }

    public function rejecttask(Request $request){

        $taskid  =  $request->taskid;

        $description = $request->description;

        $task = Task::find($taskid);

        $isroot = $task->isRoot();

        //return json_encode($isroot) ;

        if ($isroot == false ) {

            return 'You Cant Reject Subtask';
        }

        $process = Process::where('taskid' , '=' , $taskid)->where('userid' , '=' , auth()->user()->id)->where('status' , '=' , 'Pending Approve')->first();

        //Check if Process exists before Edeting
        if (!isset($process)){
            return 'No Task Found To Reject';
        }

        $process->status = 'Rejected';
        $process->description = $description;
        $process->save();

        $processwaiting = Process::where('taskid' , '=' , $taskid)->where('status' , 'LIKE' , '%Waiting%')->get();

        foreach ($processwaiting as $processwaitings) {
            $processwaitings->status = 'Faild';
            $processwaitings->save();
        }

        $this->updatetaskstatus($taskid , 'Rejected');

        return 'Rejected';

    }

    public function SubmitReviewedTask(Request $request){

        $taskid = $request->taskid;

        $process = Process::where('taskid' , '=' , $taskid)->where('status' , '=' , 'Pending Review')->first();

        $process->status = 'Reviewed';
        $process->save();

        return $this->updatetaskstatus($request->taskid , 'SubmitReviewedTask');
    }

    public function SubmitToReview(Request $request){

        $taskid = $request->taskid;

        return $this->updatetaskstatus($taskid , 'SubmitToReview');
    }

    public function GetExtraUpperApprove(Request $request){

        $task = Task::find($request->taskid);
        $user_id = auth()->user()->id;
        $isactive = $this->GetIsActiveStatus('task', $task->relatedid);

        $process = Process::where('taskid' , '=' , $request->taskid)->where('userid' , '=' , auth()->user()->id)->where('status' , '=' , 'Pending Approve')->first();

        //Check if process exists before approved
        if (!isset($process)){
            return 'No Task Found';
        }

        //Approve orginal process before request extra upper Approve
        $process->status = 'Approved';
        $process->save();

        $upperid = $this->getupper($user_id);

        if ($upperid != '') {

            $this->approve($request->taskid , $upperid ,  $isactive);
        }

        return 'Extra Upper Approve Has Been Submited!!!';

    }

    public function AssignTaskToUsers($userid, $assignedid,  $taskid){

        if ($assignedid == null) {

            $usertask = new UserTask;
            $usertask->taskid =  $taskid;
            $usertask->userid = $userid;

            $usertask->save();

            return 'Done For User';
        }

        $rolegroupid = UserRoleGroupCompany::where('userid' , '=' , $userid)->min('rolegroupcompanyid');

        $UserRolegroupCompany = RoleGroupCompany::where('id' , '=' , $rolegroupid)->first();

        switch ($UserRolegroupCompany) {

            case 'Head Of Section(HOS)':

                    $user = User::find($userid);

                    $SectionUsers = User::where('sectionid', '=', $user->sectionid)->get();

                    foreach ($SectionUsers as $SectionUser) {

                        $usertask = new UserTask;
                        $usertask->taskid =  $taskid;
                        $usertask->userid = $SectionUser->id;

                        $usertask->save();

                    }

                    return 'Done For Section Users';

                break;
            case 'Head Of Unit(HOU)':

                    $user = User::find($userid);

                    $UnitUsers = User::where('unitid', '=', $user->unitid)->get();

                    foreach ($UnitUsers as $UnitUser) {

                        $usertask = new UserTask;
                        $usertask->taskid =  $taskid;
                        $usertask->userid = $UnitUser->id;

                        $usertask->save();

                    }

                    return 'Done For Unit Users';

                break;
            case 'Director (Department Manager)':

                    $user = User::find($userid);

                    $DepartmentUsers = User::where('departmentid', '=', $user->departmentid)->get();

                    foreach ($DepartmentUsers as $DepartmentUser) {

                        $usertask = new UserTask;
                        $usertask->taskid =  $taskid;
                        $usertask->userid = $DepartmentUser->id;

                        $usertask->save();

                    }

                    return 'Done For Department Users';

                break;
            case 'Manager':

                    $user = User::find($userid);

                    $ProjectManagerDepartmentUsers = User::where('departmentid', '=', $user->departmentid)->get();

                    foreach ($ProjectManagerDepartmentUsers as $ProjectManagerDepartmentUser) {

                        $usertask = new UserTask;
                        $usertask->taskid =  $taskid;
                        $usertask->userid = $ProjectManagerDepartmentUser->id;

                        $usertask->save();

                    }

                   return 'Done For Project Manager Department Users';

                break;

            default:

                    $usertask = new UserTask;
                    $usertask->taskid =  $taskid;
                    $usertask->userid = $userid;

                    $usertask->save();

                    return 'Done For Users';

                break;
        }


    }

    public function TaskFilter(Request $request){

        $startdate = $request->startdate;
        $enddate = $request->enddate;
        //$createdby = $request->createdby;
        $type = $request->type;
        $projectid = $request->projectid;
        $label = $request->label;
        $dependontask = $request->dependontask;
        $parent_id = $request->parent_id;

        if ($startdate != Null ){

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where('startdate', '>' , $startdate);

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('startdate', '>' , $startdate);

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('startdate', '>' , $startdate);

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('startdate', '>' , $startdate);

        }

        if ($enddate != Null ){

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where('enddate', '<' , $enddate);

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('enddate', '<' , $enddate);

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('enddate', '<' , $enddate);

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('enddate', '<' , $enddate);

        }


        if ($type != Null) {

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where('tickets.type', 'LIKE' , '%' . $type . '%');

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('tasks.type', 'LIKE' , '%' . $type . '%');

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('tasks.type', 'LIKE' , '%' . $type . '%');

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('type', 'LIKE' , '%' . $type . '%');

        }


        if ($projectid != Null) {

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where( 'tickets.id' , '=' ,  -1);

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('tasks.projectid', '=' , $projectid);

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('tasks.projectid', '=' , $projectid);

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('tasks.projectid', '=' , $projectid);

        }

        if ($label != Null) {

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where( 'tickets.id' , '=' ,  -1);

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('tasks.label',  'LIKE' ,'%' . $label . '%');

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('tasks.label', 'LIKE' ,'%' . $label . '%');

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('tasks.label',  'LIKE' ,'%' . $label . '%');

        }

        if ($dependontask != Null) {

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where( 'tickets.id' , '=' , -1);

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('tasks.dependontask', '=' , $dependontask);

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('tasks.dependontask', '=' , $dependontask);

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('tasks.dependontask', '=' , $dependontask);

        }

        if ($parent_id != Null) {

            $ticket = $this->SelectTicket();
            $ticket = $ticket->where( 'tickets.id' , '=' , -1);

            $approveprocesstask = $this->SelectConfirmTask();
            $approveprocesstask = $approveprocesstask->where('tasks.parent_id', '=' , $parent_id);

            $confirmprocesstask = $this->SelectApprovedTask();
            $confirmprocesstask = $confirmprocesstask->where('tasks.parent_id', '=' , $parent_id);

            $projecttask = $this->SelectProjectTask();
            $projecttask = $projecttask->where('tasks.parent_id', '=' , $parent_id);

        }

        if ($startdate == Null && $enddate == Null &&$type == Null && $projectid == Null
            && $label == Null && $dependontask == Null && $parent_id == Null ) {

            $ticket = $this->SelectTicket();
            $approveprocesstask = $this->SelectConfirmTask();
            $confirmprocesstask = $this->SelectApprovedTask();
            $projecttask = $this->SelectProjectTask();
        }

            $ticket = $ticket->get();
            $approveprocesstask = $approveprocesstask->get();
            $confirmprocesstask = $confirmprocesstask->get();
            $projecttask = $projecttask->get();


            return (['ticket'=>$ticket, 'approveprocesstask'=>$approveprocesstask, 'confirmprocesstask'=>$confirmprocesstask, 'projecttask'=>$projecttask ]);

    }


    public function SelectTicket(){

        $ticket = DB::table('tickets')
            ->select(
                'tickets.id',
                //DB::raw('CONCAT(tickets.name, " ", tickets.type) AS Ticket'),
                DB::raw('tickets.name AS Ticket'),
                'tickets.description',
                'tickets.startdate',
                'tickets.enddate',
                'tickets.type',
                'tickets.status',
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
            )
            ->join('processes', 'processes.ticketid', '=', 'tickets.id')
            ->join('process_types', 'process_types.id', '=', 'processes.typeid')
            ->join('user_tickets', 'user_tickets.ticketid', '=', 'tickets.id')
            ->join('users', 'tickets.createdby', '=', 'users.id')

            ->where('processes.userid' , '=' , auth()->user()->id)
            ->where('processes.status' , 'LIKE' , '%Pending%')
            ->where('processes.isactive' , '=' , 'active')

        ;

            return $ticket;
        }

        public function SelectApprovedTask(){

            $approveprocesstask = DB::table('tasks')
            ->select(
                'tasks.id',
                 DB::raw('CONCAT(tasks.name, " ", tasks.relatedto) AS Task'),
                'tasks.description',
                'tasks.startdate',
                'tasks.enddate',
                //'tasks.projectid',
                //DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
                'tasks.priority',
                //'tasks.status',
                //'tasks.isactive',
                'processes.priority',
                'processes.status as status',
                'process_types.type',
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')

            )
            ->join('processes', 'processes.taskid', '=', 'tasks.id')
            ->join('process_types', 'process_types.id', '=', 'processes.typeid')
            ->join('users', 'users.id', '=', 'tasks.createdby')

            ->where('processes.status' , 'LIKE' , '%Pending Approve%')
            ->where('processes.userid' , '=' , auth()->user()->id)
            ->where('processes.isactive' , '=' , 'active')
            ->where('tasks.isdeleted' , '=' , Null)
            ;

            return $approveprocesstask;
        }

        public function SelectConfirmTask(){

            $confirmprocesstask = DB::table('tasks')
            ->select(
                'tasks.id',
                 DB::raw('CONCAT(tasks.name, " ", tasks.relatedto) AS Task'),
                'tasks.description',
                'tasks.startdate',
                'tasks.enddate',
                //'tasks.projectid',
                //DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
                'tasks.priority',
                //'tasks.status',
                //'tasks.isactive',
                'processes.priority',
                'processes.status as status',
                'process_types.type',
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')

            )
            ->join('processes', 'processes.taskid', '=', 'tasks.id')
            ->join('process_types', 'process_types.id', '=', 'processes.typeid')
            ->join('users', 'users.id', '=', 'tasks.createdby')

            ->where('processes.status' , 'LIKE' , '%Pending Confirm%')
            ->where('processes.userid' , '=' , auth()->user()->id)
            ->where('processes.isactive' , '=' , 'active')
            ->where('tasks.isdeleted' , '=' , Null)
            ;

            return $confirmprocesstask;
        }



    public function SelectProjectTask(){

        $projecttask = DB::table('tasks')
        ->select(
            'tasks.id',
            'tasks.name',
            'tasks.description',
            'tasks.startdate',
            'tasks.enddate',
            'tasks.type',
            'tasks.priority',
            'tasks.status',
            DB::raw("(select projects.name from projects where projects.id = tasks.projectid) AS Project"),
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
        )
        ->join('user_tasks', 'user_tasks.taskid', '=', 'tasks.id')
        ->join('users', 'tasks.createdby', '=', 'users.id')

        ->where('user_tasks.userid' , '=' , auth()->user()->id)
        ->where('tasks.isactive' , '=' , 'active')
        ->where('tasks.isdeleted' , '=' , Null)

        ->whereNotExists(function($query)
                {
                    $query->select(DB::raw(1))
                          ->from('processes')
                          ->whereRaw('processes.taskid = tasks.id')
                          ->where('processes.status' , 'LIKE' , '%Pending Review%');
                })

        ;

        return $projecttask;
    }


    public function PullTask($taskid){

        $usertask = new UserTask;
        $usertask->taskid = $taskid;
        $usertask->userid = auth()->user()->id;

        $usertask->save();

        return 'Task Pulled';
    }


}
