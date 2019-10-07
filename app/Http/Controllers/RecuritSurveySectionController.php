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
use App\Model\Surveyhost;
use App\Model\LogFile;

class RecuritSurveySectionController extends Controller{

    public function CreateSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $projectsurvey = ProjectSurvey::where('project_survey_id' , Request::input('id') )->where('department_id' , $auth->department_id)->first();
        if(count($projectsurvey) == 0){
            return redirect()->back()->withError("ไม่พบรายการสำรวจ");
        }

        $surveyhost = Surveyhost::where('project_survey_id' , Request::input('id'))
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->first();
        if(!empty($surveyhost)){
            Surveyhost::where('project_survey_id' , Request::input('id') )
            ->where('department_id' , $auth->department_id)
            ->where('section_id' , $auth->section_id)
            ->update([ 
                'surveyhost_detail' =>  Request::input('note'), 
                ]);
        }else{
            $new = new Surveyhost;
            $new->project_id = $project->project_id;
            $new->project_survey_id = $projectsurvey->project_survey_id;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
            $new->surveyhost_detail = Request::input('note');
            $new->save();
        }


        $position = Position::where('department_id' , $auth->department_id)->get();

        if( count($position) > 0 ){
            foreach( $position as $item ){
            	$survey = Survey::where('project_survey_id' , $projectsurvey->project_survey_id)->where('section_id' , $auth->section_id)->where('position_id' , $item->position_id)->first();
            	if(count($survey) > 0){
            		$survey->survey_amount = Request::input('number')[ $item->position_id ];
            		$survey->save();
            	}
            	else{
            		$new = new Survey;
                    $new->project_id = $project->project_id;
                    $new->year_budget = $project->year_budget;
                    $new->project_survey_id = $projectsurvey->project_survey_id;
                    $new->position_id = $item->position_id;
                    $new->survey_amount = Request::input('number')[ $item->position_id ];
                    $new->department_id = $auth->department_id;
                    $new->section_id = $auth->section_id;
                    $new->user_id = $auth->user_id;
                    $new->save();
            	}
            }
        }

        $new = new LogFile;
        $new->loglist_id = 52;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect("recurit/survey/section")->withSuccess("บันทึกรายการเรียบร้อยแล้ว");
    }

    public function Create($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();

        $projectsurvey = ProjectSurvey::where('project_survey_id' , $id)->where('department_id' , $auth->department_id)->first();
        if( count($projectsurvey) == 0 ){
            return redirect()->back()->withError("ไม่พบรายการสำรวจ");
        }
        $position = Position::where('department_id' , $auth->department_id)->get();
        $survey = Survey::where('project_survey_id' , $id)->where('section_id',$auth->section_id)->get();
        $surveyhost = Surveyhost::where('project_survey_id' , $id)->where('section_id',$auth->section_id)->first();
 
        return view('recurit.survey.section.create')->withProjectsurvey($projectsurvey)
                                                ->withSurvey($survey)
                                                ->withSurveyhost($surveyhost)
                                                ->withPosition($position);
    }

    public function Index(){
    	if( $this->authsection() ){
            return redirect('logout');
        }
        
    	$auth = Auth::user();

    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();

    	$q = ProjectSurvey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $projectsurvey = $q->get();

        $position = Position::where('department_id' , $auth->department_id)->get();
        $survey = Survey::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('section_id' , $auth->section_id)->get();

        $q = ProjectSurvey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $surveysum = $q->get();

    	return view('recurit.survey.section.index')->withProject($project)->withSurveysum($surveysum)->withProjectsurvey($projectsurvey)->withPosition($position)->withSurvey($survey);

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


