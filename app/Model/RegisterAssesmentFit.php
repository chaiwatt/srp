<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Section;
use App\Model\Department;

class RegisterAssesmentFit extends Model
{
    protected $table = 'tb_register_assesment_fit';
    protected $primaryKey = 'register_assesment_fit_id';

    public function getDateassessAttribute(){
        return date('d/m/' , strtotime( $this->created_at ) ).(date('Y',strtotime($this->created_at))+543);
    }

    public function getCurrentoccupationAttribute(){
		if($this->currentoccupationfit == 1){
			return "ตรง";
		}elseif ($this->currentoccupationfit == 0){
			return "ไม่ตรง";
		}
    }

    public function getRegisteroccupationneedAttribute(){
		if($this->registeroccupationneedfit == 1){
			return "ตรง";
		}elseif ($this->registeroccupationneedfit == 0){
			return "ไม่ตรง";
		}
    }

    public function getRegistereducationneedAttribute(){
		if($this->registereducationneedfit == 1){
			return "ตรง";
		}elseif ($this->registereducationneedfit == 0){
			return "ไม่ตรง";
		}
    }

    public function getRegisteroccupationtrainAttribute(){
		if($this->registeroccupationtrainfit == 1){
			return "ตรง";
		}elseif ($this->registeroccupationtrainfit == 0){
			return "ไม่ตรง";
		}
    }

    public function getRegistereducationtrainAttribute(){
		if($this->registereducationtrainfit == 1){
			return "ตรง";
		}elseif ($this->registereducationtrainfit == 0){
			return "ไม่ตรง";
		}
    }    

    public function getJobassignmentAttribute(){
		if($this->jobassignmentfit == 1){
			return "ตรง";
		}elseif ($this->jobassignmentfit == 0){
			return "ไม่ตรง";
		}
    } 
    public function getSectionnameAttribute(){
        $name = "";
        $query = Section::where('section_id' , $this->section_id)->first();
        if(count($query ) > 0){
            $name = $query->section_name;
        }
        return $name;
    }
    public function getDepartmentnameAttribute(){
        $name = "";
        $query = Department::where('department_id' , $this->department_id)->first();
        if(count($query) > 0){
            $name = $query->department_name;
        }
        return $name;
    }

}
