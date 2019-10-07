<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Register;
use App\Model\Prefix;
use App\Model\Score;
use App\Model\FollowerStatus;
use App\Model\NeedSupport;
use App\Model\FamilyRelation;
use App\Model\EnoughIncome;
use App\Model\Occupation;
use App\Model\ProjectAssesment;
use App\Model\Department;


class PersonalAssessment extends Model
{
    protected $table = 'tb_personal_assessment';
    protected $primaryKey = 'personal_assessment_id';

   public function getPrefixnameAttribute(){
		$prefix = Prefix::where('prefix_id' , $this->prefix_id)->first();
		return $prefix;
    }

    public function getRegisternameAttribute(){
    	$prefix = $this->getPrefixnameAttribute();
    	$register = Register::where('register_id' , $this->register_id)->first();
		return $register->prefixname . $register->name . " " . $register->lastname;
    }

    public function getRegisterpersonidAttribute(){
        $register = Register::where('register_id' , $this->register_id)->first();
        return $register->person_id;
    }

    public function getRegistersectionnameAttribute(){
        $register = Register::where('register_id' , $this->register_id)->first();
        return $register->sectionname;
    }

    public function getProjectassessmentnameAttribute(){
        $assessment = ProjectAssesment::where('project_assesment_id' , $this->project_assesment_id)->first();
        return $assessment->assesment_name;
    }

    public function getScorenameAttribute(){
    	$score = Score::where('score_id' , $this->score_id)->first();
        if($this->score_id == 0){
            return "ไม่ประเมิน";
        }else{
            return $score->score_name;
        }
		
    }

    public function getFollowerstatusnameAttribute(){
    	$followerStatus = FollowerStatus::where('follower_status_id' , $this->follower_status_id)->first();
		return $followerStatus->follower_status_name;
    }

     public function getNeedsupportnameAttribute(){
    	$needsupport = NeedSupport::where('needsupport_id' , $this->needsupport_id)->first();
		return $needsupport->needsupport_name;
    }   

    public function getFamilyrelationnameAttribute(){
    	$familyrelation = FamilyRelation::where('familyrelation_id' , $this->familyrelation_id)->first();
		return $familyrelation->familyrelation_name;
    }  

    public function getEnoughincomenameAttribute(){
    	$enoughincome = EnoughIncome::where('enoughincome_id' , $this->enoughincome_id)->first();
		return $enoughincome->enoughincome_name;
    }

    public function getOccupationnameAttribute(){
    	$occupation = Occupation::where('occupation_id' , $this->occupation_id)->first();
		return $occupation->occupation_name;
    }

    public function getDepartmentnameAttribute(){
        $department = Department::where('department_id' , $this->department_id)->first();
        return $department->department_name;
    }

}

