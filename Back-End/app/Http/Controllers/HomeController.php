<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RoleGroup;
use App\Models\RoleGroupCompanyPermission;

use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {    

       $data = array(
        "title" => "hello",
        "description" => "test test test"
      );

      $data1 = array(
         "unit 1",
         "unit 2"
      );

      dd($data1);

      /*  $rolegroup = RoleGroup::where('adjictive' , 'LIKE' , 'employee')->first();

        dd($rolegroup->adjictive);*/
/*
        $permission = Permission::where('forcompany' , '=' , 'yes')->get();

        foreach ($permission as $permissions) {
            
            $RoleGroupCompanyPermission = new RoleGroupCompanyPermission;
            $RoleGroupCompanyPermission->rolegroupcompanyid = 1;
            $RoleGroupCompanyPermission->permissionid = $permissions->id;

            $RoleGroupCompanyPermission->save();

        }
*/


        return view('home');
    }
}
