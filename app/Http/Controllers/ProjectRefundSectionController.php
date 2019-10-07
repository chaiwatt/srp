<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use App\Controllers\ApiController;
use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\Project;
use App\Model\ProjectAllocation;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\DepartmentAllocation;
use App\Model\TransferDepartment;
use App\Model\Refund;

class ProjectRefundSectionController extends Controller{

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Refund::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('refund_type' , 2);
        $refund = $q->get();

        return view('project.refund.section.index')->withProject($project)->withRefund($refund);
    }

    public function authsection(){
        $auth = Auth::user();
        if( $auth->permission != 3 ){
            return true;
        }
        else{
            return false;
        }
    }

}


