<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class AllocationWaiting extends Model{    
	
    protected $table = 'tb_allocation_waiting';
    protected $primaryKey = 'waiting_id';
	public $timestamps = true;

	public function getBudgetnameAttribute(){
		$name = "";
		$query = Budget::where('budget_id' , $this->budget_id)->first();
		if(count($query) > 0){
			$name = $query->budget_name;
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
