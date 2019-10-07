<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use Excel;
use PDF;

use App\Model\PersonalAssessment;
use App\Model\ProjectAssesment;
use App\Model\Project;
use App\Model\SettingYear;
use App\Model\Score;
use App\Model\FollowerStatus;
use App\Model\NeedSupport;
use App\Model\FamilyRelation;
use App\Model\EnoughIncome;
use App\Model\Occupation;
use App\Model\Register;
use App\Model\Generate;
use App\Model\Section;


class ReportAssessmentSectionController extends Controller
{
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assesment = ProjectAssesment::where('project_id',$project->project_id)
                                    ->where('department_id',$auth->department_id)
                                    ->where('section_id',$auth->section_id)
                                    ->get();
        $personalassesment = PersonalAssessment::where('project_id',$project->project_id)
                                    ->where('department_id',$auth->department_id)
                                    ->where('section_id',$auth->section_id)
                                    ->get();

        return view('report.assessment.section.index')
                ->withAssesment($assesment)
                ->withProject($project)
                ->withPersonalassesment($personalassesment);
    }
    public function View($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $assessee = PersonalAssessment::where('project_assesment_id', $id)->get();
        $assessment = ProjectAssesment::where('project_assesment_id', $id)->first();


        return view('report.assessment.section.view')->withAssessee($assessee)
        ->withProject($project)
        ->withAssessment($assessment);
    }

    public function ExportPDF($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        if( $this->authsection() ){
            return redirect('logout');
        }
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $section = Section::where('section_id',$auth->section_id)->first();

        $assessee = PersonalAssessment::where('project_assesment_id', $id)->get();
        $assessment = ProjectAssesment::where('project_assesment_id', $id)->first();
            
        $header = $section->section_name;             

        $pdf->loadView("report.assessment.section.pdfassessment" , [ 
                            'assessee' => $assessee , 
                            'project' => $project ,
                            'assessment' => $assessment, 
                            'setting' => $setting, 
                            'header' =>  $header 
            ])->setPaper('a4', 'landscape');
        return $pdf->download('assessmentreport.pdf');   
    }  
  
    public function ExportExcel($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $section = Section::where('section_id',$auth->section_id)->first();

        $assessee = PersonalAssessment::where('project_assesment_id', $id)->get();
        $assessment = ProjectAssesment::where('project_assesment_id', $id)->first();

        $summary_array[] = array('ชื่อ-สกุล','เลขที่บัตรประชาชน','ผลการประเมิน','การติดตาม','ต้องการสนับสนุน','ความสัมพันธ์ในครอบครัว','การมีรายได้','การมีอาชีพ'); 
        if(count($assessee) > 0){
            foreach( $assessee as $item ){
                $summary_array[] = array(
                    'name' => $item->registername,
                    'personid' => $item->registerpersonid ,
                    'result' => $item->scorename ,
                    'followup' => $item->followerstatusname  ,
                    'needhelp' => $item->needsupportname . " ". $item->needsupport_detail,
                    'familyrelation' => $item->familyrelationname . " " .  $item->familyrelation_detail,
                    'enoughincome' =>  $item->enoughincomename ,
                    'hasoccupation' =>  $item->occupationname . " " . $item->occupation_detail  ,
                );
            }    
        }

        $excelfile = Excel::create("assessmentreport", function($excel) use ($summary_array){
            $excel->setTitle("การประเมิน");
            $excel->sheet('การประเมิน', function($sheet) use ($summary_array){
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
