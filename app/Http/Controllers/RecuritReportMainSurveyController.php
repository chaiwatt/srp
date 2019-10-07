<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use PDF;

use App\Model\Survey;
use App\Model\ProjectSurvey;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Position;
use App\Model\Department;

class RecuritReportMainSurveyController extends Controller
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
        $numdepartment = Survey::where('project_id',$project->project_id)
                        ->groupBy('department_id')
                        ->get();
        $surveylist = Survey::where('project_id',$project->project_id)
                        ->get();
        $position = Position::get();
        $projectsurvey = ProjectSurvey::where('project_id',$project->project_id)
                                    ->get();

        return view('recurit.report.main.survey.index')->withProject($project)
                        ->withSetting($setting)
                        ->withNumdepartment($numdepartment)
                        ->withSurveylist($surveylist)
                        ->withProjectsurvey($projectsurvey)
                        ->withPosition($position);

    }

    public function ExportPDF(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $numdepartment = Survey::where('project_id',$project->project_id)
                        ->groupBy('department_id')
                        ->get();
        $surveylist = Survey::where('project_id',$project->project_id)
                        ->get();
        $position = Position::get();
        $projectsurvey = ProjectSurvey::where('project_id',$project->project_id)
                                    ->get();                        

        $header = "";

        $pdf->loadView("recurit.report.main.survey.pdfsurvey" , [ 
                            'numdepartment' => $numdepartment , 
                            'surveylist' => $surveylist, 
                            'position' => $position, 
                            'projectsurvey' => $projectsurvey, 
                            'setting' => $setting, 
                            'header' =>  $header 
                ]);
        return $pdf->download('surveyreport.pdf');                           

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
