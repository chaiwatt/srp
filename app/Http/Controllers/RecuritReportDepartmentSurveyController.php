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

class RecuritReportDepartmentSurveyController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $numsection = Survey::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->groupBy('section_id')
                        ->get();
        $surveylist = Survey::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->get();
        $position = Position::where('department_id' , $auth->department_id)->get();
        $projectsurvey = ProjectSurvey::where('project_id',$project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->get();

        return view('recurit.report.department.survey.index')->withProject($project)
                        ->withSetting($setting)
                        ->withNumsection($numsection)
                        ->withSurveylist($surveylist)
                        ->withProjectsurvey($projectsurvey)
                        ->withPosition($position);
    }

    public function ExportPDF(){
            if( $this->authdepartment() ){
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
            $numsection = Survey::where('project_id',$project->project_id)
                            ->where('department_id',$auth->department_id)
                            ->groupBy('section_id')
                            ->get();
            $surveylist = Survey::where('project_id',$project->project_id)
                            ->where('department_id',$auth->department_id)
                            ->get();
            $position = Position::where('department_id' , $auth->department_id)->get();
            $projectsurvey = ProjectSurvey::where('project_id',$project->project_id)
                                        ->where('department_id' , $auth->department_id)
                                        ->get();
            $department = Department::where('department_id',$auth->department_id)->first();                            
    
            $header = "สำนักงาน" . $department->department_name;
            $pdf->loadView("recurit.report.department.survey.pdfsurvey" , [ 
                                'numsection' => $numsection , 
                                'surveylist' => $surveylist, 
                                'position' => $position, 
                                'projectsurvey' => $projectsurvey, 
                                'setting' => $setting, 
                                'header' =>  $header 
                    ])->setPaper('a4', 'landscape');
            return $pdf->download('surveyreport.pdf');                           

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
