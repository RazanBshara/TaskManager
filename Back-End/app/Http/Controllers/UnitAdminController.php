<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitAdminController extends Controller
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
        $units = DB::table('units')
            ->select(
                'units.id',
                'units.name',
                'units.description',
                DB::raw("(SELECT workspaces.name FROM workspaces
                                WHERE workspaces.id = units.workspaceid) as Workspace"),
                DB::raw("(SELECT departments.name FROM departments
                                WHERE departments.id = units.departmentid) as Department"),                                
                DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                                WHERE users.id = units.hou) as HOU"),                
                'units.isactive',
                'units.created_at'
            )
            ->orderBy('created_at','desc')
            ->paginate(10);

        return $units;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hou = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS HOU')
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

        $workspaces = DB::table('workspaces')
        ->select(
            'workspaces.id',
            'workspaces.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['hou'=>$hou , 'departments'=>$departments , 'workspaces'=>$workspaces]);
        
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
            'departmentid' => 'required',
            'workspaceid' => 'required'                 
        ]);

        // Create Unit
        $unit = new Unit;
        $unit->name = $request->input('name');
        $unit->hou = $request->input('hou');
        $unit->description = $request->input('description');    
        $unit->userid = $request->input('departmentid');   
        $unit->ceoid = $request->input('workspaceid');      

        $unit->save();

        return $unit;       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $units = DB::table('units')
        ->select(
            'units.id',
            'units.name',
            'units.description',
            DB::raw("(SELECT workspaces.name FROM workspaces
                            WHERE workspaces.id = units.workspaceid) as Workspace"),
            DB::raw("(SELECT departments.name FROM departments
                            WHERE departments.id = units.departmentid) as Department"),                                
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = units.hou) as HOU"),                
            'units.isactive',
            'units.created_at'
        )
        ->where('id', '=',$id)
        ->get();

        return $units;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $units = DB::table('units')
        ->select(
            'units.id',
            'units.name',
            'units.description',
            DB::raw("(SELECT workspaces.name FROM workspaces
                            WHERE workspaces.id = units.workspaceid) as Workspace"),
            DB::raw("(SELECT departments.name FROM departments
                            WHERE departments.id = units.departmentid) as Department"),                                
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = units.hou) as HOU"),                
            'units.isactive',
            'units.created_at'
        )
        ->where('id', '=',$id)
        ->get();

        $hou = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS HOU')
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

        $workspaces = DB::table('workspaces')
        ->select(
            'workspaces.id',
            'workspaces.name'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return (['hou'=>$hou , 'departments'=>$departments , 'workspaces'=>$workspaces, 'units'=>$units]);

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
        //
        $this->validate($request, [
            'name' => 'required',
            'departmentid' => 'required',
            'workspaceid' => 'required'                 
        ]);

        // Create Unit
        $unit = new Unit;
        $unit->name = $request->input('name');
        $unit->hou = $request->input('hou');
        $unit->description = $request->input('description');    
        $unit->userid = $request->input('departmentid');   
        $unit->ceoid = $request->input('workspaceid');      

        $unit->save();

        return $unit;       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);

        //Check if Drink exists before deleting
        if (!isset($unit)){
            return 'No Unit Found';
        }
        
        $this->deletesection($id);

        $unit::destroy($id);

        return 'Unit Removed Successfully';
    }
}
