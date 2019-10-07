<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Refund extends Model{    
	
    protected $table = 'tb_refund';
    protected $primaryKey = 'refund_id';
	  public $timestamps = true;

	public function getDepartmentnameAttribute(){
		$name = "";
		$department = Department::where('department_id' , $this->department_id)->first();
		if(count($department) > 0){
			$name = $department->department_name;
		}

		return $name;
    }

    public function getSectionnameAttribute(){
		$name = "";
		$query = Section::where('section_id' , $this->section_id)->first();
		if(count($query) > 0){
			$name = $query->section_name;
		}

		return $name;
    }

    public function getBudgetnameAttribute(){
		$name = "";
		$query = Budget::where('budget_id' , $this->budget_id)->first();
		if(count($query) > 0){
			$name = $query->budget_name;
		}

		return $name;
		}
		
    public function getThaidateAttribute()
		{
			$strDate = $this->created_at;
			$strYear = date("Y",strtotime($strDate))+543;
			$strMonth= date("n",strtotime($strDate));
			$strDay= date("j",strtotime($strDate));
			$strHour= date("H",strtotime($strDate));
			$strMinute= date("i",strtotime($strDate));
			$strSeconds= date("s",strtotime($strDate));
			$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน.","พฤษภาคม","มิถุนายน","กรฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			$strMonthThai=$strMonthCut[$strMonth];
			return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
		}

    public function getRefunddateAttribute(){
        return date('d/m/' , strtotime( $this->created_at ) ).(date('Y',strtotime($this->created_at))+543);
    }


}
