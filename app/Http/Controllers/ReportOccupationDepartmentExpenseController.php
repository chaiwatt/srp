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

class ReportOccupationDepartmentExpenseController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('department_id', $auth->department_id)
                                    ->where('project_type',2)
                                    ->get();

        return view('occupation.project.department.expense.index')->withProject($project)
                                                    ->withReadiness($readiness);
    }

    public function ExportPDF(){
        if( $this->authdepartment() ){
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
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('department_id', $auth->department_id)
                                    ->where('project_type',2)
                                    ->get();
        $department = Department::where('department_id',$auth->department_id)->first();                         

        $header = $department->department_name ;

        $pdf->loadView("occupation.project.department.expense.pdfexpense" , [ 
                                                'project' => $project , 
                                                'readiness' => $readiness, 
                                                'setting' => $setting, 
                                                'header' =>  $header,
          ])->setPaper('A4', 'landscape');

        return $pdf->download('expensereport.pdf');   
        
    }

    
    public function ExportExcel(){

        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('department_id', $auth->department_id)
                                    ->where('project_type',2)
                                    ->get();

        $summary_array[] = array('วันที่','สำนักงาน','ชื่อโครงการ','เป้าหมายผู้เข้าร่วม','ผู้เข้าร่วมจริง','งบประมาณ','เบิกจ่ายจริง'); 
        if(count($readiness) > 0){
            foreach( $readiness as $item ){

                if ($item->project_status == 1){
                    $summary_array[] = array(
                        'projectdate' => $item->adddate,
                        'sectionname' => $item->sectionname ,
                        'projectname' => $item->project_readiness_name,
                        'target' =>  $item->targetparticipate ,
                        'actual' =>  $item->participate ,
                        'budget' => $item->budget ,
                        'actualexpense' => $item->expense ,
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
