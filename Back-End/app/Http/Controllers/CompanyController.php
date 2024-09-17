<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\Company;
use App\Models\User;
use App\Models\UserRoleCompany;
use App\Models\RoleGroupCompany;
use App\Models\UserRoleGroupCompany;
use App\Models\Department;
use App\Models\CompanyType;
use App\Models\CompanyWorkflow;


class CompanyController extends Controller
{
    use destroyTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
       // $this->middleware('CheckPermission')->except('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'members' => 'required',
            'typeid' => 'required'
        ]);

        $UserRoleGroupCompany = UserRoleGroupCompany::where('userid' , '=' , auth()->user()->id)->get();

        if ($UserRoleGroupCompany != '[]') {

            return 'Employee Not Allowed';
        }

        // Create Company
        $company = new Company;
        $company->name = $request->input('name');
        $company->members = $request->input('members');
        $company->typeid = $request->input('typeid');
        $company->description = $request->input('description');
        $company->userid = auth()->user()->id;

        $company->save();

        //give the user All RoleRoleGroupCompany

        $rolegroupcompany = RoleGroupCompany::all();

        foreach ($rolegroupcompany as $rolegroupcompanys) {

            $UserRoleGroupCompany = new UserRoleGroupCompany;
            $UserRoleGroupCompany->rolegroupcompanyid = $rolegroupcompanys->id;
            $UserRoleGroupCompany->userid = auth()->user()->id;

            $UserRoleGroupCompany->save();
        }

        //Edit the company for the user
        $user = User::find(auth()->user()->id);
        $user->companyid = $company->id;
        $user->save();

        $CompanyWorkflow = new CompanyWorkflow();
        $CompanyWorkflow->companyid = $company->id;
        $CompanyWorkflow->workflowtype = 'all';
        $CompanyWorkflow->save();

        //Session::put('companyid', $company->id);

        return $company;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        return $company;
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
            'type' => 'required'
        ]);


        $company = Company::find($id);

        // Update Company
        $company->name = $request->input('name');
        $company->type = $request->input('type');
        $company->members = $request->input('members');
        $company->typeid = $request->input('typeid');
        $company->description = $request->input('description');

        $company->save();

        return $company;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        //Check if Drink exists before deleting
        if (!isset($company)){
            return 'No Company Found';
        }

        // Delete All Departments under the company by calling Department destroy function

        $this->deletedepartment($id);

        $this->deleteworkspace($id);

        return Company::destroy($id);
    }

    public function assign_CEO_to_company(Request $request){

        $user = User::find(auth()->user()->id);
        $ceoid = $request->input('ceoid');

        $company = Company::find($user->companyid);// we can use request tro get the company id
        $company->ceoid = $ceoid;
        $company->save();

        return 'CEO is Appointed';

    }

    public function searchcompany(Request $request){

        $searchname = $request->searchname;

        $company = Company::where('name' , 'LIKE' , '%'.$searchname.'%')->get();

        if ($company != '[]') {

            return $company;
        }

        return 'No Results!!';

    }

    public function joincompany(Request $request){

        $companyid = $request->companyid;

        $company = Company::find($companyid);

        if ($company != '[]') {

            $user = User::find(auth()->user()->id);
            $user->companyid = $companyid;

            $user->save();

            return $company;
        }

        return 'The Company ot exists!!';

    }

    public function getcompanytype(){

        $CompanyType = CompanyType::all();

        return $CompanyType;
    }
}
