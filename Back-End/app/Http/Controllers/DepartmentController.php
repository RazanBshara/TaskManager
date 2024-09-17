<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TaskWorkflow;
use App\Traits\destroyTrait;

use App\Models\Department;
use App\Models\User;
use App\Models\CompanyWorkflow;
use App\Models\WorkflowUpperLevel;
use Session;
use DB;

class DepartmentController extends Controller
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
        $user = User::find(auth()->user()->id);

        $departments = DB::table('departments')
            ->select(
                'departments.id',
                'departments.name',
                'departments.description',
                DB::raw("(SELECT companies.name FROM companies
                WHERE companies.id = departments.companyid) as Company"),
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = departments.director) as Director"),
                'departments.isactive',
                'departments.created_at',
            )
            ->where('companyid' , '=' , $user->companyid)
            ->where('isactive' , '=' , 'active')
            ->where('departments.isdeleted' , '=' , Null)
            ->orderBy('created_at','desc')
            ->get();

            return $departments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(auth()->user()->id);

        $directors =  DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            DB::raw(' role_group_companies.adjictive AS Role'),

        )
        ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
        ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

        ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 5)
        ->where('users.companyid', '=', $user->companyid)

        ->whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                  ->from('user_role_group_companies')
                  ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')
                  ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 5);
        })

        ->orderBy('users.created_at','asc')
        ->paginate(5);

        return $directors;
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
            $query->where('workflowtype' , '=' , 'department')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();                  

        // Create Department
        $department = new Department;
        $department->name = $request->input('name');
        $department->description = $request->input('description');
        $department->director = $request->input('director');
        $department->companyid = $user->companyid;

        if ($CompanyWorkflowCheck == '[]') {
            
            $department->isactive = 'active';
        }

        $department->save();
        
        //workflow
        if ($CompanyWorkflowCheck == '[]') {
            
            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Department')->first();

            if ($WorkflowUpperLevel != '') {
           
                $upperlevel = $WorkflowUpperLevel->upperlevel;            
        
            }
            else {
                $upperlevel = 0;
            }
        }
       
        $assignedid = $request->assignedid;//array of assignedid IDs


        if ($CompanyWorkflowCheck != '') {
                    
            $this->createtaskworkflow('Create' , $assignedid , $upperlevel , 'department' , $department->id );
        }

        return $department;
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
        $Departmentcheckactive = Department::find($id);
        
        if ($Departmentcheckactive->isactive != 'active') {
            
            return 'Not Exists';
        }        
        ///////

        $departments = DB::table('departments')
        ->select(
            'departments.id',
            'departments.name',
            'departments.description',
            DB::raw("(SELECT companies.name FROM companies
            WHERE companies.id = departments.companyid) as Company"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = departments.director) as Director"),
            'departments.isactive',
            'departments.created_at',
        )
        ->where('isactive' , '=' , 'active')
        ->where('departments.isdeleted' , '=' , Null)
        ->where('id', '=' , $id)
        ->orderBy('created_at','desc')
        ->get();

        
        return  $departments;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(auth()->user()->id);

        $directors =  DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            DB::raw(' role_group_companies.adjictive AS Role'),

        )
        ->join('user_role_group_companies', 'user_role_group_companies.userid', '=', 'users.id')
        ->join('role_group_companies', 'role_group_companies.id', '=', 'user_role_group_companies.rolegroupcompanyid')

        ->where('user_role_group_companies.rolegroupcompanyid' , '=' , 5)

        ->orderBy('users.created_at','asc')
        ->paginate(5);

        $users = User::where('companyid' , '=',  $user->companyid)->paginate(5);

        $department = Department::find($id);

        return (['users'=>$users, 'directors'=>$directors, 'department'=>$department]);
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
        $Departmentcheckactive = Department::find($id);
        
        if ($Departmentcheckactive->isactive != 'active') {
            
            return 'Not Exists';
        }        
        ///////

        $user = User::find(auth()->user()->id);

        $CompanyWorkflow = CompanyWorkflow::where('companyid' , '=' , $user->companyid)    
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'department')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();                          


        $orginaldepartment = Department::find($id); 

        if ($CompanyWorkflow == '[]') {
            
            $orginaldepartment->name = $request->input('name');        
            $orginaldepartment->description = $request->input('description');
            $orginaldepartment->director = $request->input('director');
                        
            $orginaldepartment->save();

            return $orginaldepartment;
        }

        // Update Department
        $department = new Department;
        $department->name = $request->input('name');        
        $department->description = $request->input('description');
        $department->director = $request->input('director');
        
        $department->updatingfor = $id; 
        $department->save();
        
        //workflow
        if ($CompanyWorkflowCheck == '[]') {
            
            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Department')->first();

            if ($WorkflowUpperLevel != '') {
           
                $upperlevel = $WorkflowUpperLevel->upperlevel;            
        
            }
            else {
                $upperlevel = 0;
            }
        }
        $assignedid = $request->assignedid;//array of assignedid IDs

        if ($CompanyWorkflowCheck == '[]') {

            $this->createtaskworkflow('Update' , $assignedid , $upperlevel , 'department' , $id );
        }

        return $department;
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
        $Departmentcheckactive = Department::find($id);
        
        if ($Departmentcheckactive->isactive != 'active') {
            
            return 'Not Exists';
        }        
        ///////

        $department = Department::find($id);
        
        //Check if Drink exists before deleting
        if (!isset($department)){
            return 'No Department Found';
        }

        $user = User::find(auth()->user()->id);

        $CompanyWorkflow = CompanyWorkflow::where('companyid' , '=' , $user->companyid)    
        ->where( function ( $query )
        {
            $query->where('workflowtype' , '=' , 'department')
                ->orwhere('workflowtype' , '=' , 'all');
        })->get();                  
        
        if ($CompanyWorkflow == '[]') {
            
            $this->deleteunit($id);

            Department::destroy($id); 

            return 'Department Removed Successfully';
        }


        $department->isdeleted = '1';
        $department->save();
       
        //workflow
        if ($CompanyWorkflowCheck == '[]') {
            
            $upperlevel = 0;
        }else {

            $WorkflowUpperLevel = WorkflowUpperLevel::where('workflowtype' , '=' , 'Department')->first();

            if ($WorkflowUpperLevel != '') {
           
                $upperlevel = $WorkflowUpperLevel->upperlevel;            
        
            }
            else {
                $upperlevel = 0;
            }
        }

        if ($CompanyWorkflowCheck == '[]') {

            $this->createtaskworkflow('Delete' , 0 , $upperlevel , 'department' , $id );
        }
        
        return 'Task Assigned';
    }

    public function assign_director_to_department(Request $request){

        $departmentid = $request->input('departmentid');
        $director = $request->input('director');
        
        $Department = Department::find($departmentid);
        $Department->director = $director;
        $Department->save();

        $user = User::find($director);
        $user->departmentid = $departmentid;
        $user->save();

        return 'Director is Appointed';

    }
}
