<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\destroyTrait;
use DB;
use Session;

use App\Models\Section;
use App\Models\User;


class SectionAdminController extends Controller
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
        $sections = DB::table('sections')
        ->select(
            'sections.id',
            'sections.name',
            'sections.description',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = sections.hos) as HOS"),
            DB::raw("(SELECT units.name FROM units
                            WHERE units.id = sections.unitid) as Unit"),
             DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = workspaces.companyid) as Company"),
            'sections.isactive',
            'sections.created_at'
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        return $sections;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $hos = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
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
        

        return (['units'=>$units , 'user'=>$user , 'hos'=>$hos]);
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
            'createdby' => 'required'
        ]);

        // Create Section 
        $section = new Section;
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->createdby = $request->userid;
        $section->hos = $request->hos;
        $section->unitid = $request->input('unitid');

        $section->save();

        return redirect('/sectionadmin')->with('success', 'SectionAdmin Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sections = DB::table('sections')
        ->select(
            'sections.id',
            'sections.name',
            'sections.description',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = sections.hos) as HOS"),
            DB::raw("(SELECT units.name FROM units
                            WHERE units.id = sections.unitid) as Unit"),
             DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = workspaces.companyid) as Company"),
            'sections.isactive',
            'sections.created_at'
        )
        ->where('id','=',$id)
        ->get();
        
        return $sections;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = DB::table('sections')
        ->select(
            'sections.id',
            'sections.name',
            'sections.description',
            DB::raw("(SELECT CONCAT(users.firstname, ' ', users.lastname) FROM users
                            WHERE users.id = sections.hos) as HOS"),
            DB::raw("(SELECT units.name FROM units
                            WHERE units.id = sections.unitid) as Unit"),
             DB::raw("(SELECT companies.name FROM companies
                            WHERE companies.id = workspaces.companyid) as Company"),
            'sections.isactive',
            'sections.created_at'
        )
        ->where('id','=',$id)
        ->get();
                
        //Check if Section exists before deleting
        if (!isset($section)){
            return 'No SectionAdmin Found';
        }

        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $hos = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
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
        

        return (['units'=>$units , 'user'=>$user , 'hos'=>$hos, 'section'=>$section]);
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
            'createdby' => 'required'
        ]);
    
        $section = Section::find($id);

        // Update section
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->createdby = $request->userid;
        $section->hos = $request->hos;
        $section->unitid = $request->input('unitid');   

        $section->save();

        return redirect('/sectionadmin')->with('success', 'SectionAdmin Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);

        //Check if Drink exists before deleting
        if (!isset($section)){
            return 'No Section Found';
        }

        ProjectDepartmentUnitSectionUser::where('sectionid' , '=' , $sections->id)->delete(); 

        $section::destroy($id);

        return 'Section Removed Successfully';
    }
}
