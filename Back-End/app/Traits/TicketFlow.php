<?php

namespace App\Traits;

use App\Traits\TicketFlow;

use Carbon\Carbon;

use App\Models\UserRoleGroupCompany;
use App\Models\ProcessType;
use App\Models\Process;
use App\Models\User;
use App\Models\Company;
use App\Models\Workspace;
use App\Models\Project;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Section;
use App\Models\Ticket;

trait TicketFlow {

    public function createticketflow($ticketid , $tickettype){

        switch ($tickettype) {
            case 'vacation':

                $this->vacationflow($ticketid);
               
                break;
            
            default:
                # code...
                break;
        }

    }
 
    public function vacationflow($ticketid){

        $this->upperlevelapprove($ticketid , 1);
    }

    public function upperlevelapprove($ticketid , $upperlevel){

        $ticket = Ticket::find($ticketid);
        $user_id  = $ticket->createdby;
        
        for ($i=0; $i < $upperlevel; $i++) { 
                    
            $upperid = $this->getupper($user_id); 
            if ($upperid != '') {

                $this->approve($ticketid , $upperid);
            }                                                  

            $user_id = $upperid;
        }

        return 'DONE';
    }

    public function getupper($userid)
    {
        $rolegroupcompanyid = UserRoleGroupCompany::where('userid' , '=' , $userid)->min('rolegroupcompanyid');        
        $user = User::find($userid);      

        switch ($rolegroupcompanyid) {
            case 1://Owner Company
                $upperid = '';
                break;

            case 2://CEO
                
                //Owner Company
                $company = Company::find($user->companyid);
                $OwnerCompany = $company->userid;

                $upperid = $OwnerCompany;

                break;
            
            case 3://Manager
                
                //$CEO 
                $company = Company::find($user->companyid);
                $CEO = $company->ceoid;
        
                $upperid = $CEO;
                                
                break;
            case 4://Project Manager
                                
                $project = Project::where('pm' , '=' , $user->id)->first();
                //Manager
                $workspace = Workspace::find($project->workspaceid);
                $Manager = $workspace->managerid;

                $upperid = $Manager;
                                
                break;
                
            case 5://Director (Department Manager)
                
                //CEO
                $company = Company::find($user->companyid);                
                $CEO = $company->ceoid;
                $upperid = $CEO;
                                
                break;
            
            case 6://Head Of Unit(HOU)
                
                //Director
                $department = Department::find($user->departmentid);
                $Director = $department->director;

                $upperid = $Director;
                                
                break;

            case 7://Head Of Section(HOS)
                                
                //HOU
                $unit = Unit::find($user->unitid);
                $HOU = $unit->hou;

                $upperid = $HOU;                
                                
                break;
            
            case 8://Employee
                
                //HOS
                $section = Section::find($user->sectionid);
                $HOS = $section->hos;

                $upperid = $HOS;   
                                
                break;
            
            default:
                $upperid = '';
                break;
        }
        

        return $upperid;

    }

    public function approve($ticketid , $assignedid){

        //Approve from $userassigned    

        $processgetcount = Process::where('ticketid' , '=' , $ticketid)->where('status' , '=' , 'Pending Approve')->get();

        $processcount = $processgetcount->count();

        if ($processcount == 0) {

            $this->createprocess($ticketid , $assignedid ,  'Approve' , 'Pending Approve' , $processcount + 1);                    
       
        }else {

            $this->createprocess($ticketid , $assignedid ,  'Approve' , 'Waiting Approve' , $processcount + 1);
        }

        return 'Approve Ticket Assigned';
          
    }

    public function createprocess($ticketid , $assignedid , $type , $status , $priority){

        $processtype = ProcessType::where('type' , '=' , $type)->first();

        if ($type == 'Approve') {
            
            $process = new Process;
            $process->ticketid = $ticketid;
            $process->userid = $assignedid;
            $process->typeid = $processtype->id;
            $process->priority = $priority;
            $process->status = $status;
          
            $process->save();

        }

        return $process;

    }


     //Job Functions


    public function updateticketstatus($ticketid , $action){

        $processgetcount = Process::where('ticketid' , '=' , $ticketid)         
        ->whereRaw('(status like ? or status like ?)', ["%Pending%","%Waiting%"])         
        ->count();  

        if ($action == 'Rejected') {
            
            $ticket = Ticket::find($ticketid);
            $ticket->status = 'Rejected';
            $ticket->save();
            
            return 'Rejected';
        }elseif ($processgetcount > 0) {
           
            return 'No Action';
        }else {

            $ticket = Ticket::find($ticketid);
            $ticket->status = $action;
            $ticket->save();
            
            return 'Updated';
        }        
    }
    



}
