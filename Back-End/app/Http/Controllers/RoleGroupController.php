<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleGroup;
use App\Models\RoleGroupPermission;
use App\Models\Permission;

class RoleGroupController extends Controller
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
        $rolegroup = RoleGroup::where('adjictive' , '!=' , 'Administrator')->orderBy('created_at')->paginate(10);
       
        return $rolegroup;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permission = Permission::all();
        
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

        // Create RoleGroup
        $rolegroup = new RoleGroup;
        $rolegroup->adjictive = $request->input('adjictive');
        $rolegroup->save();
        
        if( $request->rolegrouppermissionarray != null)
        {
            for ($i=0; $i < count($request->rolegrouppermissionarray); $i++) {   
                $rolegrouppermission = new RoleGroupPermission;
                $rolegrouppermission->rolegroupid = $rolegroup->id;
                $rolegrouppermission->permissionid = $request->rolegrouppermissionarray[$i];
                $rolegrouppermission->save();
            }
        }

        return $rolegroup;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rolegroup = RoleGroup::find($id);

        $rolegrouppermission = RoleGroupPermission::where('rolegroupid' , '=' , $id)->get();

        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $permission = Permission::where('id' , '=' , $rolegrouppermissions->permissionid)->first();
                if ($permission != null) {
                    $permission_name[] = $permission->name; 
                }
            }
        } 
        else
        {
            $permission_name[] = null;
        }

        return (['rolegroup'=>$rolegroup,'permission_name'=>$permission_name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolegroup = RoleGroup::find($id);
        
        //Check if RoleGroup exists before deleting
        if (!isset($rolegroup)){
            return redirect('/rolegroup')->with('error', 'No RoleGroup Found');
        }

        $rolegrouppermission = RoleGroupPermission::where('rolegroupid' , '=' , $id)->get();

        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $permission = Permission::where('id' , '=' , $rolegrouppermissions->permissionid)->first();
                if ($permission != null) {
                    $permission_name[] = $permission->id; 
                }
            }
        }
        else
        {
            $permission_name[] = null;
        }
        $permission = Permission::all();

        return (['rolegroup'=>$rolegroup,'permission_name'=>$permission_name,'permission'=>$permission]);

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
        
        $rolegroup = RoleGroup::find($id);
        $rolegroup->adjictive = $request->input('adjictive');
        $rolegroup->save();
       
        $rolegrouppermissiondisabled = RoleGroupPermission::where('rolegroupid' , '=' , $id)->get(); 

        foreach ($rolegrouppermissiondisabled as $rolegrouppermissiondisableds) {
            $array[] = $request->rolegrouppermissionarray;
            $permissionid = $rolegrouppermissiondisableds->permissionid;
            
            dd($request->rolegrouppermissionarray);
            dd($permissionid);

            if(!in_array($permissionid , $array))
            {  
                RoleGroupPermission::where('rolegroupid' , '=' , $id)->where('permissionid' , '=' , $rolegrouppermissiondisableds->permissionid)->delete();
            }
        }

        if( $request->rolegrouppermissionarray != null)
        {
            for ($i=0; $i < count($request->rolegrouppermissionarray); $i++) {   
                
                $rolegrouppermission = RoleGroupPermission::where('rolegroupid' , '=' , $id)->where('permissionid' , '=' , $request->rolegrouppermission[$i])->first();   

                if ($rolegrouppermission != '[]'){
                    $rolegrouppermission = new RoleGroupPermission;
                    $rolegrouppermission->rolegroupid = $id;
                    $rolegrouppermission->permissionid = $request->rolegrouppermissionarray[$i];
                    $rolegrouppermission->save(); 
                }                
            }
        }
            
        return $rolegroup;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rolegroup = RoleGroup::find($id);
        
        //Check if post exists before deleting
        if (!isset($rolegroup)){
            return redirect('/rolegroup')->with('error', 'No RoleGroup Found');
        }
        
        $rolegroup->delete();

        $rolegrouppermission = RoleGroupPermission::where('rolegroupid' , '=' , $id)->delete();


        return 'RoleGroup Removed';
    }
}
