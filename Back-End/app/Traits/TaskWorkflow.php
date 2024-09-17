<?php

namespace App\Traits;

use App\Traits\TaskWorkflow;
use App\Traits\destroyTrait;
use Carbon\Carbon;

use App\Models\UserRoleGroupCompany;
use App\Models\Company;
use App\Models\Workspace;
use App\Models\Project;
use App\Models\Task;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Section;
use App\Models\User;
use App\Models\ProcessType;
use App\Models\Process;
use App\Models\UserTask;
use App\Models\RoleGroupCompany;

trait TaskWorkflow {

    use destroyTrait;

    public function createtaskworkflow( $taskname, $assignedid , $upperlevel , $relatedto , $relatedid, $parent_id = null, $dependontask = null, $assignedtype = null){

        //Get the Pending Tasks still not approved
        $PendingTaskWorkfowCount = Task::where('relatedid' , '=' , $relatedid)
                            ->where('status' , '!=' , 'Done')->count();

        //workflow
        $task = new Task;
        $task->name = $taskname;
        $task->startdate = Carbon::now()->toDateTimeString();
        $task->createdby = auth()->user()->id;
        $task->relatedto = $relatedto;
        $task->relatedid = $relatedid;
        $task->priority =  $priority = $PendingTaskWorkfowCount + 1;
        $task->parent_id = $parent_id;
        $task->type = 'General';
        $task->status = 'In Progress';
        $task->dependontask = $dependontask;

        $task->save();

        if ($assignedtype == null || $assignedtype == '') {

            $assignedtype = 'User';

        }

        //get the upperlevel
        if ($upperlevel == null) {
            $upperlevel = -1;
        }

        if ($assignedid != null || $assignedid != '') {
            $this->taskworkflow($assignedid , $task->id , $upperlevel, $assignedtype);
        }else {

            $this->taskworkflow( 0 , $task->id , $upperlevel);
        }

    }

    public function taskworkflow($assignedid , $taskid , $upperlevel, $assignedtype = null)
    {
        if ($assignedtype == null || $assignedtype == '') {

            $assignedtype = 'User';

        }

        $task = Task::find($taskid);
        $rolegroupcompanyid = UserRoleGroupCompany::where('userid' , '=' , $task->createdby)->min('rolegroupcompanyid');

        $isactive = $this->GetIsActiveStatus($task->relatedto, $task->relatedid);

        if ($upperlevel == 0) {

            $this->upperlevelapprove($taskid , 1 , $isactive);

        }else {

            $this->upperlevelapprove($taskid , $upperlevel,$isactive);
        }


        $assignedusersid = $this->GetAssignedUsers($assignedtype , $assignedid);
        $assignedid = $assignedusersid;

        $this->SendRecivedConfirmToUsers($rolegroupcompanyid, $task, $assignedid, $isactive);

    }

    ///Functiones:

    public function upperlevelapprove($taskid , $upperlevel, $isactive){

        $task = Task::find($taskid);
        $user_id  = $task->createdby;

        for ($i=0; $i < $upperlevel; $i++) {

            $upperid = $this->getupper($user_id);
            if ($upperid != '') {

                $this->approve($taskid , $upperid ,  $isactive);
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

                $upperid = '';

                break;

            default:
                $upperid = '';
                break;
        }


        return $upperid;

    }

    public function approve($taskid , $assignedid,  $isactive){

        //Approve from $userassigned

        $processgetcount = Process::where('taskid' , '=' , $taskid)->where('status' , '=' , 'Pending Approve')->get();

        $processcount = $processgetcount->count();

        if ($processcount == 0) {

            $this->createprocess($taskid , $assignedid ,  'Approve' , 'Pending Approve' , $processcount + 1,  $isactive);

        }else {

            $this->createprocess($taskid , $assignedid ,  'Approve' , 'Waiting Approve' , $processcount + 1,  $isactive);
        }

        return 'Approve Task Assigned';

    }

    public function reciviedconfirm($taskid , $assignedid,  $isactive){

        //Recivied confirm from $userassigned

        $processgetcount = Process::where('taskid' , '=' , $taskid)->where('status' , '=' , 'Pending Approve')->get();

        $processcount = $processgetcount->count();

        if ($processcount == 0) {

            $this->createprocess($taskid , $assignedid ,  'Recivied Confirm' , 'Pending Confirm' , 0,  $isactive);

        }else {

            $this->createprocess($taskid , $assignedid ,  'Recivied Confirm' , 'Waiting Confirm'  , 0, $isactive);
        }

        return 'Recivied Confirm Task Assigned';

    }


    public function createprocess($taskid , $assignedid , $type , $status , $priority,  $isactive = null){

        $processtype = ProcessType::where('type' , '=' , $type)->first();

        if ( $type == 'Recivied Confirm') {

            for ($i=0; $i < count($assignedid); $i++) {

                $process = new Process;
                $process->taskid = $taskid;
                $process->userid = $assignedid[$i];
                $process->typeid = $processtype->id;
                $process->priority = $priority;
                $process->status = $status;

                if ($isactive == false) {
                    $process->isactive = 'nonactive';
                }else {
                    $process->isactive = 'active';
                }

                $process->save();
            }

        }elseif ($type == 'Approve') {

            $process = new Process;
            $process->taskid = $taskid;
            $process->userid = $assignedid;
            $process->typeid = $processtype->id;
            $process->priority = $priority;
            $process->status = $status;

            if ($isactive == false) {
                $process->isactive = 'nonactive';
            }else {
                $process->isactive = 'active';
            }

            $process->save();

        }elseif ($type == 'Review') {

            $process = new Process;
            $process->taskid = $taskid;
            $process->userid = $assignedid;
            $process->typeid = $processtype->id;
            $process->priority = $priority;
            $process->status = $status;
            $process->isactive = 'active';

            $process->save();
        }

        return $process;

    }

    //Job Functions


    public function updatetaskstatus($taskid , $action){
        //the action came from the last process under the task (Rejected , Approve, Confirm)

        $task = Task::find($taskid);

        if ($action == 'Approved') {

            $OrginalTask = Task::find($task->relatedid);
            $isroot = $OrginalTask->isRoot();
            $isLeaf = $OrginalTask->isLeaf();
            $dependontask =  $OrginalTask->dependontask;
        }else {

            $isroot = $task->isRoot();
            $isLeaf = $task->isLeaf();
            $dependontask =  $task->dependontask;
        }

        if ($action == 'Rejected') {

            if ($isroot == true && $isLeaf == false){//has children

                //update the subtasks to done
                $this->updatesubtasksstatus($taskid , 'Rejected');

                $task->status = 'Rejected';
                $task->save();

            }elseif($isroot == true) {

                $task->status = 'Rejected';
                $task->save();

            }else{//the task is child and not has any children

                return 'You cannat Reject Sub Task!!!';
            }

            return 'Rejected';

        }elseif ($action == 'SubmitToReview') {

            $this->createprocess($taskid , $task->createdby , 'Review' , 'Pending Review' , 1);

            $task->status = 'Reviewing';
            $task->save();

            return 'The Task Under Reviewing';

        }elseif ($action == 'SubmitReviewedTask') {

            $parent_id = $task->parent_id; // delete

            if ($isroot == true && $isLeaf == false) {//has childrens

                //get the childs
                $readytaskchild = Task::where('parent_id' , '=' , $taskid)->where('status' , '!=' , 'Ready')->where('type' , '!=' , 'General')->get();

                if ( $readytaskchild  != '[]') {

                    return 'There are Subtasks Not submited yet!!!!!!';
                }else {

                    $task->status = 'Done';
                    $task->save();

                    //update the subtasks to done
                    $this->updatesubtasksstatus($taskid , 'Submit');

                    $this->activedependontask($taskid);

                }

            }elseif ($isroot == false && $isLeaf == false) {

                //get the childs
                $readytaskchild = Task::where('parent_id' , '=' , $taskid)->where('status' , '!=' , 'Ready')->where('type' , '!=' , 'General')->get();

                if ($readytaskchild  != '[]') {

                    return 'There are Subtasks Not submited yet!!!!!!';

                }else{

                    $task->status = 'Ready';
                    $task->save();


                    $readytaskbrothers = Task::where('parent_id' , '=' , $parent_id)->where('status' , '!=' , 'Ready')->where('type' , '!=' , 'General')->get();

                    if ($readytaskbrothers == '[]') {

                        //update the status of parent task
                        $parenttask = Task::find($parent_id);

                        $parenttask->status = 'Pending';
                        $parenttask->save();
                    }


                }
            }elseif ($isroot == false && $isLeaf == true){

                $task->status = 'Ready';
                $task->save();

                $readytaskbrothers = Task::where('parent_id' , '=' , $parent_id)->where('status' , '!=' , 'Ready')->where('type' , '!=' , 'General')->get();

                if ($readytaskbrothers == '[]'){

                    //update the status of parent task
                    $parenttask = Task::find($parent_id);

                    $parenttask->status = 'Pending';
                    $parenttask->save();
                }


            }else { // isroot == true and isLeaf == true

                $task->status = 'Done';
                $task->save();

                $this->activedependontask($taskid);
            }

        }elseif ($action == 'Confirmed' || $action == 'Approved'){

            $task->status = 'ApprovedAndConfirmed';
            $task->save();
        }

            return 'Updated';
    }


    public function updatesubtasksstatus($taskid , $type){

        $taskchild = Task::descendantsOf($taskid)->where('type' , '!=' , 'General');

            foreach ($taskchild as $taskchilds) {

                if ($type == 'Rejected') {

                    $taskchilds->status = 'Rejected';
                    $taskchilds->save();

                }elseif ($type == 'Submit') {

                    $taskchilds->status = 'Done';
                    $taskchilds->save();
                }
            }
    }

    public function activedependontask($taskid){

        $checkdependontask = Task::where('dependontask' , '=' , $taskid)->where('type' , '!=' , 'General')->get();

        if ($checkdependontask != '[]') {

            foreach ($checkdependontask as $checkdependontasks) {

                $process = Process::where('taskid' , '=' , $checkdependontasks->id)->get();

                foreach ($process as $processs) {

                    $processs->isactive = 'active';
                    $processs->save();
                }
            }
        }

    }


    public function GetAssignedUsers($assignedtype , $assignedid){

        switch ($assignedtype) {
            case 'User':

                return $assignedid;

                break;
            case 'Section':

                $users = User::where('sectionid' , '=' , $assignedid)->pluck('id');

                foreach ($users as $user) {

                   $assigneduserids [] = $user;
                }

                return $assigneduserids;

                break;
            case 'Unit':

                $users = User::where('unitid' , '=' , $assignedid)->pluck('id');

                foreach ($users as $user) {

                    $assigneduserids [] = $user;
                 }

                 return $assigneduserids;

                break;
            case 'Department':

                $users = User::where('departmentid' , '=' , $assignedid)->pluck('id');

                foreach ($users as $user) {

                    $assigneduserids [] = $user;
                 }

                 return $assigneduserids;

                break;

            default:

                $rolegroupcompanyid = RoleGroupCompany::where('adjictive' , '=' , $assignedtype)->pluck('id');
                $users = UserRoleGroupCompany::where('rolegroupcompanyid' , '=' , $rolegroupcompanyid)->pluck('userid');

                foreach ($users as $user) {

                    $assigneduserids [] = $user;
                 }

                 return $assigneduserids;

                break;
        }

    }

    public function GetIsActiveStatus($taskrelatedto, $relatedid){

        if ($taskrelatedto == 'task') {

            $orginaltask = Task::find($relatedid);

            $isroot = $orginaltask->isRoot(); //check if the ttask is root
            $isleaf = $orginaltask->isleaf();
            $isdependontask = $orginaltask->dependontask;
            $parnttask = $orginaltask->parent;

            if (((!$isroot && !$isleaf) || (!$isroot && $isleaf) || ($isroot && !$isleaf))) {

                $parentstatus = $orginaltask->parent->status;

                if ($parentstatus == 'Pending' || $parentstatus == 'Ready') {

                    $parnttask = 'Hanging';
                    $parnttask->save();

                    $isactive = true;

                }elseif ($parentstatus == 'Done') {

                    $allparent = Task::withDepth()->ancestorsOf($orginaltask->id)->where('type' , '!=' , 'General');

                    $brothers = $orginaltask->getSiblings()->where('type' , '!=' , 'General');

                    foreach ($brothers as $brotherss) {

                        $brotherss->status = 'Ready';
                        $brotherss->save();
                    }

                    foreach ($allparent as $allparents) {

                        $allparents->status = 'Hanging';
                        $allparents->save();

                        $parentbrothers = $allparents->getSiblings()->where('type' , '!=' , 'General');

                        foreach ($parentbrothers as $parentbrotherss) {

                            $parentbrotherss->status = 'Ready';
                            $parentbrotherss->save();
                        }
                    }

                    $isactive = true;

                    //update all parents status to Hanging

                }elseif ($parentstatus == 'Hanging') {

                    $isactive = true;
                }
                else {

                    $isactive = false;

                }
            }elseif (($isroot == false || $isdependontask)) {

                $isactive = false;

            }else {

                $isactive = true;
            }

        }else {
            $isactive = true;
        }

        return $isactive;

    }

    public function SendRecivedConfirmToUsers($rolegroupcompanyid, $task, $assignedid, $isactive){

        switch ($rolegroupcompanyid) {
            case 1://Owner Company

                if ($assignedid != 0) {
                    //Recivied confirm from $assignedid
                    $this->reciviedconfirm($task->id , $assignedid,  $isactive);
                }

                break;

            case 5://Director (Department Manager)

                if ($assignedid != 0) {
                    //Project Manager Recivied confirm if the task related to project
                    if ($task->projectid != null) {

                        $PM = $project->pmid;
                        $this->reciviedconfirm($task->id , $PM, $isactive);
                    }
                    //Recivied confirm from $assignedid
                    $this->reciviedconfirm($task->id , $assignedid,  $isactive);
                }

                break;

            case 6://Head Of Unit(HOU)

                if ($assignedid != 0) {
                    //Director Recivied confirm if the task related to project
                    if ($task->projectid != null) {

                        $Director = $department->director;
                        $this->reciviedconfirm($task->id , $Director,  $isactive);
                    }

                    //Recivied confirm from $assignedid
                    $this->reciviedconfirm($task->id , $assignedid, $isactive);
                }

                break;

            case 7://Head Of Section(HOS)

                if ($assignedid != 0) {
                    //HOU Recivied confirm if the task related to project
                    if ($task->projectid != null) {

                        $HOU = $unit->hou;
                        $this->reciviedconfirm($task->id , $HOU,  $isactive);
                    }

                    //Recivied confirm from $assignedid
                     $this->reciviedconfirm($task->id , $assignedid,  $isactive);
                }
                break;

            default:

                if ($assignedid != 0) {
                    $this->reciviedconfirm($task->id , $assignedid,  $isactive);
                }

                break;
            }
        }




}
