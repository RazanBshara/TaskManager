<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TicketFlow;

use App\Models\UserTicket;
use App\Models\Ticket;
use App\Models\Process;

use DB;

class TicketController extends Controller
{
    use TicketFlow;

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
        $ticket = DB::table('tickets')
        ->select(
            'tickets.id',
            'tickets.name',
            'tickets.description',
            'tickets.startdate',
            'tickets.enddate',
            'tickets.type',
            'tickets.status',
            DB::raw('CONCAT(users.firstname, " ", users.lastname) AS CreatedBy')
        )
        ->join('user_tickets', 'user_tickets.ticketid', '=', 'tickets.id')
        ->join('users', 'tickets.createdby', '=', 'users.id')

        ->where('user_tickets.userid' , '=' , auth()->user()->id)

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
        //
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
        $ticket->createdby = auth()->user()->id;
        $ticket->type = $request->type;
        //$ticket->status = $request->status;

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
        return Ticket::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    //User Actiones;

    public function approveticket(Request $request){

        $ticketid  =  $request->ticketid;

        $process = Process::where('ticketid' , '=' , $ticketid)->where('userid' , '=' , auth()->user()->id)->where('status' , '=' , 'Pending Approve')->first();

        //Check if process exists before approved
        if (!isset($process)){
            return 'No Ticket Found';
        }

        $process->status = 'Approved';
        $process->save();

        $checkwaitingapprove = Process::where('ticketid' , '=' , $ticketid)->where('status' , '=' , 'Waiting Approve')->min('priority');

        if ($checkwaitingapprove != '') {

            $checkwaitingapprove->status = 'Pending Approve';
            $checkwaitingapprove->save();

        }else {

            $this->updateticketstatus($ticketid , 'Approved');
        }

        return 'Approved';

    }


    public function rejectticket(Request $request){

        $ticketid  =  $request->ticketid;

        $description = $request->description;

        $process = Process::where('ticketid' , '=' , $ticketid)->where('userid' , '=' , auth()->user()->id)->where('status' , '=' , 'Pending Approve')->first();

        //Check if Process exists before Edeting
        if (!isset($process)){
            return 'No Ticket Found To Reject';
        }

        $process->status = 'Rejected';
        $process->description = $description;
        $process->save();

        $processwaiting = Process::where('ticketid' , '=' , $ticketid)->where('status' , 'LIKE' , '%Waiting%')->get();

        foreach ($processwaiting as $processwaitings) {
            $processwaitings->status = 'Faild';
            $processwaitings->save();
        }

        $ticket = Ticket::find($ticketid);
        $ticket->status = 'Rejected';
        $ticket->save();

        $this->updateticketstatus($ticketid , 'Rejected');

        return 'Rejected';

    }



    ///
}
