<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invitation;


class InvitationAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('IsAdmin');
        $this->middleware('CheckPermission');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Invitation::orderBy('created_at','desc')->paginate(10);
      //  $invitation = Invitation::orderBy('created_at','desc')->paginate(10);
       // return view('invitationadmin.index')->with('invitation', $invitation);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('invitationadmin.create');
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
            'email' => 'required',
            'userid' => 'required',
            'companyname' => 'required'          
        ]);

        // Create Invitation 
        $invitation = new Invitation;
        $invitation->email = $request->input('email');
        $invitation->companyname = $request->input('companyname');
        $invitation->userid = $request->input('userid');      

        $invitation->save();

        return $invitation;

      //  return redirect('/invitationadmin')->with('success', 'InvitationAdmin Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       /* $invitation = Invitation::find($id);
        return view('invitationadmin.show')->with('invitation', $invitation);
       */
      return Invitation::find($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invitation = Invitation::find($id);
        
        //Check if Invitation exists before deleting
        if (!isset($invitation)){
            return redirect('/invitationadmin')->with('error', 'No InvitationAdmin Found');
        }

        return view('invitationadmin.edit')->with('invitation', $invitation);
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
            'email' => 'required',
            'userid' => 'required',
            'companyname' => 'required'          
        ]);


        $invitation = Invitation::find($id);

        // Update Invitation
        $invitation->email = $request->input('email');
        $invitation->userid = $request->input('userid');
        $invitation->companyname = $request->input('companyname');         

        $invitation->save();

        return $invitation;
        
      //  return redirect('/invitationadmin')->with('success', 'InvitationAdmin Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $invitation = Invitation::find($id);
        
        //Check if Drink exists before deleting
        if (!isset($invitation)){
            return redirect('/invitationadmin')->with('error', 'No InvitationAdmin Found');
        }
        
        $invitation->delete();

        return redirect('/invitationadmin')->with('success', 'InvitationAdmin Removed');
    }
}
