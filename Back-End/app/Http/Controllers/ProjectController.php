<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TaskWorkflow;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectDepartmentUnitSectionUser;
use App\Models\WorkflowUpperLevel;
use App\Models\CompanyWorkflow;
use App\Models\UserRoleGroupCompany;
use App\Models\RoleGroupCompany;

class ProjectController extends Controller
{
    use TaskWorkflow;
    use destroyTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        //$this->middleware('CheckPermission');

    }
    public function ProjectIndex($id)
    {
        $user = User::find(auth()->user()->id);

        //$workspaceid = Session::get('workspaceid');

        $workspaceid = $id;

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
            ->join('project_department_unit_section_users', 'projects.id', '=', 'project_department_unit_section_users.projectid')
            ->join('workspaces', 'workspaces.id', '=', 'projects.workspaceid')

            ->where('projects.isactive' , '=' , 'active')
            ->where('projects.workspaceid' , '=' ,  $workspaceid)
            ->where('projects.isdeleted' , '=' , Null)
            ->whereRaw('(project_department_unit_section_users.userid = ? or
                        project_department_unit_section_users.sectionid = ? or
                        project_department_unit_section_users.unitid = ? or
                        project_department_unit_section_users.departmentid = ?
                        )', [$user->id, $user->sectionid , $user->unitid , $user->departmentid])

            ->distinct()
            ->get();

        return $project;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /* public function index()
    {

        //for project in sidebar
        $user = User::find(auth()->user()->id);

        //$workspaceid = Session::get('workspaceid');

        $workspaceid = 37;

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
            ->join('project_department_unit_section_users', 'projects.id', '=', 'project_department_unit_section_users.projectid')
            ->join('workspaces', 'workspaces.id', '=', 'projects.workspaceid')
            ->where('projects.isactive' , '=' , 'active')
            ->where('projects.workspaceid' , '=' ,  $workspaceid)
            ->where('projects.isdeleted' , '=' , Null)
            ->whereRaw('(project_department_unit_section_users.userid = ? or
                        project_department_unit_section_users.sectionid = ? or
                        project_department_unit_section_users.unitid = ? or
                        project_department_unit_section_users.departmentid = ?
                        )', [$user->id, $user->sectionid , $user->unitid , $user->departmentid])

            ->distinct()
            ->get();

        return $project;
    }*/

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
            'name' => 'required'
        ]);

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'project')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        // Create Project
        $project = new Project;
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->startdate = $request->input('startdate');
        $project->enddate = $request->input('enddate');
        if ($request->label != '') {
            $project->label = $request->input('label');
        }
        $project->pmid = auth()->user()->id;//$request->input('pmid');
        $project->createdby = auth()->user()->id;
        //get workspaceid automaticly

        //$project->workspaceid =  Session::get('workspaceid');
        $project->workspaceid = $request->workspaceid;

        if ($CompanyWorkflowCheck == '[]') {

            $project->isactive = 'active';
        }

        $project->save();

        //

        $ProjectType = $request->ProjectType;

        $this->CreateUserProject(auth()->user()->id , $project->id, $ProjectType);

        //

        Session::put('projectid', $project->id);

        //workflow
        if ($CompanyWorkflowCheck == '[]') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Project')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }

        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'project' , $project->id );
        }

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
                            WHERE users.id = projects.pmid) as ProjectManager")
            )->where('id', '=', $id )
            ->where('projects.isdeleted' , '=' , Null)
            ->get();

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
        /*$project = Project::where('id', '=', $id )
                        ->where('projects.isdeleted' , '=' , Null)
                        ->select(
                            'projects.id',
                            'projects.name',
                            'projects.description',
                            'projects.startdate',
                            'projects.enddate',
                            'projects.status',
                            'projects.label',
                            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                        WHERE users.id = projects.pmid) as ProjectManager")
                        )
                        ->get();*/
                        
        $project = Project::find($id);

        return $project;

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
        $projectcheckactive = Project::find($id);

        if ($projectcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'project')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();


        $orginalproject = Project::find($id);

        if ($CompanyWorkflowCheck == '[]') {

            $orginalproject->name = $request->input('name');
            $orginalproject->description = $request->input('description');
            $orginalproject->enddate = $request->input('enddate');
            $orginalproject->label = $request->input('label');
            $orginalproject->pmid = auth()->user()->id;

            $orginalproject->save();

            return $orginalproject;
        }

        // Update project
        $project = new Project;
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->startdate = $orginalproject->startdate;
        $project->enddate = $request->input('enddate');
        $project->label = $request->input('label');
        $project->createdby = $orginalproject->createdby;
        $project->pmid = $orginalproject->pmid;
        //get workspaceid automaticly
        $project->workspaceid =  $orginalproject->workspaceid;

        $project->updatingfor = $id;
        $project->save();

        //workflow
        if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Project')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }
        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'project' , $id);
        }

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

        //check if active
        $Projectcheckactive = Project::find($id);

        if ($Projectcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $project = Project::find($id);

        //Check if Task exists before deleting
        if (!isset($project)){
            return 'No Task Found';
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'project')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        if ($CompanyWorkflowCheck == '[]') {

            $this->deletetask($id);

            ProjectDepartmentUnitSectionUser::where('projectid' , '=' , $id)->delete();

            Project::destroy($id);

            return 'Project Removed Successfully';
        }

        $project->isdeleted = '1';
        $project->save();

        //workflow
        if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Project')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'project' , $id);
        }


        return 'Task Assigned';
    }

    //assign project to ProjectDepartmentUnitSectionUser

    public function assign_project(Request $request)
    {
        $userid = $request->input('userid');
        $sectionid =$request->input('sectionid');
        $unitid =  $request->input('unitid');
        $departmentid = $request->input('departmentid');
        $projectid =$request->input('projectid');

        if ($userid != null) {

            $user = User::find($userid);

            $ProjectUser = new ProjectDepartmentUnitSectionUser;
            $ProjectUser->projectid = $projectid;
            $ProjectUser->userid = $userid;

            $ProjectUser->save();

            return 'Done For User';

        }elseif ($userid == null and $sectionid != null) {

            $ProjectSectionUser = new ProjectDepartmentUnitSectionUser;
            $ProjectSectionUser->projectid = $projectid;
            $ProjectSectionUser->sectionid = $sectionid;

            $ProjectSectionUser->save();

            return 'Done For Section';

        }elseif ($userid == null and $sectionid == null and $unitid != null) {

            $ProjectUnitSectionUser = new ProjectDepartmentUnitSectionUser;
            $ProjectUnitSectionUser->projectid = $projectid;
            $ProjectUnitSectionUser->unitid = $unitid;

            $ProjectUnitSectionUser->save();

            return 'Done For Unit';

        }elseif ($userid == null and $sectionid == null and $unitid == null and $departmentid != null) {

            $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser;
            $ProjectDepartmentUnitSectionUser->projectid = $projectid;
            $ProjectDepartmentUnitSectionUser->departmentid = $departmentid;

            $ProjectDepartmentUnitSectionUser->save();

            return 'Done For Department';
        }

        return 'The Assign Procees Faild';

    }

    public function assign_PM_to_project(Request $request){

        $projectid = $request->input('projectid');
        $pmid = $request->input('pmid');

        $Project = Project::find($projectid);
        $Project->pmid = $pmid;
        $Project->save();

        $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser;
        $ProjectDepartmentUnitSectionUser->projectid = $projectid;
        $ProjectDepartmentUnitSectionUser->userid = $pmid;
        $ProjectDepartmentUnitSectionUser->save();

        return 'Project Manager is Appointed';

    }


    public function CreateUserProject($userid, $projectid, $ProjectType){

        if ($ProjectType == 'Personal Project') {

            $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser();
            $ProjectDepartmentUnitSectionUser->projectid = $projectid;
            $ProjectDepartmentUnitSectionUser->userid = auth()->user()->id;

            $ProjectDepartmentUnitSectionUser->save();

            return 'Done For User';
        }


        $rolegroupid = UserRoleGroupCompany::where('userid' , '=' , $userid)->min('rolegroupcompanyid');

        $UserRolegroupCompany = RoleGroupCompany::where('id' , '=' , $rolegroupid)->first();

        switch ($UserRolegroupCompany) {

            case 'Head Of Section(HOS)':

                    $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser();
                    $ProjectDepartmentUnitSectionUser->projectid = $projectid;
                    $ProjectDepartmentUnitSectionUser->sectionid = $user->sectionid;

                    $ProjectDepartmentUnitSectionUser->save();

                    return 'Done For Section Users';

                break;
            case 'Head Of Unit(HOU)':

                    $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser();
                    $ProjectDepartmentUnitSectionUser->projectid = $projectid;
                    $ProjectDepartmentUnitSectionUser->unitid = $user->unitid;

                    $ProjectDepartmentUnitSectionUser->save();

                    return 'Done For Unit Users';

                break;
            case 'Director (Department Manager)':

                    $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser();
                    $ProjectDepartmentUnitSectionUser->projectid = $projectid;
                    $ProjectDepartmentUnitSectionUser->departmentid = $user->departmentid;

                    $ProjectDepartmentUnitSectionUser->save();

                    return 'Done For Department Users';

                break;

            case 'Manager':

                    $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser();
                    $ProjectDepartmentUnitSectionUser->projectid = $projectid;
                    $ProjectDepartmentUnitSectionUser->departmentid = $user->departmentid;

                    $ProjectDepartmentUnitSectionUser->save();

                    return 'Done For Project Manager Department Users';

                break;
            default:

                    $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser();
                    $ProjectDepartmentUnitSectionUser->projectid = $projectid;
                    $ProjectDepartmentUnitSectionUser->userid = auth()->user()->id;

                    $ProjectDepartmentUnitSectionUser->save();

                    return 'Done For User';

                break;
        }
    }


}
