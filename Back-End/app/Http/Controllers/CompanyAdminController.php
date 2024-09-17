<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\Company;
use App\Models\User;


class CompanyAdminController extends Controller
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
        $companies = DB::table('companies')
        ->select(
            'companies.id',
            'companies.name',
            'companies.description',
            'companies.type',
            'companies.members',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = companies.userid) as CreatedBy"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = companies.seoid) as CEO"),
             DB::raw("(SELECT company_types.name FROM company_types
                            WHERE company_types.id = companies.typeid) as CompanyType"),
            'workspaces.created_at'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return $companies;
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $ceo = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['users'=>$users , 'ceo'=>$ceo]);
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
            'type' => 'required',
            'userid' => 'required'                 
        ]);

        // Create Company
        $company = new Company;
        $company->name = $request->input('name');
        $company->type = $request->input('type');
        $company->description = $request->input('description');    
        $company->userid = $request->input('userid');   //users who not owners company
        $company->ceoid = $request->input('ceoid');      

        $company->save();

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
        $companies = DB::table('companies')
        ->select(
            'companies.id',
            'companies.name',
            'companies.description',
            'companies.type',
            'companies.members',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = companies.userid) as CreatedBy"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = companies.seoid) as CEO"),
             DB::raw("(SELECT company_types.name FROM company_types
                            WHERE company_types.id = companies.typeid) as CompanyType"),
            'workspaces.created_at'
        )
        ->where('id', '=', $id)
        ->get();


        return $companies;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companies = DB::table('companies')
        ->select(
            'companies.id',
            'companies.name',
            'companies.description',
            'companies.type',
            'companies.members',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = companies.userid) as CreatedBy"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = companies.seoid) as CEO"),
             DB::raw("(SELECT company_types.name FROM company_types
                            WHERE company_types.id = companies.typeid) as CompanyType"),
            'workspaces.created_at'
        )
        ->where('id', '=', $id)
        ->get();



        $users = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $ceo = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['companies'=>$companies , 'users'=>$users , 'ceo'=>$ceo]);
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
            'type' => 'required',
            'userid' => 'required'            
        ]);


        $company = Company::find($id);

        // Update Company
        $company->name = $request->input('name');
        $company->type = $request->input('type');
        $company->description = $request->input('description');
        $company->userid = $request->input('userid');
        $company->ceoid = $request->input('ceoid'); 

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

        //Check if CompanyAdmin exists before deleting
        if (!isset($company)){
            return 'No CompanyAdmin Found';
        }

        // Delete All Departments under the company by calling Department destroy function

        $this->deletedepartment($id);    

        $this->deleteworkspace($id);

        return Company::destroy($id);
    }
}
