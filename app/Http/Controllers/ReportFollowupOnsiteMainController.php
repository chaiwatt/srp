<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use PDF;
use Request;
use DB;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\FollowupSection;
use App\Model\ParticipateGroup;
use App\Model\Province;
use App\Model\PersonalAssessment;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\ProjectParticipate;
use App\Model\Department;
use App\Model\ProjectFollowup;
use App\Model\Generate;
use App\Model\FollowupInterview;
use App\Model\FollowupRegister;

class ReportFollowupOnsiteMainController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)->get();

        return view('report.followup.main.onsite.index')->withProject($project)
                                ->withProjectfollowup($projectfollowup);
    }


    public function View($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();
        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
        $generate = Generate::where('project_id',$project->project_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->get();
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

       $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();   
       $projectreadiness =ProjectReadiness::where('project_id',$project->project_id)->get();  
       $followupinterview = FollowupInterview::where('project_id',$project->project_id)
                            ->where('project_followup_id',$id)
                            ->get();
        $followupregister = FollowupRegister::get();

        return view('report.followup.main.onsite.view')->withProject($project)
                                ->withSelectedprovince($selectedprovince)
                                ->withFollowupsection($followupsection)
                                ->withGenerate($generate)
                                ->withGenerate($generate)
                                ->withMapcode($mapcode)                                
                                ->withFollowupregister($followupregister)         
                                ->withFollowupinterview($followupinterview)
                                ->withProjectreadiness($projectreadiness)
                                ->withProjectfollowup($projectfollowup);
    }

   public function ExportPDF($id){

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $auth = Auth::user();   
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();
        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
        $generate = Generate::where('project_id',$project->project_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->get();
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

        
        $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();   
        $projectreadiness =ProjectReadiness::where('project_id',$project->project_id)->get();  
        $header = "";  
        if($auth->permission == 2){
            $department = Department::where('department_id',$auth->department_id)->first();
            $header = "สำนักงาน" . $department->department_name;  
        }
        $followupinterview = FollowupInterview::where('project_id',$project->project_id)
        ->where('project_followup_id',$id)
        ->get();
        $followupregister = FollowupRegister::get();

        // return $followupsection;

        $pdf->loadView("report.followup.main.onsite.pdfonsite" , [ 
                            'project' => $project , 
                            'selectedprovince' => $selectedprovince, 
                            'followupsection' => $followupsection,
                            'generate' => $generate,
                            'projectreadiness' => $projectreadiness,
                            'projectfollowup' => $projectfollowup,
                            'mapcode' => $mapcode,
                            'followupregister' => $followupregister,
                            'followupinterview' => $followupinterview,
                            'setting' => $setting, 
                            'header' =>  $header 
            ])->setPaper('a4', 'landscape');
        return $pdf->download('readinessreport.pdf');   
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
