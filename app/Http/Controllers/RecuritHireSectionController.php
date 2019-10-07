<?php namespace App\Http\Controllers;

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
use App\Model\LogFile;

class RecuritHireSectionController extends Controller{

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();

        $employ = Employ::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->first();
        $generate = Generate::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('generate_category' , 1)
                    ->orderBy('generate_code')->get();

        $allgenerate = Payment::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('budget_id' , 1)
                    ->where('payment_status' , 1)
                    ->groupBy('register_id')
                    ->get();
   
        $section = Generate::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('generate_category' , 1)
                    ->groupBy('section_id')->get();

        $position = Position::where('department_id' , $auth->department_id)
                    ->where('position_status' , 1)
                    ->get();
        
        $payment = Payment::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('budget_id' , 1)
                    ->where('payment_status' , 1)
                    ->get();

        return view('recurit.hire.section.index')->withProject($project)
                    ->withPosition($position)
                    ->withEmploy($employ)
                    ->withSection($section)
                    ->withPayment($payment)
                    ->withAllgenerate($allgenerate)
                    ->withGenerate($generate);
    }

    public function View($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_id' , $id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_category' , 1);
        $generate  = $q->first();

        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลจัดจ้าง");
        }

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('payment_category' , 1);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('generate_code', $generate->generate_code);
        $q = $q->orderBy('payment_month' );
        $payment = $q->get();

        return view('recurit.hire.section.view')->withProject($project)->withPayment($payment);

    }

    public function History($id){
		if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $payment = Payment::where('project_id' , $project->project_id)
                ->where('generate_id' , $id )
                ->where('department_id' , $auth->department_id)
                // ->where('payment_status' , 1)
                ->groupBy('register_id')
                ->get();

        return view('recurit.hire.section.history')->withProject($project)
        ->withPayment($payment);
    }

    public function EditNumMonth($id){
		if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $generate = Generate::where('generate_id' , $id)->first();

        $position = Position::where('position_id' , $generate->position_id)
                    ->first();

        return view('recurit.hire.section.editmonth')
                    ->withPosition($position)
                    ->withGenerate($generate);
    }

    public function EditNumMonthSave($id){
		if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $nummonth = Request::input('number');
        $generate = Generate::where('generate_id' , $id)->first();
        $salary = Position::where('position_id' , $generate->position_id)
        ->first()->position_salary;
        $newallocated = $nummonth * $salary ;

        $payment = Payment::where('generate_id' , $id)
                        ->where('payment_status' , 1)
                        ->sum('payment_salary');

        if($newallocated < $payment){
            return redirect('recurit/hire/section')->withError("จำนวนเงินเบิกจ่ายแล้ว มากกว่าจำนวนเดือนที่กำหนด");
        }else{
            Generate::where('generate_id' , $id)
            ->update([ 
                'generate_allocation' =>  $newallocated, 
                ]);
        return redirect('recurit/hire/section')->withSuccess("แก้ไขจำเดือนเรียบร้อยแล้ว");
        }                        
    }
    

    public function CreateSave($id){
        if( $this->authsection() ){
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
        $new->loglist_id = 41;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/hire/section')->withSuccess("บันทึกจ้างงานเรียบร้อยแล้ว");

    }

    public function Create($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $filter = Request::input('filter')==""?"":Request::input('filter');

        $generate = Generate::where('generate_id' , $id)->where('generate_refund' , 0)->first();
        if(count($generate) == 0){
            return redirect()->back();
        }

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_status' , 1);
        $gen = $q->select('register_id')->get();

        $q = Register::query();
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('register_type' , 1);
        $q = $q->where('position_id' , $generate->position_id);
        $q = $q->where('register_status' , 1);
        if( $filter == "" ){
            $q = $q->where('year_budget' , $project->year_budget);
        }
        $register = $q->wherenotin('register_id' , $gen )->get();

        return view('recurit.hire.section.create')->withProject($project)->withRegister($register)->withGenerate($generate)->withFilter($filter);
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


