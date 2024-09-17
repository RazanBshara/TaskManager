<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TaskWorkflow;
use App\Traits\destroyTrait;
use DB;
use Session;
use Carbon\Carbon;

use App\Models\Workspace;
use App\Models\User;
use App\Models\Task;
use App\Models\Unit;
use App\Models\WorkflowUpperLevel;
use App\Models\CompanyWorkflow;
use App\Models\Department;
use App\Models\Section;
use App\Models\UserRoleGroupCompany;
use App\Models\RoleGroupCompany;
use App\Models\UserWorkspace;


//use App\Traits\TaskRun;

//Session::put('companyid', $id);
//Session::get('companyid');

class WorkspaceController extends Controller
{
    use TaskWorkflow;
    use destroyTrait;
    //use TaskRun;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
       // $this->middleware('CheckPermission');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::find(auth()->user()->id);

        $companyid = $user->companyid;

        $workspace = DB::table('workspaces')
            ->join('user_workspaces', 'workspaces.id', '=', 'user_workspaces.workspaceid')
            ->where('user_workspaces.userid' , '=' , auth()->user()->id)
            ->where('workspaces.isactive' , '=' , 'active')
            ->where('workspaces.isdeleted' , '=' , Null)
            ->select(
                'workspaces.id',
                'workspaces.name',
                'workspaces.description',
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.managerid) as ManagerName")
            )
            ->get();

        return $workspace;
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
        ]);

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'workspace')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        // Create Workspace
        $workspace = new Workspace;
        $workspace->name = $request->input('name');
        $workspace->description = $request->input('description');
        $workspace->createdby = $user->id;
        $workspace->managerid = $user->id;

        //get the companyid automaticly
        $workspace->companyid = $user->companyid;

        if ($CompanyWorkflowCheck == '[]') {

            $workspace->isactive = 'active';
        }

        $workspace->save();

        //

        $WorkspaceType = $request->type;

        $this->CreateUserWorkspace(auth()->user()->id , $workspace->id , $WorkspaceType);


        //

        Session::put('workspaceid', $workspace->id);

        //workflow
        if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Workspace')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }
        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'workspace' , $workspace->id );
        }

        return $workspace;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Session::put('workspaceid', $id);

        //check if active
        $Workspacecheckactive = Workspace::find($id);

        if ($Workspacecheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $Workspace = DB::table('workspaces')->where('id' , '=' , $id)
        ->select(
            'workspaces.name',
            'workspaces.description',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.managerid) as WorkspaceManager"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = workspaces.createdby) as createdby"),
            DB::raw("(SELECT companies.name FROM companies
                        WHERE companies.id = workspaces.companyid) as Company")
        )
        ->where('workspaces.id' , '=' , $id)
        ->where('workspaces.isdeleted' , '=' , Null)
        ->get();

        return $Workspace;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$Workspace = Workspace::select(
            'workspaces.name',
            'workspaces.description',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.managerid) as WorkspaceManager"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                        WHERE users.id = workspaces.createdby) as createdby"),
            DB::raw("(SELECT companies.name FROM companies
                        WHERE companies.id = workspaces.companyid) as Company")
        )
        ->where('id' , '=' , $id)
        ->where('workspaces.isdeleted' , '=' , Null)
        ->get();*/

        $Workspace = Workspace::find($id);

        return $Workspace;

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
        ]);

        //check if active
        $Workspacecheckactive = Workspace::find($id);

        if ($Workspacecheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'workspace')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $orginalworkspace = Workspace::find($id);

        if ($CompanyWorkflowCheck == '[]') {

            $orginalworkspace->name = $request->input('name');
            $orginalworkspace->description = $request->input('description');

            $orginalworkspace->save();

            return $orginalworkspace;
        }

        // Update workspace
        $workspace = new Workspace;
        $workspace->name = $request->input('name');
        $workspace->description = $request->input('description');
        $workspace->createdby = $orginalworkspace->createdby;
        $workspace->managerid = $orginalworkspace->managerid;

        //get the companyid automaticly
        $workspace->companyid = $orginalworkspace->companyid;

        $workspace->updatingfor = $id;
        $workspace->save();

         //workflow
         if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Workspace')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }
        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'workspace' , $id);
        }
        return $workspace;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
         //check if active
         $Workspacecheckactive = Workspace::find($id);

         if ($Workspacecheckactive->isactive != 'active') {

             return 'Not Exists';
         }
         ///////

        $workspace = Workspace::find($id);

        //Check if Workspace exists before deleting
        if (!isset($workspace)){
            return 'No Workspace Found';
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'workspace')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        if ($CompanyWorkflowCheck == '[]') {

            $this->deleteproject($id);

            $workspace::destroy($id);

            return 'Workspace Removed Successfully';
        }

        $workspace->isdeleted = '1';
        $workspace->save();

         //workflow
         if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Workspace')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'workspace' , $id);
        }

        return 'Task Assigned';

    }

    public function FetchData(Request $request){

        $departmentid = $request->departmentid;
        $unitid  = $request->unitid;

        $user = User::find(auth()->user()->id);

        $companyid = $user->companyid;

        //Units

        if ( $departmentid == '' || $departmentid == Null ) {

            $units = '';
            $sections = '';

        }elseif ( $unitid == '' || $unitid == Null ) {

            $units = DB::table('units')
            ->where('units.departmentid' , '=' , $departmentid)
                ->select(
                    'units.id',
                    'units.name',
                    'units.departmentid'
                )
                ->where('units.isdeleted' , '=' , Null)
                ->get();

                $sections = '';

            }else{

                $units = DB::table('units')
                ->where('id' , '=' , $unitid)
                    ->select(
                        'units.id',
                        'units.name',
                        'units.departmentid'
                    )
                    ->where('units.isdeleted' , '=' , Null)
                    ->get();


                    $sections = DB::table('sections')
                    ->where('sections.unitid' , '=' , $unitid)
                    ->select(
                            'sections.id',
                            'sections.name'
                        )
                        ->where('sections.isdeleted' , '=' , Null)
                        ->get();

            }

        return (['units'=>$units , 'sections'=>$sections]);

    }

    public function assign_manager_to_workspace(Request $request){

        $workspaceid = $request->input('workspaceid');
        $managerid = $request->input('managerid');

        $workspace = Workspace::find($workspaceid);
        $workspace->managerid = $managerid;
        $workspace->save();

        return 'Manager is Appointed';

    }

    public function CreateUserWorkspace($userid, $workspaceid, $WorkspaceType){

        if ($WorkspaceType == 'Personal Workspace') {

            $UserWorkspace = new UserWorkspace();
            $UserWorkspace->userid = $userid;
            $UserWorkspace->workspaceid = $workspaceid;

            $UserWorkspace->save();

            return 'Done For User';
        }

        $rolegroupid = UserRoleGroupCompany::where('userid' , '=' , $userid)->min('rolegroupcompanyid');

        $UserRolegroupCompany = RoleGroupCompany::where('id' , '=' , $rolegroupid)->first();

        switch ($UserRolegroupCompany) {

            case 'Head Of Section(HOS)':

                    $user = User::find($userid);

                    $SectionUsers = User::where('sectionid', '=', $user->sectionid)->get();

                    foreach ($SectionUsers as $SectionUser) {

                        $UserWorkspace = new UserWorkspace();
                        $UserWorkspace->userid = $SectionUser->id;
                        $UserWorkspace->workspaceid = $workspaceid;

                        $UserWorkspace->save();

                    }

                    return 'Done For Section Users';

                break;
            case 'Head Of Unit(HOU)':

                    $user = User::find($userid);

                    $UnitUsers = User::where('unitid', '=', $user->unitid)->get();

                    foreach ($UnitUsers as $UnitUser) {

                        $UserWorkspace = new UserWorkspace();
                        $UserWorkspace->userid = $UnitUser->id;
                        $UserWorkspace->workspaceid = $workspaceid;

                        $UserWorkspace->save();

                    }

                    return 'Done For Unit Users';

                break;
            case 'Director (Department Manager)':

                    $user = User::find($userid);

                    $DepartmentUsers = User::where('departmentid', '=', $user->departmentid)->get();

                    foreach ($DepartmentUsers as $DepartmentUser) {

                        $UserWorkspace = new UserWorkspace();
                        $UserWorkspace->userid = $DepartmentUser->id;
                        $UserWorkspace->workspaceid = $workspaceid;

                        $UserWorkspace->save();

                    }

                    return 'Done For Department Users';

                break;
            case 'Manager':

                    $user = User::find($userid);

                    $ProjectManagerDepartmentUsers = User::where('departmentid', '=', $user->departmentid)->get();

                    foreach ($ProjectManagerDepartmentUsers as $ProjectManagerDepartmentUser) {

                        $UserWorkspace = new UserWorkspace();
                        $UserWorkspace->userid = $ProjectManagerDepartmentUser->id;
                        $UserWorkspace->workspaceid = $workspaceid;

                        $UserWorkspace->save();

                    }

                   return 'Done For Project Manager Department Users';

                break;

            default:

                    $UserWorkspace = new UserWorkspace();
                    $UserWorkspace->userid = $userid;
                    $UserWorkspace->workspaceid = $workspaceid;

                    $UserWorkspace->save();

                    return 'Done For User';

                break;
        }


    }


}
