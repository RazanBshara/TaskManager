<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\RoleGroup;
use App\Models\UserRoleGroup;
use App\Models\Permission;
use App\Models\RoleGroupPermission;

use App\Models\UserRoleGroupCompany;
use App\Models\RoleGroupCompanyPermission;

use DB;

class CheckPermission 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        //return response($url_assign);

        //1
        $userid =  auth()->user()->id;
        
        $rolegroupid = UserRoleGroup::where('userid' , '=' , $userid)->min('rolegroupid');

        $rolegroup = RoleGroup::where('id' , '=' , $rolegroupid)->first();

        //dd($rolegroup->adjictive);

        //2
        $url = $request->path();

        //Assign URL

        $url_assign = str_replace('api/', '', $url); 
        $route_assign =  substr ($url_assign, 0 , +6);

        if ($route_assign == 'assign') {

            $permissionname  = str_replace('_', ' ', $url_assign); 
            $permission = Permission::where('name','LIKE','%' .$permissionname. '%')->first();
        }
        else {

            //Another Routes

            $url = preg_replace('/[0-9]+/', '', $url);
            $url = str_replace('admin', '', $url);
        
            $route = $request->route()->getActionName();

            $route_destroy = substr ($route, -7);
            $route_show = substr ($route, -4);
            $route_index = substr ($route, -5);
            $route_update = substr ($route, -6);
            $route_store = substr ($route, -5);   

            if ($route_destroy == 'destroy') {
                $permissionaction = 'delete';
                $permissionname = str_replace( $route_destroy, '', $url);
                $permissionname = str_replace('/', '', $permissionname);

            }else if ($route_show == 'show' and substr ($url, -5) != 'fetch') {
            
                $permissionaction = 'show';
                $permissionname = str_replace( $route_show, '', $url);            
                $permissionname = str_replace('/', '', $permissionname);   

            }else if ($route_index == 'index') {
            
                $permissionaction = 'index';
                $permissionname = str_replace( $route_index, '', $url);
                $permissionname = str_replace('/', '', $permissionname);
            }
            elseif ($route_update == 'update' || substr ($url, -4) == 'edit') {
                
                if ($route_update != 'update') {
                    $route_update = 'edit';
                }
                $permissionaction = 'edit';        
                $permissionname = str_replace( $route_update, '', $url);
                $permissionname = str_replace('/', '', $permissionname);
            }
            elseif ($route_store == 'store' || substr ($url, -6) == 'create' ) {
            
                if ($route_store != 'store') {
                    $route_store = 'create';
                }
                $permissionaction = 'add';
                $permissionname = str_replace( $route_store, '', $url);
                $permissionname = str_replace('/', '', $permissionname);
            }

            $permissionname = str_replace('api', '', $permissionname); 
            $permission = Permission::where('name','LIKE','%'.$permissionaction. ' ' .$permissionname. '%')->first();
        }
        
        //if the permission open for company let the role company deside 
        if ($permission->forcompany = 'yes')
        {   
            $rolegroupcompanyid = UserRoleGroupCompany::where('userid' , '=' , $userid)->min('rolegroupcompanyid');

            $RoleGroupCompanyPermission = RoleGroupCompanyPermission::
            where('rolegroupcompanyid' , '=' , $rolegroupcompanyid)
            ->where('permissionid' , '=' , $permission->id)->get();   
            
            if ($RoleGroupCompanyPermission != '[]')
            {                  
                return $next($request);
            }else {
                return response('(Role Group Company) Not Allowed');
            }

        } 

        if ($permission == '[]' || $permission == null)
        {
            return response('Not Allowed ( Permission Not Exists)');
        }

        //return response($permission);

        $rolegrouppermission = RoleGroupPermission::where('rolegroupid' , '=' , $rolegroupid)->where('permissionid' , '=' , $permission->id)->get();    
        if ($rolegrouppermission != '[]')
        {            
            return  $next($request);
        } 
        
        return response('Not Allowed');
        
    }
}


//echo 'Azad';
        //dd($request->path());
        //dd($request->route()->parameter);
        //dd($request->route()->getActionName());