<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Survey;
use App\Model\ProjectSurvey;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Position;
use App\Model\LogFile;

class RecuritSurveyController extends Controller{

    public function EditSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = ProjectSurvey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('project_survey_id' , Request::input('id'));
        $survey = $q->first();

        if( Request::input('date_start') == "" ){
            return redirect()->back()->withError("กรุณากรอกวันที่เริ่มโครงการ");
        }

        if( Request::input('date_end') == "" ){
            return redirect()->back()->withError("กรุณากรอกวันสิ้นสุดโครงการ");
        }

        if( $survey->surveydatestartinput != Request::input('date_start') ){
            $date1 = explode("/", Request::input('date_start'));
            $date_start = ($date1[2]-543)."-".$date1[1]."-".$date1[0];
        }
        else{
           $date_start = $survey->project_survey_datestart;
        }

        if( $survey->surveydateendinput != Request::input('date_end') ){
            $date1 = explode("/", Request::input('date_end'));
            $date_end = ($date1[2]-543)."-".$date1[1]."-".$date1[0];
        }
        else{
           $date_end = $survey->project_survey_dateend;
        }

        $survey->project_survey_name = Request::input('name');
        $survey->project_survey_datestart = $date_start;
        $survey->project_survey_dateend = $date_end;
        $survey->save();

        $new = new LogFile;
        $new->loglist_id = 51;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect("recurit/survey");
    }

    public function Edit($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = ProjectSurvey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('project_survey_id' , $id);
        $survey = $q->first();

        return view('recurit.survey.edit')->withProject($project)->withSurvey($survey);

    }

	public function CreateSave(){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();

		if( Request::input('date_start') == "" ){
            return redirect()->back()->withError("ไม่สามารถเพิ่มโครงการได้ กรุณาใส่วันเริ่มโครงการ");
        }
        if( Request::input('date_end') == "" ){
            return redirect()->back()->withError("ไม่สามารถเพิ่มโครงการได้ กรุณาใส่วันสิ้นสุดโครงการ");
        }

        $date = explode("/", Request::input('date_start'));
        $date_start = ($date[2]-543)."-".$date[1]."-".$date[0];
        $date = explode("/", Request::input('date_end'));
        $date_end = ($date[2]-543)."-".$date[1]."-".$date[0];

        $new = new ProjectSurvey;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->project_survey_name = Request::input('name');
        $new->project_survey_datestart = $date_start;
        $new->project_survey_dateend = $date_end;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 50;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect("recurit/survey");
	}

	public function Create(){
		return view('recurit.survey.create');
	}

    public function View($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $surveygroup = Survey::where('project_id' , $project->project_id)->where('project_survey_id' , $id)->where('department_id' , $auth->department_id)->groupBy('section_id')->get();
        $survey = Survey::where('project_id' , $project->project_id)->where('project_survey_id' , $id)->where('department_id' , $auth->department_id)->get();
        $position = Position::where('department_id' , $auth->department_id)->get();
        return view('recurit.survey.view')->withProject($project)->withSurveygroup($surveygroup)->withSurvey($survey)->withPosition($position);
    }

    public function Index(){
    	if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();

    	$projectsurvey = ProjectSurvey::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->get();
        $position = Position::where('department_id' , $auth->department_id )->get();
        $surveygroup = Survey::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->groupBy('section_id')->get();
        
    	return view('recurit.survey.index')->withProject($project)->withProjectsurvey($projectsurvey)->withPosition($position)->withSurveygroup($surveygroup);

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
        $department = Department::where('department_id', $auth->department_id)->first();   

            $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where('department_id', $auth->department_id)
                                    ->get();  
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where('department_id', $auth->department_id)
                                    ->get();  

           $header = "สำนักงาน" . $department->department_name;
           $pdf->loadView("report.readiness.department.pdfreadiness" , [ 'readiness' => $readiness , 'participate' => $participate, 'setting' => $setting, 'header' =>  $header ]);
           return $pdf->download('readinessreport.pdf');                         

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


