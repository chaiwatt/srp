<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Section;
use App\Model\Department;
use App\Model\ProjectReadiness;


class ReadinessSection extends Model
{
    protected $table = 'tb_readiness_section';
    protected $primaryKey = 'readiness_section_id';

    public function getProjectStatusAttribute(){
		if($this->status == 0){
			return "ไม่อนุมัติ";
		}else{
			return "อนุมัติ";
		}
    }
    public function getDepartmentnameAttribute(){
        $name = "";
        $query = Department::where('department_id' , $this->department_id)->first();
        if(count($query) > 0){
            $name = $query->department_name;
        }
        return $name;
    }
    public function getSectionnameAttribute(){
		$section = Section::where('section_id' , $this->section_id)->first();
        return $section->section_name;
	}
	public function getSurveyDateAttribute(){
        // return date('d/m/' , strtotime( $this->starthiredate ) ).(date('Y',strtotime($this->starthiredate))+543);
        return date('d/m/' , strtotime( $this->created_at ) ).(date('Y',strtotime($this->created_at))+543);
    }
    public function getProjectReadinessNameAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return $projectreadiness->project_readiness_name;
    }

    public function getProjectReadinessTargetAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return $projectreadiness->targetparticipate;
    }

    public function getProjectCompletedAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return $projectreadiness->completed;
    }
    public function getProjectBudgetAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return $projectreadiness->budget;
    }
    public function getProjectDescAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return $projectreadiness->project_readiness_desc;
    }

    public function getAdddateAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return date('d/m/' , strtotime( $projectreadiness->created_at ) ).(date('Y',strtotime($projectreadiness->created_at))+543);;
    }

    public function getAdddateEngAttribute(){
        $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
        return date('d/m/' , strtotime( $projectreadiness->created_at ) ).(date('Y',strtotime($projectreadiness->created_at)));
    }

    public function getHeldDateInputAttribute(){
        if ($this->helddate == "0000-00-00"){
              $projectreadiness = ProjectReadiness::where('project_readiness_id' , $this->project_readiness_id)->first();
                return date('d/m/' , strtotime( $projectreadiness->created_at ) ).(date('Y',strtotime($projectreadiness->created_at)));
        }else{
            return date('d/m/' , strtotime( $this->helddate ) ).(date('Y',strtotime($this->helddate)));;
        }
    }

    public function getProjectCompleteAttribute(){
        if($this->completed == 0){
            return "ยังไม่ได้บันทึก";
        }else{
            return "จบโครงการ";
        }
    }

    public function getRefundStatusDeptAttribute(){
        if($this->refund_status == 0){
            return "รอการยืนยัน";
        }else{
            return "ยันยันการคืนเงินแล้ว";
        }
    }

    public function getConvertcostAttribute(){ 
         $number =  $this->actualexpense;
         $txtnum1 = 
         array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
         $txtnum2 = 
         array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
         $number = str_replace(",","",$number); 
         $number = str_replace(" ","",$number); 
         $number = str_replace("บาท","",$number); 
         $number = explode(".",$number); 
         if(sizeof($number)>2){ 
         return 'ทศนิยมหลายตัวนะจ๊ะ'; 
         exit; 
         } 
         $strlen = strlen($number[0]); 
         $convert = ''; 
         for($i=0;$i<$strlen;$i++){ 
         $n = substr($number[0], $i,1); 
         if($n!=0){ 
         if($i==($strlen-1) AND $n==1){ $convert .= 
         'เอ็ด'; } 
         elseif($i==($strlen-2) AND $n==2){ 
         $convert .= 'ยี่'; } 
         elseif($i==($strlen-2) AND $n==1){ 
         $convert .= ''; } 
         else{ $convert .= $txtnum1[$n]; } 
         $convert .= $txtnum2[$strlen-$i-1]; 
         } 
         } 
         $convert .= 'บาท'; 
         if($number[1]=='0' OR $number[1]=='00' OR 
         $number[1]==''){ 
         $convert .= 'ถ้วน'; 
         }else{ 
         $strlen = strlen($number[1]); 
         for($i=0;$i<$strlen;$i++){ 
         $n = substr($number[1], $i,1); 
         if($n!=0){ 
         if($i==($strlen-1) AND $n==1){$convert 
         .= 'เอ็ด';} 
         elseif($i==($strlen-2) AND 
         $n==2){$convert .= 'ยี่';} 
         elseif($i==($strlen-2) AND 
         $n==1){$convert .= '';} 
         else{ $convert .= $txtnum1[$n];} 
         $convert .= $txtnum2[$strlen-$i-1]; 
         } 
         } 
         $convert .= 'สตางค์'; 
         } 
         return $convert; 
     } 

}
