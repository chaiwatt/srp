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

class ReportOccupationDepartmentParticipateController extends Controller
{
    public function Index($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();      
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('project_readiness_id',$id)->first();  
        $participategroup = ParticipateGroup::where('project_readiness_id',$id)->get();  
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        $register = Register::where('project_id',$project->project_id)->get();
        $status = TrainingStatus::get();
        $followerstatus = FollowerStatus::get();

        return view('report.occupation.department.participate.index')->withProject($project)
                    ->withReadiness($readiness)
                    ->withParticipategroup($participategroup)
                    ->withSetting($setting)
                    ->withFollowerstatus($followerstatus)
                    ->withStatus($status)
                    ->withPersonalassessment($personalassessment)
                    ->withRegister($register);
    }

    public function ExportPDF($id){
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
        $readiness = ProjectReadiness::where('project_readiness_id',$id)->first();  
        $participategroup = ParticipateGroup::where('project_readiness_id',$id)->get();  
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        $register = Register::where('project_id',$project->project_id)->get();
        $status = TrainingStatus::get();
        $followerstatus = FollowerStatus::get();
        $sectoin = Section::where('section_id',$readiness->section_id)->first();

        $header =  " วันที่ " . $readiness->adddate . " " . $sectoin->section_name ;

      $pdf->loadView("report.occupation.department.participate.pdfparticipate" , [ 
                                                'project' => $project , 
                                                'readiness' => $readiness, 
                                                'participategroup' => $participategroup, 
                                                'followerstatus' => $followerstatus, 
                                                'status' => $status, 
                                                'personalassessment' => $personalassessment, 
                                                'register' => $register, 
                                                'setting' => $setting, 
                                                'header' =>  $header 
          ])->setPaper('A4', 'landscape');

        return $pdf->download('readinessreport.pdf');   
        
    }

    public function ExportExcel($id){

        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();      
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('project_readiness_id',$id)->first();  
        $participategroup = ParticipateGroup::where('project_readiness_id',$id)->get();  
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        $register = Register::where('project_id',$project->project_id)->get();
        $status = TrainingStatus::get();
        $followerstatus = FollowerStatus::get();

        $summary_array[] = array('ชื่อ-สกุล','เลขบัตรประชาชน','ที่อยู่/เบอร์โทรศัพท์','จบหลักสูตร','ผลการติดตาม','ผลการติดตาม'); 
        if(count($readiness) > 0){
            foreach( $participategroup as $item ){
                $_register = $register->where('register_id',$item->register_id)->first();
                $check = $participategroup->where('register_id',$item->register_id)->first();
                if(!empty($check)){
                    $_status = $status->where('trainning_status_id',$check->trainning_status_id)->first();
                }
                $check2 = $personalassessment->where('register_id',$item->register_id)->first();
                if(!empty($check2)){
                    $suggest = $check2->othernote;
                    $check3 = $followerstatus->where('follower_status_id',$check2->follower_status_id)->first();
                    if(!empty($check3)){
                        $_assessment = $check3->follower_status_name ;
                    }else{
                        $_assessment ="ไม่พบข้อมูล";
                    }
                }else{
                    $suggest="";
                }
                if (!empty($_register)){
                    $summary_array[] = array(
                        'name' => $_register->prefixname . $_register->name . " " . $_register->lastname  ,
                        'personname' => $_register->person_id,
                        'address' => "เลขที่ " . $_register->address .  " หมู่ ". $_register->mood . " ซอย" . $_register->soi . " ตำบล" . $_register->districtname . " อำเภอ" . $_register->amphurname . " จังหวัด" . $_register->provincename . " โทรศัพท์ " . $_register->phone ,
                        'status' =>  $_status->trainning_status_name ,
                        'assessment' =>  $_assessment ,
                        'suggest' =>  $suggest ,
                    );
                }

            }    
        }

        $excelfile = Excel::create("occupationreport", function($excel) use ($summary_array){
            $excel->setTitle("การฝึกอบรมวิชาชีพ");
            $excel->sheet('การฝึกอบรมวิชาชีพ', function($sheet) use ($summary_array){
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
