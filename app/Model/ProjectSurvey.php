<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class ProjectSurvey extends Model{    
	
    protected $table = 'tb_project_survey';
    protected $primaryKey = 'project_survey_id';
	public $timestamps = false;

	public function getSurveydatestartthAttribute(){
        return date('d/m/' , strtotime( $this->project_survey_datestart ) ).(date('Y',strtotime($this->project_survey_datestart))+543);
    }

    public function getSurveydateendthAttribute(){
        return date('d/m/' , strtotime( $this->project_survey_dateend ) ).(date('Y',strtotime($this->project_survey_dateend))+543);
    }

    public function getSurveydatestartinputAttribute(){
        return date('d/m/' , strtotime( $this->project_survey_datestart ) ).(date('Y',strtotime($this->project_survey_datestart)));
    }

    public function getSurveydateendinputAttribute(){
        return date('d/m/' , strtotime( $this->project_survey_dateend ) ).(date('Y',strtotime($this->project_survey_dateend)));
    }

    public function getSurveysumamountAttribute(){
        $number = Survey::where('project_survey_id' , $this->project_survey_id)->sum('survey_amount');

        return $number;
    }

    public function getSurveydepartmentcountAttribute(){
        $auth = Auth::user();

        $query = Survey::where('project_id' , $this->project_id)->where('project_survey_id' , $this->project_survey_id)->where('department_id' , $auth->department_id)->groupBy('section_id')->get();

        return count($query);
    }

    public function getSurveysectionsumamountAttribute(){
        $auth = Auth::user();
        $number = Survey::where('project_survey_id' , $this->project_survey_id)->where('section_id' , $auth->section_id)->sum('survey_amount');

        return $number;
    }

}
	