<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use DB;
use PDF;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\ReadinessExpense;
use App\Model\Allocation;
use App\Model\Transfer;
use App\Model\ReadinessSection;
use App\Model\ProjectReadiness;


class ReadinessReportDepartmentController extends Controller
{
    //
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();


        $allocation = Allocation::where('project_id' , $project->project_id)
                                ->where('budget_id' , 4)
                                ->where('department_id' , $auth->department_id)
                                ->where('allocation_type' , 1)
                                ->get()
                                ->first();
        
        $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , 0)
                                ->where('budget_id' , 4)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 1)
                                ->get();
                                // ->sum('transfer_price');

        $payment = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',1)
                                ->where('status',1)
                                ->where('completed',1)
                                ->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',1)
                                ->where('department_id', $auth->department_id)
                                ->get(); 

        $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',1)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->get();  
        $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',1)
                                ->where('department_id', $auth->department_id)
                                ->get();                              

        return view('readiness.report.department.index')->withProject($project)
                                ->withPayment($payment)
                                ->withTransfer($transfer)
                                ->withReadiness($readiness)
                                ->withProjectreadiness($projectreadiness)
                                ->withReadinesssection($readinesssection)
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
