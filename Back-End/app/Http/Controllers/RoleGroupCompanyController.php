<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\RoleGroupCompany;
use App\Models\RoleGroupCompanyPermission;
use App\Models\Permission;

class RoleGroupCompanyController extends Controller
{
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
        $rolegroupcompany = RoleGroupCompany::where('adjictive' , '!=' , 'Administrator')->orderBy('created_at')->paginate(10);
        
        return $rolegroupcompany;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permission = Permission::where('forcompany' , '=' , 'yes')->get();
        
        return $permission;
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
            'adjictive' => 'required',
        ]);

        // Create RoleGroupCompany
        $rolegroupcompany = new RoleGroupCompany;
        $rolegroupcompany->adjictive = $request->input('adjictive');
        $rolegroupcompany->save();
        
        if( $request->rolegroupcompanypermissionarray != null)
        {
            for ($i=0; $i < count($request->rolegroupcompanypermissionarray); $i++) {   
                $rolegroupcompanypermission = new RoleGroupCompanyPermission;
                $rolegroupcompanypermission->rolegroupcompanyid = $rolegroupcompany->id;
                $rolegroupcompanypermission->permissionid = $request->rolegroupcompanypermissionarray[$i];
                $rolegroupcompanypermission->save();
            }
        }

        return $rolegroupcompany;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rolegroupcompany = RoleGroupCompany::find($id);

        $rolegroupcompanypermission = RoleGroupCompanyPermission::where('rolegroupcompanyid' , '=' , $id)->get();

        if ($rolegroupcompanypermission != '[]') {
            foreach($rolegroupcompanypermission as $rolegroupcompanypermissions)
            {
                $permission = Permission::where('id' , '=' , $rolegroupcompanypermissions->permissionid)->first();
                if ($permission != null) {
                    $permissionname[] = $permission->name; 
                }
            }
        } 
        else
        {
            $permissionname[] = null;
        }

        return (['rolegroupcompany'=>$rolegroupcompany,'permissionname'=>$permissionname]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolegroupcompany = RoleGroupCompany::find($id);
        
        //Check if RoleGroupCompany exists before deleting
        if (!isset($rolegroupcompany)){
            return redirect('/rolegroupcompany')->with('error', 'No RoleGroupCompany Found');
        }

        $rolegroupcompanypermission = RoleGroupCompanyPermission::where('rolegroupcompanyid' , '=' , $id)->get();

        if ($rolegroupcompanypermission != '[]') {
            foreach($rolegroupcompanypermission as $rolegroupcompanypermissions)
            {
                $permission = Permission::where('id' , '=' , $rolegroupcompanypermissions->permissionid)->first();
                if ($permission != null) {
                    $permissionname[] = $permission->id; 
                }
            }
        }
        else
        {
            $permissionname[] = null;
        }
        $permission = Permission::where('forcompany' , '=' , 'yes')->get();

        return (['rolegroupcompany'=>$rolegroupcompany,'permission'=>$permission,'permissionname'=>$permissionname]);
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
            'adjictive' => 'required',
        ]);
        
        $rolegroupcompany = RoleGroupCompany::find($id);
        $rolegroupcompany->adjictive = $request->input('adjictive');
        $rolegroupcompany->save();
        
        $rolegroupcompanypermissiondisabled = RoleGroupCompanyPermission::where('rolegroupcompanyid' , '=' , $id)->get(); 
        

        foreach ($rolegroupcompanypermissiondisabled as $rolegroupcompanypermissiondisableds) {                   
            $array[] = $request->rolegroupcompanypermissionarray;
            $permissionid = $rolegroupcompanypermissiondisableds->permissionid;

            
            if(!in_array($permissionid , $array))
            {  
                RoleGroupCompanyPermission::where('rolegroupcompanyid' , '=' , $id)->where('permissionid' , '=' , $permissionid)->delete();               
            }
        }              

        if( $request->rolegroupcompanypermissionarray != null)
        {
            for ($i=0; $i < count($request->rolegroupcompanypermissionarray); $i++) {   
               
                $rolegroupcompanypermission = RoleGroupCompanyPermission::where('rolegroupcompanyid' , '=' , $id)->where('permissionid' , '=' , $request->rolegroupcompanypermissionarray[$i])->first();   
                
                if ($rolegroupcompanypermission != '[]'){
                    $rolegroupcompanypermission = new RoleGroupCompanyPermission;
                    $rolegroupcompanypermission->rolegroupcompanyid = $id;
                    $rolegroupcompanypermission->permissionid = $request->rolegroupcompanypermissionarray[$i];
                    $rolegroupcompanypermission->save(); 
                }                
            }
        }
            
        return $rolegroupcompany;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rolegroupcompany = RoleGroupCompany::find($id);
        
        //Check if post exists before deleting
        if (!isset($rolegroupcompany)){
            return redirect('/rolegroupcompany')->with('error', 'No RoleGroupCompany Found');
        }
        
        $rolegroupcompany->delete();

        $rolegroupcompanypermission = RoleGroupCompanyPermission::where('rolegroupcompanyid' , '=' , $id)->delete();


        return 'RoleGroupCompany Removed';
    }
}
