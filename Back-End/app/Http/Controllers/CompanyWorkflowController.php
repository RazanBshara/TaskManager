<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WorkflowUpperLevel;

class CompanyWorkflowController extends Controller
{
    public function CreateCompanyWorkflow(Request $request){
        
        $workflowtypes  = $request->workflowtypes;
        $countworkflowtypes = count($workflowtypes);

        $WorkflowUpperLevel = WorkflowUpperLevel::where('companyid' , '=' , $request->companyid)->delete();

        if ($countworkflowtypes > 0) {            
                        
            for ($i=0; $i < $countworkflowtypes; $i++) { 
        
                $WorkflowUpperLevel = new WorkflowUpperLevel();
                $WorkflowUpperLevel->companyid =  $request->companyid;
                $WorkflowUpperLevel->workflowtype = $workflowtypes[$i];
                $WorkflowUpperLevel->save();

                return 'Done';
            } 
           
        }else {
            return 'Done';
        }
    }
}
