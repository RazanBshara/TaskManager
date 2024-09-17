<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\Project;
use App\Models\User;
 

class ProjectAdminController extends Controller
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
        $project = DB::table('projects')
            ->select(
                'projects.id',
                'projects.name',
                'projects.description',
                'projects.startdate',
                'projects.enddate',
                'projects.status',
                'projects.label',       
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = projects.pmid) as ProjectManager"),
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = projects.createdby) as Createdby"),
                DB::raw("(SELECT workspaces.name FROM workspaces
                            WHERE workspaces.id = projects.workspaceid) as Createdby"),
                'projects.isactive', 
                'projects.created_at', 
                
            )                     
            ->distinct()
            ->orderBy('created_at','desc')->paginate(10);

            return $project;
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

        $pm = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $workspaces = DB::table('workspaces')
        ->select(
            'workspaces.id',
            'workspaces.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);


        return (['workspaces'=>$workspaces , 'user'=>$user , 'pm'=>$pm]);
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
            'userid' => 'required',
            'workspaceid' => 'required'
        ]);

        // Create Project
        $project = new Project;
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->status = $request->input('status');
        $project->startdate = $request->input('startdate');
        $project->enddate = $request->input('enddate');
        $project->userid = $request->input('userid');
        $project->workspaceid = $request->input('workspaceid');
        $project->pmid = $request->input('pmid');

        $project->save();

        return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = DB::table('projects')
        ->select(
            'projects.id',
            'projects.name',
            'projects.description',
            'projects.startdate',
            'projects.enddate',
            'projects.status',
            'projects.label',       
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = projects.pmid) as ProjectManager"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = projects.createdby) as Createdby"),
            DB::raw("(SELECT workspaces.name FROM workspaces
                        WHERE workspaces.id = projects.workspaceid) as Createdby"),
            'projects.isactive', 
            'projects.created_at', 
            
        )                     
        ->distinct()
        ->orderBy('created_at','desc')->paginate(10);

        return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = DB::table('projects')
        ->select(
            'projects.id',
            'projects.name',
            'projects.description',
            'projects.startdate',
            'projects.enddate',
            'projects.status',
            'projects.label',       
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = projects.pmid) as ProjectManager"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = projects.createdby) as Createdby"),
            DB::raw("(SELECT workspaces.name FROM workspaces
                        WHERE workspaces.id = projects.workspaceid) as Createdby"),
            'projects.isactive', 
            'projects.created_at', 
            
        )                     
        ->distinct()
        ->orderBy('created_at','desc')->paginate(10);

        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $pm = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $workspaces = DB::table('workspaces')
        ->select(
            'workspaces.id',
            'workspaces.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);


        return (['workspaces'=>$workspaces , 'user'=>$user , 'pm'=>$pm , 'project'=>$project]);        
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
            'userid' => 'required',
            'workspaceid' => 'required'
        ]);

        $project = Project::find($id);

        // Update project
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->status = $request->input('status');
        $project->startdate = $request->input('startdate');
        $project->enddate = $request->input('enddate');
        $project->userid = $request->input('userid');
        $project->workspaceid = $request->input('workspaceid');
        $project->pmid = $request->input('pmid');
        $project->save();

        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        //Check if Project exists before deleting
        if (!isset($project)){
            return 'No Project Found';
        }

        $this->deletetask($id);

        ProjectDepartmentUnitSectionUser::where('projectid' , '=' , $id)->delete();

        Project::destroy($id);

        return 'Project Removed Successfully';
    }
}
