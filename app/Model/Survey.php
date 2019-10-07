<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\Surveyhost;

class Survey extends Model{    
	
    protected $table = 'tb_survey';
    protected $primaryKey = 'survey_id';

	public function getDepartmentnameAttribute(){
		$name = "";
		$query = Department::where('department_id' , $this->department_id)->first();
		if(count($query ) > 0){
			$name = $query->department_name;
		}
		return $name;
    }

    public function getSectionnameAttribute(){
		$name = "";
		$query = Section::where('section_id' , $this->section_id)->first();
		if(count($query ) > 0){
			$name = $query->section_name;
		}
		return $name;
    }

   	public function getPositionsumAttribute(){
		$query = Survey::where('project_id' , $this->project_id)->where('department_id' , $this->department_id)->where('section_id' , $this->section_id)->get();

		return $query;
    }

    public function getSurveyhostnameAttribute(){
		$query = Surveyhost::where('section_id' , $this->section_id)
				->where('department_id' , $this->department_id)
				->where('project_survey_id',$this->project_survey_id)
				->first();
		if(!empty($query)){
			return $query->surveyhost_detail;
		}else{
			return "";
		}
		
    }

}
