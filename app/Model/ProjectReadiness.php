<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ReadinessExpense;
use App\Model\ProjectParticipate;
use App\Model\Section;
use App\Model\Department;

class ProjectReadiness extends Model
{
    protected $table = 'tb_project_readiness';
    protected $primaryKey = 'project_readiness_id';

    public function getAdddateAttribute(){
        return date('d/m/' , strtotime( $this->projectdate ) ).(date('Y',strtotime($this->projectdate))+543);
    }

    public function getInputadddateAttribute(){
        return date('d/m/' , strtotime( $this->projectdate ) ).(date('Y',strtotime($this->projectdate)));
    }

    public function getExpenseAttribute(){
        $readinessexpense = ReadinessExpense::where('project_readiness_id' , $this->project_readiness_id)
                                        ->first();
        if( count($readinessexpense) > 0){
            return $readinessexpense->cost;
        }else{
            return "-";
        }
    }

    public function getParticipateAttribute(){
        $participate = ProjectParticipate::where('project_readiness_id' , $this->project_readiness_id)
                                        ->get();
        if( count($participate) > 0){
            return $participate->sum('participate_num');
        }else{
            return "-";
        }
    }

    public function getSectionnameAttribute(){

        if($this->section_id !=0 ){
            $section = Section::where('section_id' , $this->section_id)->first();
            return $section->section_name;
        }else{
            return "-";
        }
        
    }

    public function getDepartmentnameAttribute(){
        $department = Department::where('department_id' , $this->department_id)->first();
        return $department->department_name;
    }


}
