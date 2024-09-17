<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\RoleGroupPermission;
use App\Models\RoleGroup;

class PermissionController extends Controller
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
        $permission = Permission::orderBy('created_at' , 'desc')->get();

        $rolegrouppermission = RoleGroupPermission::all();

        $rolegroup = RoleGroup::all();

        return (['rolegroup'=>$rolegroup,'rolegrouppermission'=>$rolegrouppermission,'permission'=>$permission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolegroup = RoleGroup::where('adjictive' , '!=' , 'Administrator')->get();
        
        return $rolegroup;
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
        ]);

        // Create Permission
        $permission = new Permission;
        $permission->name = $request->input('name');
        $permission->forcompany = $request->input('forcompany');   
        $permission->save();
        
        //dd( $permission->id); 

        $rolegrouppermission = new RoleGroupPermission;  
        $rolegrouppermission->rolegroupid = '1';
        $rolegrouppermission->permissionid = $permission->id;
        $rolegrouppermission->save();

        if( $request->rolegrouprolearray != null )
        {                       
            for ($i=0; $i < count($request->rolegrouprolearray); $i++) {  
                $rolegrouppermission = new RoleGroupPermission;  
                $rolegrouppermission->rolegroupid = $request->rolegrouprolearray[$i];
                $rolegrouppermission->permissionid = $permission->id;
                $rolegrouppermission->save();
            }
            
        }


        return $permission;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        $rolegrouppermission = RoleGroupPermission::where('permissionid' , '=' , $id)->get();

        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $rolegroup = RoleGroup::where('id' , '=' , $rolegrouppermissions->rolegroupid)->first();
                if ($rolegroup != null) {
                    $rolegroup_name[] = $rolegroup->adjictive; 
                }
            }
        }
        else
        {
            $rolegroup_name[] = null;
        }

        return (['rolegroup_name'=>$rolegroup_name,'permission'=>$permission]);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        
        //Check if Permission exists before deleting
        if (!isset($permission)){
            return redirect('/permission')->with('error', 'No Permission Found');
        }

        $rolegrouppermission = RoleGroupPermission::where('permissionid' , '=' , $id)->get();

        
        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $rolegroup = RoleGroup::where('id' , '=' , $rolegrouppermissions->rolegroupid)->first();
                if ($rolegroup != null) {
                    $rolegroup_name[] = $rolegroup->adjictive; 
                }
            }
            $array_size = 'notempty';
        }
        else
        {
            $rolegroup_name[] = null;

            $array_size = 'empty';
        }

        $rolegroup = RoleGroup::where('adjictive' , '!=' , 'Administrator')->get();

        return (['array_size'=>$array_size,'rolegroup_name'=>$rolegroup_name,'rolegroup'=>$rolegroup,'permission'=>$permission]);   
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

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->forcompany = $request->input('forcompany');        
        $permission->save();

        $rolegrouppermissiondisabled = RoleGroupPermission::where('permissionid' , '=' , $id)->get(); 

        
        if ($rolegrouppermissiondisabled != '[]') {
          
            foreach ($rolegrouppermissiondisabled as $rolegrouppermissiondisableds) {
                $array[] = $request->rolegrouprolearray;           
                $rolegroup_id = $rolegrouppermissiondisableds->rolegroupid;

                if(!in_array($rolegroup_id , $array))
                {  
                    RoleGroupPermission::where('permissionid' , '=' , $id)->where('rolegroupid' , '=' , $rolegrouppermissiondisableds->rolegroupid)->delete();
                }
            }
        }

        $rolegrouppermission = new RoleGroupPermission;  
        $rolegrouppermission->rolegroupid = '1';
        $rolegrouppermission->permissionid = $permission->id;
        $rolegrouppermission->save();

        if( $request->rolegrouprolearray != null)
        {
            
            for ($i=0; $i < count($request->rolegrouprolearray); $i++) { 

                $rolegrouppermission = RoleGroupPermission::where('permissionid' , '=' , $id)->where('rolegroupid' , '=' , $request->rolegrouprolearray[$i])->first();   
                
                if ($rolegrouppermission != '[]'){
                    $rolegrouppermission = new RoleGroupPermission;
                    $rolegrouppermission->permissionid = $id;
                    $rolegrouppermission->rolegroupid = $request->rolegrouprolearray[$i];
                    $rolegrouppermission->save(); 
                }        
            }

        }


        return $permission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        
        $rolegrouppermission = RoleGroupPermission::where('permissionid' , '=' , $id)->delete();
        
        //Check if post exists before deleting
        if (!isset($permission)){
            return redirect('/permission')->with('error', 'No Permission Found');
        }
        
        $permission->delete();

        return 'Permission Removed';
    }
}
