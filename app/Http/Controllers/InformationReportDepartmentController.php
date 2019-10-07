<?php

namespace App\Http\Controllers;
use Auth;
use Request;
use App\Model\Allocation;
use App\Model\Project;
use App\Model\SettingYear;
use App\Model\Transfer;
use App\Model\InformationExpense;
use App\Model\Refund;

class InformationReportDepartmentController extends Controller
{

    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 2);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->get()->first();

        $q = InformationExpense::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 2);
        $payment = $q->get();

        $q = Refund::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 2);
        $q = $q->where('refund_type' , 2);
        $refund = $q->get();

        return view('information.report.department.index')->withProject($project)
                                                ->withPayment($payment)
                                                ->withAllocation($allocation)
                                                ->withRefund($refund);
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
