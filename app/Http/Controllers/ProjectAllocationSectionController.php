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

use App\Model\Allocation;


class ProjectAllocationSectionController extends Controller{

    public function View($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('allocation_id' , $id);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->first();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('budget_id' , $allocation->budget_id);
        $q = $q->where('transfer_type' , 2);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->get();

        $budget = Budget::where('budget_id' , $allocation->budget_id)->first();

        return view('project.allocation.section.view')->withProject($project)
        ->withTransfer($transfer)
        ->withBudget($budget);

    }

    public function Lists(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
           // return redirect('logout')->withError("ยังไม่ได้กำหนดโครงการ");
            return "<center><strong>ยังไม่ได้กำหนดโครงการ โปรดติดต่อผู้บริหารโครงการ</strong></center>";
        }
        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->get();

        return view('project.allocation.section.list')->withAllocation($allocation)->withProject($project);

    }

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->get();

        return view('project.allocation.section.index')->withProject($project)->withAllocation($allocation);
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


