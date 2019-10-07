<?php

namespace App\Http\Controllers;


use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\Department;
use App\Model\Employ;
use App\Model\EmployPosition;
use App\Model\Section;
use App\Model\Position;
use App\Model\Generate;
use App\Model\Register;
use App\Model\Payment;

class RecuritHireSectionViewController extends Controller
{
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();

        $employ = Employ::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->first();
        $generate = Generate::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)
                ->where('section_id' , $auth->section_id)
                ->where('generate_category' , 1)      
                ->groupBy('generate_code')->get();

        // return $generate ;
        $section = Generate::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('section_id' , $auth->section_id)->where('generate_category' , 1)->groupBy('section_id')->get();

        $position = Position::where('department_id' , $auth->department_id)->where('position_status' , 1)->get();
        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('payment_status' , 1);
        $payment = $q->get();

        return view('recurit.hire.section.view.index')->withProject($project)->withPosition($position)->withEmploy($employ)->withSection($section)->withPayment($payment)->withGenerate($generate);
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
