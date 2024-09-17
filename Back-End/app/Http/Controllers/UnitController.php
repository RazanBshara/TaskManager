<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TaskWorkflow;
use App\Traits\destroyTrait;

use App\Models\Unit;
use App\Models\User;
use App\Models\WorkflowUpperLevel;
use Session;
use DB;
use App\Models\CompanyWorkflow;
use App\Models\Department;


class UnitController extends Controller
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
    public function index()
    {
        $user = User::find( auth()->user()->id);

        return DB::table('units')
        ->select(
            'units.name',
            'units.description',
            DB::raw("(select CONCAT(users.firstname, ' ', users.lastname) from users where users.id = units.hou) as hou"),
            DB::raw("(select workspaces.name from workspaces where workspaces.id = units.workspaceid) as hou"),
            DB::raw("(select departments.name from departments where departments.id = units.departmentid) as department")
        )
        ->where('departmentid' , '=' , $user->departmentid)
        ->where('isactive' , '=' , 'active')
        ->where('units.isdeleted' , '=' , Null)

        ->orderBy('created_at','desc')
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(auth()->user()->id);

        $hou =  DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            DB::raw(' role_group_companies.adjictive AS Role'),

        )
        ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
        ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

        ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 6)
        ->where('users.companyid', '=', $user->companyid)

        ->whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('user_role_group_companies')
                  ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')
                  ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 6);
        })

        ->orderBy('users.created_at','asc')
        ->paginate(5);

        $department = Department::where('companyid', '=', $user->companyid)->get();

        return (['department'=>$department, 'hou'=>$hou]);

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
            'name' => 'required|unique:units,name'
        ]);

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'unit')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        // Create Unit
        $unit = new Unit;
        $unit->name = $request->input('name');
        $unit->description = $request->input('description');
        $unit->hou =  $request->input('hou');
        $unit->departmentid =$request->input('departmentid');

        if ($CompanyWorkflowCheck == '[]') {

            $unit->isactive = 'active';
        }

        $unit->save();

        //Session::put('unitid', $unit->id);

        //workflow
        if ($CompanyWorkflowCheck == '[]') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Unit')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }

        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'unit' , $unit->id );
        }

        return $unit;
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
        $Unitcheckactive = Unit::find($id);

        if ($Unitcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        return Unit::find($id);
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
            'name' => 'required'
        ]);

        //check if active
        $Unitcheckactive = Unit::find($id);

        if ($Unitcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $user = User::find(auth()->user()->id);

        $CompanyWorkflow = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'unit')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $orginalunit = Unit::find($id);

        if ($CompanyWorkflow == '[]') {

            $orginalunit->name = $request->input('name');
            $orginalunit->description = $request->input('description');
            $orginalunit->hou =  $request->input('hou');

            $orginalunit->save();

            return $orginalunit;
        }

        // Update Unit
        $unit = new Unit;
        $unit->name = $request->input('name');
        $unit->description = $request->input('description');
        $unit->hou =  $request->input('hou');

        $unit->updatingfor = $id;
        $unit->save();

        //workflow
         if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Unit')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }
        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'unit' , $id );
        }

        return $unit;
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
        $Unitcheckactive = Unit::find($id);

        if ($Unitcheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $unit = Unit::find($id);

        //Check if Unit exists before deleting
        if (!isset($unit)){
            return 'No Unit Found';
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflow = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'unit')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        if ($CompanyWorkflow == '[]') {

            $this->deletesection($id);

            $unit::destroy($id);

            return 'Unit Removed Successfully';
        }

        $unit->isdeleted = '1';
        $unit->save();

         //workflow
         if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Unit')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'unit' , $id );
        }

        return 'Task Assigned';
    }

    public function assign_HOU_to_unit(Request $request){

        $unitid = $request->input('unitid');
        $hou = $request->input('hou');

        $Unit = Unit::find($unitid);
        $Unit->hou = $hou;
        $Unit->save();

        $user = User::find($hou);
        $user->unitid = $unitid;
        $user->save();

        return 'HOU is Appointed';

    }


}
