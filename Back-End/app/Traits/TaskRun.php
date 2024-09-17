<?php

namespace App\Traits;

use App\Traits\TaskRun;
use App\Traits\NotificationTrait;
use Carbon\Carbon;

use App\Models\Workspace;
use App\Models\Project;
use App\Models\Task;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Section;
use App\Models\ProjectDepartmentUnitSection;
use App\Models\UserTask;
use App\Models\User;
use App\Models\Process;


trait TaskRun {

    use NotificationTrait;

    //Job Functiones

    public function jobrunforApprovedAndConfirmedtasks(){   
        
        $this->runApprovedAndConfirmedtask();
        
        $this->disablerejectedtask();

    }

    public function disablerejectedtask(){

        $task = Task::where('status' , '=' , 'Rejected')->get();

        $process = Process::where('status' , '=' , 'Faild')->get();

        foreach ($process as $processs) {
                        
            Process::destroy($processs->id);            
        }

        foreach ($task as $tasks) {
            
            UserTask::where('taskid' , '=' , $tasks->id)->delete();
            
        }

    }

    public function runApprovedAndConfirmedtask(){

        $task = Task::where('status' , '=' , 'ApprovedAndConfirmed')->where('type' , '=' , 'General' )->get();           

        if ($task == '[]') {
            
            return 'No ApprovedAndConfirmed tasks founded!!';
        }

        foreach ($task as $tasks) {

         if ($tasks->name == 'Create') {        

                //$tasks->isactive = 'active';
                $tasks->status = 'Done';
                $tasks->save();                
                
                $this->activetask($tasks->relatedto , $tasks->relatedid);

                $this->NotifyUser($tasks);//Added

            }elseif ($tasks->name == 'Update') {
                
                //$tasks->isactive = 'active';
                $tasks->status = 'Done';
                $tasks->save();
                
                $this->updatetask($tasks->relatedto , $tasks->relatedid);    
                
                $this->NotifyUser($tasks);//Added   
                
            }elseif ($tasks->name == 'Delete') {

                //$tasks->isactive = 'active';
                $tasks->status = 'Done';
                $tasks->save();
                                
                $this->removetask($tasks->relatedto , $tasks->relatedid);

                $this->NotifyUser($tasks);//Added

            }
            
        }

        return  'Done';

    }

    public function activetask($relatedto , $relatedid){
        switch ($relatedto) {
            case 'workspace':
                
                $workspace = Workspace::find($relatedid);
                $workspace->isactive = 'active';
                $workspace->save();
                
                break;
             case 'project':
                
                $project = Project::find($relatedid);
                $project->isactive = 'active';
                $project->save();

                $ProjectDepartmentUnitSection = new ProjectDepartmentUnitSection;
                $ProjectDepartmentUnitSection->projectid = $relatedid;
                $ProjectDepartmentUnitSection->userid = $project->createdby;                
                $ProjectDepartmentUnitSection->save();

                if ($project->pmid != Null) {
                    
                    $ProjectDepartmentUnitSection = new ProjectDepartmentUnitSection;
                    $ProjectDepartmentUnitSection->projectid = $relatedid;
                    $ProjectDepartmentUnitSection->userid = $project->pmid;                
                    $ProjectDepartmentUnitSection->save();
                }
                
                break;
             case 'task':

                //the orginal task
                $task = Task::find($relatedid);
                    
                $isLeaf = $task->isLeaf();
                                                              
                if ( $isLeaf  == false) {// if the task is parent
          
                    //get the childs
                    $taskchild = Task::where('parent_id' , '=' , $task->id)->where('type' , '=' , 'General')->get(); 
        
                    foreach ($taskchild as $taskchilds) {
                            
                        $this->updatechildstatus($taskchilds->id);
                    }   
                            
                    $task->status = 'Hanging';
                    $task->isactive = 'active';        
                    $task->save();
        
                }else {
    
                    //if the task is leave
                    $task->status = 'Pending';   
                    $task->isactive = 'active';    
                    $task->save();
                }          
                                                                               
    
                $this->NotifyUser($task);//Added                
    
                //////////////////
                /*
                $task = Task::find($relatedid);
                $task->isactive = 'active';
                $task->save();*/

                break;
             case 'department':
                
                $department = Department::find($relatedid);
                $department->isactive = 'active';
                $department->save();
               
                //Edit the department for the user
                $user = User::find($department->director);
                $user->departmentid = $relatedid;
                $user->save();
    
                break;
             case 'unit':
                
                $unit = Unit::find($relatedid);
                $unit->isactive = 'active';
                $unit->save();

                //Edit the Unit for the user                
                $user = User::find($unit->hou);
                $user->unitid = $relatedid;
                $user->save();

                return $user;
    
                break;
             case 'section':
                
                $section = Section::find($relatedid);
                $section->isactive = 'active';
                $section->save();

                //Edit the section for the user
                $user = User::find($section->hos);
                $user->sectionid = $relatedid;
                $user->save();
    
                break;
            
            default:
                # code...
                break;
        }
    }


    public function updatetask($relatedto , $relatedid){
        switch ($relatedto) {
            case 'workspace':          
                
                $workspace = Workspace::find($relatedid);
                $updatedworkspace = Workspace::where('updatingfor' ,'=' , $relatedid)->first();
                
                $workspace->name = $updatedworkspace->name;
                $workspace->description = $updatedworkspace->description;   
                $workspace->createdby = $updatedworkspace->createdby;       
                $workspace->managerid = $updatedworkspace->managerid;           
                $workspace->companyid = $updatedworkspace->companyid; 
                $workspace->isactive = 'active';  

                $workspace->save();

                Workspace::destroy($updatedworkspace->id);                                
                
                break;
             case 'project':
                
                $project = Project::find($relatedid);

                //Reomve Project From Old Project Manager
                $ProjectDepartmentUnitSectionUser = ProjectDepartmentUnitSectionUser::where('projectid' , '=' , $relatedid)
                ->where('userid' , '=' , $project->pmid)->delete();

                $updatedproject = Project::where('updatingfor' ,'=' , $relatedid)->first();
                
                $project->name = $updatedproject->name;
                $project->description = $updatedproject->description;                   
                $project->startdate = $updatedproject->startdate;
                $project->enddate = $updatedproject->enddate;   
                $project->pmid = $updatedproject->pmid;                            
                $project->isactive = 'active';  

                $project->save();

                $ProjectDepartmentUnitSectionUser = new ProjectDepartmentUnitSectionUser;
                $ProjectDepartmentUnitSectionUser->projectid = $relatedid;
                $ProjectDepartmentUnitSectionUser->userid = $project->pmid;
                $ProjectDepartmentUnitSectionUser->save();

                Project::destroy($updatedproject->id);       
                
                break;
             case 'task':
                            
                $task = Task::find($relatedid);
                $updatedtask = Task::where('updatingfor' ,'=' , $relatedid)->first();

                $task->name = $updatedtask->name;
                $task->description = $updatedtask->description;
                $task->startdate = $updatedtask->startdate;
                $task->enddate = $updatedtask->enddate;
                $task->priority = $updatedtask->priority;
                $task->isactive = 'active'; 
                
                $task->save();

                Task::destroy($updatedtask->id);  

                break;
             case 'department':
                
                $department = Department::find($relatedid);

                //Remove the department from old director for the user
                $user = User::find($department->director);
                $user->departmentid = '';
                $user->save();

                $updateddepartment = Department::where('updatingfor' ,'=' , $relatedid)->first();                               

                $department->name = $updateddepartment->name;        
                $department->description = $updateddepartment->name;
                $department->director = $updateddepartment->name;
                $department->isactive = 'active'; 

                $department->save();

                Department::destroy($updateddepartment->id);

                //Edit the department for the user
                $user = User::find($department->director);
                $user->departmentid = $department->id;
                $user->save();
    
                break;
             case 'unit':
                
                $unit = Unit::find($relatedid);

                //Remove the unit from old HOU for the user
                $user = User::find($unit->hou);
                $user->unitid = '';
                $user->save();

                $updatedunit = Unit::where('updatingfor' ,'=' , $relatedid)->first();                

                $unit->name = $updatedunit->name;
                $unit->description = $updatedunit->description;
                $unit->hou =  $updatedunit->hou;
                $unit->isactive = 'active'; 
                
                $unit->save();

                Unit::destroy($updatedtask->id); 

                //Edit the Unit for the user
                $user = User::find($unit->hou);
                $user->unitid = $unit->id;
                $user->save();
    
                break;
             case 'section':
                
                $section = Section::find($relatedid);

                //Remove the section from old HOS for the user
                $user = User::find($section->hos);
                $user->sectionid = '';
                $user->save();

                $updatedsection= Section::where('updatingfor' ,'=' , $relatedid)->first();
                
                $section->name = $updatedsection->name;
                $section->description = $updatedsection->description;
                $section->hos = $updatedsection->hos;
                $section->isactive = 'active'; 

                $section->save();

                Section::destroy($updatedtask->id); 
                
                //Edit the Section for the user
                $user = User::find($section->hos);
                $user->sectionid = $section->id;
                $user->save();
    
                break;
            
            default:
                # code...
                break;
        }
    }

    public function removetask($relatedto , $relatedid){
        switch ($relatedto) {
            case 'workspace':
                                
                //delete all projects under the workspace by calling project destroy function
                $this->deleteproject($relatedid);

                Workspace::destroy($relatedid); 
                
                break;
             case 'project':

                //delete all ProjectDepartmentUnitSection
                ProjectDepartmentUnitSection::where('projectid' , '=' , $relatedid)->delete(); 

                //delete all tasks under the project.
                $this->deletetask();

                Project::destroy($relatedid); 
                
                break;
             case 'task':

                //delete all UserTask
                $UserTask = UserTask::where('taskid' , '=' , $id)->delete();
                
                Task::descendantsOf($relatedid)->delete(); 

                Task::destroy($relatedid); 
                
                break;
             case 'department':

                // Delete All Units under the Department by calling Unit destroy function     
                $this->deleteunit($relatedid);

                $Department = Department::find($relatedid);

                //Edit the department for the user
                $user = User::find($Department->director);
                $user->departmentid = '';
                $user->save();
                
                Department::destroy($relatedid); 
    
                break;
             case 'unit':

                // Delete All Sectiones under the Unit by calling Sectione destroy function     
                $this->deletesection($relatedid);

                $Unit = Unit::find($relatedid);

                //Edit the unit for the user
                $user = User::find($Unit->hou);
                $user->unitid = '';
                $user->save();
                
                Unit::destroy($relatedid); 
    
                break;
             case 'section':

                ProjectDepartmentUnitSection::where('sectionid' , '=' , $id)->delete(); 

                $Section = Section::find($relatedid);

                //Edit the Section for the user
                $user = User::find($Section->hos);
                $user->sectionid = '';
                $user->save();
                
                Section::destroy($relatedid);
    
                break;
            
            default:
                # code...
                break;
        }
    }

    //Notify the Users:

        public function NotifyUser($task){               
        
            //Notify the users:  
                
           return $message = $this->GetNotifyMessage($task);

            if ($message = '') {
                
                return 'There are no any Mesaages to send!!!!';
            }
    
            $process = Process::where('taskid' , '=' , $task->id)->get();           
    
            foreach ($process as $processs) {
                
                $this->SendNotification($processs->userid , $message);
            }
    
        }
    
        public function GetNotifyMessage($task){
            
            switch ($task->relatedto) {
                case 'workspace':
    
                    $Workspace = Workspace::find($task->relatedid);
                    
                    if ($task->name  == 'Create') {
                        
                        $message = 'New '. $task->relatedto . ' called: ('. $Workspace->name .') has been Created.';
                        
                    }elseif ($task->name  == 'Update') {
                        
                        $message = 'The ' . $Workspace->name . ' has been Updated.';
    
                    }elseif ($task->name  == 'Delete') {
                        
                        $message = 'The ' . $Workspace->name . ' has been Deleted.';
                    }
    
                    break;
                case 'project':
    
                    $Project = Project::find($task->relatedid);
                                    
                    if ($task->name  == 'Create') {
                        
                        $message = 'New '. $task->relatedto . ' called: ('. $Project->name .') has been Created.';
                        
                    }elseif ($task->name  == 'Update') {
                        
                        $message = 'The ' . $Project->name . ' has been Updated.';
    
                    }elseif ($task->name  == 'Delete') {
                        
                        $message = 'The ' . $Project->name . ' has been Deleted.';
                    }
    
                    break;
                case 'task':
    
                    $Task = Task::find($task->relatedid);
                                    
                    if ($task->name  == 'Create') {
                        
                        $message = 'New '. $task->relatedto . ' called: ('. $Task->name .') has been Created.';
                        
                    }elseif ($task->name  == 'Update') {
                        
                        $message = 'The ' . $Task->name . ' has been Updated.';
    
                    }elseif ($task->name  == 'Delete') {
                        
                        $message = 'The ' . $Task->name . ' has been Deleted.';
                    }
    
                    break;
                case 'department':
    
                    $Department = Department::find($task->relatedid);
                    
                    if ($task->name  == 'Create') {
                        
                        $message = 'New '. $task->relatedto . ' called: ('. $Department->name .') has been Created.';
                        
                    }elseif ($task->name  == 'Update') {
                        
                        $message = 'The ' . $Department->name . ' has been Updated.';
    
                    }elseif ($task->name  == 'Delete') {
                        
                        $message = 'The ' . $Department->name . ' has been Deleted.';
                    }
    
                    break;
                case 'unit':
    
                    $Unit = Unit::find($task->relatedid);
                    
                    if ($task->name  == 'Create') {
                        
                        $message = 'New '. $task->relatedto . ' called: ('. $Unit->name .') has been Created.';
                        
                    }elseif ($task->name  == 'Update') {
                        
                        $message = 'The ' . $Unit->name . ' has been Updated.';
    
                    }elseif ($task->name  == 'Delete') {
                        
                        $message = 'The ' . $Unit->name . ' has been Deleted.';
                    }
                    
                    break;
                case 'section':
    
                    $Section = Section::find($task->relatedid);
                    
                    if ($task->name  == 'Create') {
                        
                        $message = 'New '. $task->relatedto . ' called: ('. $Section->name .') has been Created.';
                        
                    }elseif ($task->name  == 'Update') {
                        
                        $message = 'The ' . $Section->name . ' has been Updated.';
    
                    }elseif ($task->name  == 'Delete') {
                        
                        $message = 'The ' . $Section->name . ' has been Deleted.';
    
                    }
    
                    break;
                
                default:
                        $message = '';
                    break;
            }
    
            return  $message;
    
        }

        //for tasks with types project or custom    
        public function updatechildstatus($taskid){

            $process = Process::where('taskid' , '=' , $taskid)->get();

            foreach ($process as $processs) {
                $processs->isactive = 'active';
                $processs->save();
            }

            return 'Updated';
        
        } 
    


    
    
}

