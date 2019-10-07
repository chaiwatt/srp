<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\Allocation;
use App\Model\AllocationTransaction;
use App\Model\AllocationWaiting;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Refund;
use App\Model\NotifyMessage;
use App\Model\Users;
use App\Model\TransferTransaction;
use App\Model\Linenotify;
use App\Model\LogFile;

class ProjectSummaryController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }


        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

    	if( count($project)==0){
    		return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
    	}

        $department = SettingDepartment::where('setting_year' , $project->year_budget)->where('setting_department_status' , 1)->orderBy('department_id' , 'asc')->get();
        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->orderBy('budget_id' , 'asc')->get();
        $settingyear = SettingYear::where('setting_status' , 1)->first();
    	$allocation = Allocation::where('project_id' , $project->project_id)->where('allocation_type' , 1)->orderBy('department_id' , 'asc')->orderBy('budget_id' , 'asc')->get();
        $budgetlist = ProjectBudget::where('project_id' , $project->project_id)->orderBy('budget_id' , 'asc')->get();

        $sumbydept = AllocationWaiting::where('waiting_status',1)
                                    ->where('year_budget',$settingyear->setting_year)
                                    ->groupBy('department_id')
                                    ->selectRaw('*, sum(waiting_price) as sum')
                                    ->get();                         

        $q = AllocationWaiting::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('year_budget' , $settingyear->setting_year);
        $q = $q->where('waiting_status' , 1);
        $waiting = $q->get();

        return view('project.summary')
                            ->withDepartment($department)
                            ->withBudget($budget)
                            ->withProject($project)
                            ->withAllocation($allocation)
                            ->withBudgetlist($budgetlist)
                            ->withWaiting($waiting)
                            ->withSumbydept($sumbydept);
    }
    public function authsuperadmint(){
        $auth = Auth::user();
        if( $auth->permission != 1 ){
            return true;
        }
        else{
            return false;
        }
    }
}
