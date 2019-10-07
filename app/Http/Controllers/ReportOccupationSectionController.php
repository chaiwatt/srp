<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use PDF;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\ReadinessSection;
use App\Model\ProjectReadiness;
use App\Model\SettingYear;
use App\Model\ParticipateGroup;
use App\Model\ProjectParticipate;
use App\Model\Trainer;
use App\Model\Company;
use App\Model\ProjectReadinessOfficer;

class ReportOccupationSectionController extends Controller
{

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                ->where('department_id',$auth->department_id)
                                ->where('project_type',2)
                                ->get();
        
        $readinesssection = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('department_id',$auth->department_id)
                                ->where('project_type',2)
                                ->where('section_id',$auth->section_id)
                                ->where('completed',1)
                                ->get();
       
        $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
        ->get();

        return view('report.occupation.section.index')->withProject($project)
                                                    ->withReadinesssection($readinesssection)
                                                    ->withParticipategroup($participategroup)
                                                    ->withReadiness($readiness);
    }


    public function ExportSinglePDF($id){
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

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $section = Section::where('section_id', $auth->section_id)->first();

 
        $readinesssection = ReadinessSection::where('readiness_section_id' , $id)->first();                    
        $participate = ProjectParticipate::where('readiness_section_id' , $id)->get();  

        $trainer = Trainer::where('readiness_section_id' , $id)->get();                        
        $company = Company::where('readiness_section_id' , $id)->get();     
        $numofficer = ProjectReadinessOfficer::where('readiness_section_id' , $id)->count(); 

        $header = "สำนักงาน" . $section->section_name;

        $pdf->loadView("report.occupation.section.pdfoccupation" , [ 
            'readinesssection' => $readinesssection , 
            'section' => $section, 
            'participate' => $participate, 
            'setting' => $setting, 
            'header' =>  $header , 
            'trainer' => $trainer , 
            'company' => $company ,
            'numofficer' => $numofficer, 
            
            ]);
        return $pdf->download('occupationreport.pdf');     
        

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
