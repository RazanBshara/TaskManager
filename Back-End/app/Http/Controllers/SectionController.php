<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use App\Traits\TaskWorkflow;
use DB;
use Session;

use App\Models\Section;
use App\Models\User;
use App\Models\ProjectDepartmentUnitSectionUser;
use App\Models\WorkflowUpperLevel;
use App\Models\Unit;
use App\Models\CompanyWorkflow;



class SectionController extends Controller
{
    use destroyTrait;
    use TaskWorkflow;

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

        $Section = DB::table('sections')
            ->select(
                'sections.id',
                'sections.name',
                'sections.description',
                DB::raw("(SELECT units.name FROM units
                                WHERE sections.unitid = units.id) as Unit"),
                DB::raw("(SELECT  CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE sections.hos = users.id) as HOS")
            )//->where('unitid' , '=' , $user->unitid)
            ->where('isactive' , '=' , 'active')
            ->where('sections.isdeleted' , '=' , Null)
            ->orderBy('created_at','desc')
            ->paginate(10);

        return $Section;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(auth()->user()->id);

        $hos =  DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            DB::raw(' role_group_companies.adjictive AS Role'),

        )
        ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
        ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

        ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 7)
        ->where('users.companyid', '=', $user->companyid)

       /* ->whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('user_role_group_companies')
                  ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')
                  ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 7);
        })*/

        ->orderBy('users.created_at','asc')
        ->paginate(5);

        $unit = Unit::/* where('departmentid', '=', $user->departmentid)->*/get();

        return (['unit'=>$unit, 'hos'=>$hos]);
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
            'unitid' => 'required'
        ]);

        $user = User::find(auth()->user()->id);

        $CompanyWorkflowCheck = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'section')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        // Create Section
        $section = new Section;
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->unitid = $request->input('unitid');
        $section->hos = $request->input('hos');

        if ($CompanyWorkflowCheck == '[]') {

            $section->isactive = 'active';
        }

        $section->save();

        //workflow
        if ($CompanyWorkflowCheck == '[]') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Section')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }


        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'section' , $section->id);
        }

        return $section;
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
        $Sectioncheckactive = Section::find($id);

        if ($Sectioncheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        return Section::find($id);
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
            'unitid' => 'required'
        ]);

        //check if active
        $Sectioncheckactive = Section::find($id);

        if ($Sectioncheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $user = User::find(auth()->user()->id);

        $CompanyWorkflow = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'section')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        $orginalsection = Section::find($id);

        if ($CompanyWorkflow == '[]') {

            $orginalsection->name = $request->input('name');
            $orginalsection->description = $request->input('description');
            $orginalsection->hos = $request->input('hos');

            $orginalsection->save();

            return $orginalsection;
        }


        // Update section
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->hos = $request->input('hos');
        $section->unitid =    $orginalsection->unitid;
        $section->hos =       $orginalsection->hos;

        $section->save();

        //workflow
        if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Section')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }
        $assignedid = $request->assignedid;//array of assignedid IDs


        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'section' , $id );
        }

        return $section;
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
        $Sectioncheckactive = Section::find($id);

        if ($Sectioncheckactive->isactive != 'active') {

            return 'Not Exists';
        }
        ///////

        $section = Section::find($id);

        //Check if Drink exists before deleting
        if (!isset($section)){
            return 'No Section Found';
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflow = CompanyWorkflow::where('companyid' , '=' , $user->companyid)
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'section')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();

        if ($CompanyWorkflow == '[]') {

            ProjectDepartmentUnitSectionUser::where('sectionid' , '=' , $sections->id)->delete();

            $section::destroy($id);

            return 'Section Removed Successfully';
        }

        $section->isdeleted = '1';
        $section->save();

        //workflow
        if ($CompanyWorkflowCheck == '') {

            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Section')->first();

            if ($WorkflowUpperLevel != '') {

                $upperlevel = $WorkflowUpperLevel->upperlevel;

            }
            else {
                $upperlevel = 0;
            }
        }

        if ($CompanyWorkflowCheck != '') {

            $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'section' , $id );
        }

        return 'Task Assigned';
    }
}
