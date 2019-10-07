<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\Assessment;

class RegisterAssessment extends Model{    
	
    protected $table = 'tb_register_assessment';
    protected $primaryKey = 'register_assessment_id';

    public function getAssessmentnameAttribute(){
    	$assessment =Assessment::where('assessment_id', $this->assessment_id)->first();
		return $assessment->assessment_name;
    }

}
