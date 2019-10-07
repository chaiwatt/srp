<?php

namespace App\Http\Controllers;
use Request;
use Session;
use Auth;
use DB;

use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Contractor;
use App\Model\ContractorEmploy;
use App\Model\ContractorPosition;
use App\Model\SettingYear;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\LogFile;

class ContractorHireController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();

        $employ = ContractorEmploy::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->first();
        $generate = Generate::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)->where('section_id' , 0)
                        ->where('generate_category' , 2)
                        ->orderBy('generate_code')
                        ->get();

        $allgenerate = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 6)
                        ->where('payment_status' , 1)
                        ->groupBy('register_id')
                        ->get();

        $department = Generate::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('generate_category' , 2)
                        ->groupBy('department_id')
                        ->get();

        $position = ContractorPosition::where('department_id' , $auth->department_id)
                        ->where('position_status' , 1)
                        ->get();

        $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , 0)
                        ->where('budget_id' , 6)
                        ->where('payment_status' , 1)
                        ->get();

        return view('contractor.hire.index')->withProject($project)
                                                ->withPosition($position)
                                                ->withEmploy($employ)
                                                ->withDepartment($department)
                                                ->withPayment($payment)
                                                ->withAllgenerate($allgenerate)
                                                ->withGenerate($generate);
    
    }


    public function Create($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

  
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $filter = Request::input('filter')==""?"":Request::input('filter');

        $generate = Generate::where('generate_id' , $id)
                        ->where('generate_refund' , 0)
                        ->first();
                     
        if(count($generate) == 0){
            return redirect()->back();
        }

        $gen = Generate::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , 0)
                        ->where('generate_status' , 1)
                        ->where('generate_category' , 2)
                        ->select('register_id')
                        ->get();


        $q = Contractor::query();
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('contractor_type' , 1);
        $q = $q->where('position_id' , $generate->position_id);
        $q = $q->where('contractor_status' , 1);
        if( $filter == "" ){
            $q = $q->where('year_budget' , $project->year_budget);
        }
        $contractor = $q->wherenotin('contractor_id' , $gen )->get();

        return view('contractor.hire.create')->withProject($project)
                                        ->withContractor($contractor)
                                        ->withGenerate($generate)
                                        ->withFilter($filter);
    }

    public function CreateSave($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $generate = Generate::where('generate_id' , Request::input('generate') )->first();
        if(count($generate) == 0){
            return redirect()->back();
        }

        $generate->register_id = $id;
        $generate->generate_status = 1;
        $generate->save();

        $new = new LogFile;
        $new->loglist_id = 12;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('contractor/hire')->withSuccess("บันทึกจ้างงานเรียบร้อยแล้ว");

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
