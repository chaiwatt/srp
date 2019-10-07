<?php

namespace App\Http\Controllers;
use Request;
use Session;
use Auth;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Allocation;
use App\Model\ProjectFollowup;

class FollowupReportDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();


        $allocation = Allocation::where('project_id' , $project->project_id)
                                ->where('budget_id' , 3)
                                ->where('department_id' , $auth->department_id)
                                ->where('allocation_type' , 1)
                                ->get()
                                ->first();
        
        $payment = ProjectFollowup::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 3)
                                ->get();


        return view('followup.report.department.index')->withProject($project)
                                                ->withPayment($payment)
                                                ->withAllocation($allocation);
    }
    
    public function authdepartment(){
        $auth = Auth::user();
        if( $auth->permission != 2 ){
            return true;
        }
        else{
            return false;
        }
    }
}
