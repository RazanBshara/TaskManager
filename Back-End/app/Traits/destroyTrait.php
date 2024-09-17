<?php

namespace App\Traits;

use App\Traits\destroyTrait;

use App\Models\Workspace;
use App\Models\Company;
use App\Models\Project;
use App\Models\Task;
use App\Models\Unit;
use App\Models\section;
use App\Models\Department;
use App\Models\ProjectDepartmentUnitSectionUser;
use App\Models\UserTask;
 
trait destroyTrait {

    public function deletecompany($companyid)
    {                
        $this->deletedepartment($companyid);

        $this->deleteworkspace($companyid);
        
        return Company::where('id' , '=' , $companyid)->delete();
    }    
    public function deleteworkspace($companyid)
    {   
        $workspace = Workspace::where('companyid' , '=' , $companyid)->get();

        foreach ($workspace as $workspaces) {
                       
            $this->deleteproject($workspaces->id);             
        }

        return Workspace::where('companyid' , '=' , $companyid)->delete();

    }
    public function deleteproject($workspaceid)
    {
        $project = Project::where('workspaceid' , '=' , $workspaceid)->get();

        foreach ($project as $projects) {
                       
            $this->deletetask($projects->id);

            ProjectDepartmentUnitSectionUser::where('projectid' , '=' , $projects->id)->delete();           
        }

        return Project::where('workspaceid' , '=' , $workspaceid)->delete();
    }

    public function deletetask($projectid)
    {
        $task = Task::where('projectid' , '=' , $projectid)->get();

        foreach ($task as $tasks) {

            UserTask::where('taskid' , '=' , $tasks->id)->delete();

            Task::descendantsOf($tasks->id)->delete();  
        }
        
        return Task::where('projectid' , '=' , $projectid)->delete();

    }

    ////////

    public function deletedepartment($companyid)
    {       
        $department = Department::where('companyid' , '=' , $companyid)->get();

        foreach ($department as $departments) {
            
            $this->deleteunit($departments->id);
        }        

        Department::where('companyid' , '=' , $companyid)->delete();   
    }

    public function deleteunit($departmentid)
    {
        $unit = Unit::where('departmentid' , '=' , $departmentid)->get();

        foreach ($unit as $units) {
                       
            $this->deletesection($units->id);    
        }

        return Unit::where('departmentid' , '=' , $departmentid)->delete();
    }

    public function deletesection($unitid)
    {
        $section = Section::where('unitid' , '=' , $unitid)->get();

        foreach ($section as $sections) {
            
            ProjectDepartmentUnitSectionUser::where('sectionid' , '=' , $sections->id)->delete(); 
        }        

        return Section::where('unitid' , '=' , $unitid)->delete();

    }

}

