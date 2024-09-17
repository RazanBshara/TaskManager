<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\User;
use App\Models\UserTicket;
use App\Models\UserTask;
use App\Models\UserWorkspace;
use App\Models\UserRoleGroup;
use App\Models\UserRoleGroupCompany;


class UserController extends Controller
{
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
        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            'users.email',
            'users.phonenumber',
            'users.birthday',
            DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = users.companyid) as Company"),
            DB::raw("(SELECT departments.name FROM departments
                            WHERE departments.id = users.departmentid) as Department"),
            DB::raw("(SELECT units.name FROM units
                            WHERE units.id = users.unitid) as Unit"),
            DB::raw("(SELECT sections.name FROM sections
                            WHERE sections.id = users.sectionid) as Section"),
            'users.created_at'
        )
        ->orderBy('users.created_at','desc')
        ->paginate(10);

        return $user;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = DB::table('companies')
        ->select(
            'companies.id',
            'companies.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $departments = DB::table('departments')
        ->select(
            'departments.id',
            'departments.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $units = DB::table('units')
        ->select(
            'units.id',
            'units.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $sections = DB::table('sections')
        ->select(
            'sections.id',
            'sections.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['company'=>$company , 'departments'=>$departments, 'units'=>$units , 'sections'=>$sections]);
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
            //'birthday' => 'required',
           // 'phonenumber' => 'required'            
        ]);

        // Create User
        $user = new User;
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->phonenumber = $request->input('phonenumber');
        $user->birthday = $request->input('birthday');
        $user->companyid = $request->input('companyid');
        $user->departmentid = $request->input('departmentid');
        $user->unitid = $request->input('unitid');
        $user->sectionid = $request->input('sectionid');

        $user->save();

        return redirect('/user')->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            'users.email',
            'users.phonenumber',
            'users.birthday',
            DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = users.companyid) as Company"),
            DB::raw("(SELECT departments.name FROM departments
                            WHERE departments.id = users.departmentid) as Department"),
            DB::raw("(SELECT units.name FROM units
                            WHERE units.id = users.unitid) as Unit"),
            DB::raw("(SELECT sections.name FROM sections
                            WHERE sections.id = users.sectionid) as Section"),
            'users.created_at'
        )
        ->where('id' , '=' , $id)
        ->get();

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS FullName'),
            'users.email',
            'users.phonenumber',
            'users.birthday',
            DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = users.companyid) as Company"),
            DB::raw("(SELECT departments.name FROM departments
                            WHERE departments.id = users.departmentid) as Department"),
            DB::raw("(SELECT units.name FROM units
                            WHERE units.id = users.unitid) as Unit"),
            DB::raw("(SELECT sections.name FROM sections
                            WHERE sections.id = users.sectionid) as Section"),
            'users.created_at'
        )
        ->where('id' , '=' , $id)
        ->get();
        
        //Check if User exists before deleting
        if (!isset($user)){
            return 'No User Found';
        }

        $company = DB::table('companies')
        ->select(
            'companies.id',
            'companies.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $departments = DB::table('departments')
        ->select(
            'departments.id',
            'departments.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $units = DB::table('units')
        ->select(
            'units.id',
            'units.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $sections = DB::table('sections')
        ->select(
            'sections.id',
            'sections.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['company'=>$company , 'departments'=>$departments, 'units'=>$units , 'sections'=>$sections , 'user'=>$user]);
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
            //'birthday' => 'required',
            //'phonenumber' => 'required'            
        ]);

        $user = User::find($id);

        // Update user
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->phonenumber = $request->input('phonenumber');
        $user->birthday = $request->input('birthday');
        $user->companyid = $request->input('companyid');
        $user->departmentid = $request->input('departmentid');
        $user->unitid = $request->input('unitid');
        $user->sectionid = $request->input('sectionid');
        $user->save();

        return redirect('/user')->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete all UserRoleGroup
        $UserRoleGroup = UserRoleGroup::where('userid' , '=' , $id)->delete();
        //delete all UserRoleGroupCompany
        $UserRoleGroupCompany = UserRoleGroupCompany::where('userid' , '=' , $id)->delete();    
        //delete all UserTask
        $UserTask = UserTask::where('userid' , '=' , $id)->delete();   
        //delete all UserTicket
        $UserTicket = UserTicket::where('userid' , '=' , $id)->delete(); 
        //delete all UserWorkspace
        $UserWorkspace = UserWorkspace::where('userid' , '=' , $id)->delete();       

        $user = User::find($id);
        
        //Check if User exists before deleting
        if (!isset($user)){ 
            return 'No User Found';
        }
        
        $user->delete();

        return 'User Removed';
    }
}
