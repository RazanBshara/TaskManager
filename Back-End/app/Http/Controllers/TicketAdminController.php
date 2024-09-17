<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
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
        $ticket = DB::table('tickets')
        ->select(
            'tickets.name',
            'tickets.description',
            'tickets.startdate',
            'tickets.enddate',            
            'tickets.type',                              
            'tickets.status',             
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CrearedBy')                
        )
        ->orderBy('tickets.created_at','desc')
        ->get();

        return $ticket;
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

        return $user;

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
            'startdate' => 'required',
            'enddate' => 'required'
        ]);


        // Create Ticket 
        $ticket = new Ticket;
        $ticket->name = $request->name;   
        $ticket->description = $request->description;
        $ticket->startdate = $request->startdate;
        $ticket->enddate = $request->enddate;
        $ticket->createdby =  $request->userid;        
        $ticket->type = $request->type;        
 
        $ticket->save();

        //UserTicket
        $UserTicket = new UserTicket;
        $UserTicket->userid = auth()->user()->id;
        $UserTicket->ticketid = $ticket->id;
        
        $UserTicket->save();

        //Ticket Flow
        $this->createticketflow($ticket->id , $ticket->type);

        return $ticket;    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = DB::table('tickets')
        ->select(
            'tickets.name',
            'tickets.description',
            'tickets.startdate',
            'tickets.enddate',            
            'tickets.type',                              
            'tickets.status',             
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CrearedBy')                
        )
        ->orderBy('tickets.created_at','desc')
        ->get();

        return $ticket;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')
        ->select(
            'users.id',
            DB::raw(' CONCAT(users.firstname, " ", users.lastname) AS Manager')
        )
        ->orderBy('created_at','desc')
        ->paginate(10);

        $ticket = DB::table('tickets')
        ->select(
            'tickets.name',
            'tickets.description',
            'tickets.startdate',
            'tickets.enddate',            
            'tickets.type',                              
            'tickets.status',             
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CrearedBy')                
        )
        ->where('id','=',$id)
        ->get();

        return (['ticket'=>$ticket , 'user'=>$user]);
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
            'startdate' => 'required',
            'enddate' => 'required'
        ]);


        //Update Ticket 
        $ticket = Ticket::find($id);
        $ticket->name = $request->name;   
        $ticket->description = $request->description;
        $ticket->startdate = $request->startdate;
        $ticket->enddate = $request->enddate;
        $ticket->createdby = auth()->user()->id;        
        $ticket->type = $request->type;
  
        $ticket->save();

        return $ticket;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);   

        //Check if Ticket exists before deleting
        if (!isset($ticket)){
            return 'No Ticket Found';
        }

        UserTicket::where('ticketid' , '=' , $id )->delete();

        return Ticket::destroy($id);
    }
}
