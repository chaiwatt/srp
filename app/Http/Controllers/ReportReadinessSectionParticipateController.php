<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use PDF;
use Excel;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\ReadinessSection;
use App\Model\ProjectReadiness;
use App\Model\SettingYear;
use App\Model\ParticipateGroup;
use App\Model\TrainingStatus;
use App\Model\Register;
use App\Model\FollowerStatus;
use App\Model\PersonalAssessment;


class ReportReadinessSectionParticipateController extends Controller
{
    public function Index($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readinesssection = ReadinessSection::where('readiness_section_id',$id)->first();  
        $participategroup = ParticipateGroup::where('readiness_section_id',$id)->get();  
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        $register = Register::where('project_id',$project->project_id)->get();
        $status = TrainingStatus::get();
        $followerstatus = FollowerStatus::get();


        return view('report.readiness.section.participate.index')->withProject($project)
                        ->withReadinesssection($readinesssection)
                        ->withParticipategroup($participategroup)
                        ->withSetting($setting)
                        ->withFollowerstatus($followerstatus)
                        ->withStatus($status)
                        ->withPersonalassessment($personalassessment)
                        ->withRegister($register);
    }


    public function ExportPDF($id){
        if( $this->authsection() ){
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
        $readinesssection = ReadinessSection::where('readiness_section_id',$id)->first();  
        $participategroup = ParticipateGroup::where('readiness_section_id',$id)->get();  
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        $register = Register::where('project_id',$project->project_id)->get();
        $status = TrainingStatus::get();
        $followerstatus = FollowerStatus::get();
        $section = Section::where('section_id',$readinesssection->section_id)->first();

        $header =  " วันที่ " . $readinesssection->adddate . " " . $section->section_name ;

      $pdf->loadView("report.readiness.section.participate.pdfparticipate" , [ 
                                                'project' => $project , 
                                                'readinesssection' => $readinesssection, 
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

        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();      
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readinesssection = ReadinessSection::where('readiness_section_id',$id)->first();  
        $participategroup = ParticipateGroup::where('readiness_section_id',$id)->get();  
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        $register = Register::where('project_id',$project->project_id)->get();
        $status = TrainingStatus::get();
        $followerstatus = FollowerStatus::get();

        $summary_array[] = array('ชื่อ-สกุล','เลขบัตรประชาชน','ที่อยู่/เบอร์โทรศัพท์','จบหลักสูตร','ผลการติดตาม','ข้อเสนอแนะ'); 
        if(count($readinesssection) > 0){
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

        $excelfile = Excel::create("readinessreport", function($excel) use ($summary_array){
            $excel->setTitle("การฝึกอบรมเตรียมความพร้อม");
            $excel->sheet('การฝึกอบรมเตรียมความพร้อม', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  
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
