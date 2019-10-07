<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use PDF;
use Request;
use DB;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Quater;
use App\Model\Month;
use App\Model\ProjectReadiness;
use App\Model\ReadinessExpense;
use App\Model\ProjectParticipate;
use App\Model\Department;
use App\Model\ProjectReadinessOfficer;
use App\Model\Trainer;
use App\Model\Section;
use App\Model\PersonalAssessment;
use App\Model\Register;
use App\Model\ParticipateGroup;
use App\Model\TrainingStatus;
use App\Model\FollowerStatus;


class ReportOccupationMainExpenseController extends Controller
{

    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();
        
        $department = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('department_id')
                                    ->get(); 
                                    
        $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();  
                                    
        $readinessexpense = ReadinessExpense::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();                              

        return view('occupation.project.main.expense.index')->withProject($project)
                                                    ->withDepartment($department)
                                                    ->withParticipategroup($participategroup)
                                                    ->withReadinessexpense($readinessexpense)
                                                    ->withReadiness($readiness);
    }

    public function ExportPDF(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();
        
        $department = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('department_id')
                                    ->get(); 
                                    
        $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();  
                                    
        $readinessexpense = ReadinessExpense::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();                       

         $header = "";

        $pdf->loadView("occupation.project.main.expense.pdfexpense" , [ 
                                                'project' => $project , 
                                                'department' => $department, 
                                                'participategroup' => $participategroup, 
                                                'readinessexpense' => $readinessexpense, 
                                                'readiness' => $readiness, 
                                                'setting' => $setting, 
                                                'header' =>  $header,
          ])->setPaper('A4', 'landscape');

        return $pdf->download('expensereport.pdf');   
        
    }

    public function ExportExcel(){

        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();
        
        $department = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('department_id')
                                    ->get(); 
                                    
        $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();  
                                    
        $readinessexpense = ReadinessExpense::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();   

        $summary_array[] = array('สำนักงาน','จำนวนโครงการ','เป้าหมายผู้เข้าร่วม','ผู้เข้าร่วมจริง','งบประมาณ','เบิกจ่ายจริง'); 
        if(count($department) > 0){
            foreach( $department as $item ){
                $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');                                              
                $expense = $readinessexpense->where('department_id', $item->department_id)->sum('cost');      

                if ($item->project_status == 1){
                    $summary_array[] = array(
                        'department' => $item->departmentname,
                        'numproject' => $readiness->count() ,
                        'target' =>  $target ,
                        'actual' =>  $participate ,
                        'budget' => number_format( ($readiness->sum('budget')) , 2 )  ,
                        'actualexpense' => number_format( ($expense) , 2 ) ,
                    );
                }

            }    
        }


        $excelfile = Excel::create("occupationreport", function($excel) use ($summary_array){
            $excel->setTitle("รายการค่าใช้จ่าย");
            $excel->sheet('รายการค่าใช้จ่าย', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  
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
