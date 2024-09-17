<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\Workspace;
use App\Models\Company;
use App\Models\User;


class WorkspaceAdminController extends Controller
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
       
        $workspace = DB::table('workspaces')
            ->select(
                'workspaces.id',
                'workspaces.name',
                'workspaces.description',
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.managerid) as ManagerName"),
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.createdby) as CreatedBy"),
                 DB::raw("(SELECT companies.name FROM companies
                                WHERE companies.id = workspaces.companyid) as Company"),
                'workspaces.isactive',
                'workspaces.created_at'
            )
            ->orderBy('created_at','desc')
            ->paginate(10);

        return $workspace;
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

        $managers = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['company'=>$company , 'user'=>$user , 'managers'=>$managers]);
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
            'companyid' => 'required'
        ]);

        // Create Workspace
        $workspace = new Workspace;
        $workspace->name = $request->input('name');
        $workspace->description = $request->input('description');
        $workspace->userid = $request->input('userid');
        $workspace->companyid = $request->input('companyid');
        $workspace->managerid = $request->input('managerid');

        $workspace->save();

        return  $workspace;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workspace = DB::table('workspaces')
            ->select(
                'workspaces.id',
                'workspaces.name',
                'workspaces.description',
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.managerid) as ManagerName"),
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = workspaces.createdby) as CreatedBy"),
                 DB::raw("(SELECT companies.name FROM companies
                                WHERE companies.id = workspaces.companyid) as Company"),
                'workspaces.isactive',
                'workspaces.created_at'
            )
            ->where('id', '=', $id)
            ->get();

            return $workspace;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = DB::table('companies')
        ->select(
            'companies.id',
            'companies.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $managers = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $workspace = DB::table('workspaces')
        ->select(
            'workspaces.id',
            'workspaces.name',
            'workspaces.description',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = workspaces.managerid) as ManagerName"),
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = workspaces.createdby) as CreatedBy"),
             DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = workspaces.companyid) as Company"),
            'workspaces.isactive',
            'workspaces.created_at'
        )
        ->where('id', '=', $id)
        ->get();


        return (['company'=>$company , 'user'=>$user , 'managers'=>$managers, 'workspace'=>$workspace]);
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
            'companyid' => 'required'
        ]);

        $workspace = Workspace::find($id);

        // Update workspace
        $workspace->name = $request->input('name');
        $workspace->description = $request->input('description');
        $workspace->userid = $request->input('userid');
        $workspace->companyid = $request->input('companyid');
        $workspace->managerid = $request->input('managerid');

        $workspace->save();

        return $workspace;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workspace = Workspace::find($id);

        //Check if Workspace exists before deleting
        if (!isset($workspace)){
            return 'No Workspace Found';
        }

        $this->deleteproject($id);

        $workspace::destroy($id);

        return 'Workspace Removed Successfully';
    }
}
