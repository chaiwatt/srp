<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\Department;

class Information extends Model{    
	
    protected $table = 'tb_information';
    protected $primaryKey = 'information_id';
    
    public function getThaishortdateAttribute()
		{
			$strDate = $this->created_at;
            $strYear = date("Y",strtotime($strDate))+543;
            $strYearShort = substr($strYear, -2);
			$strMonth= date("n",strtotime($strDate));
            $strMonthCut = Array("","ม.ค","ก.พ","มี.ค","เม.ย.","พ.ค","มิ.ย","ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค");
            //$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน.","พฤษภาคม","มิถุนายน","กรฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			$strMonthThai=$strMonthCut[$strMonth];
			return "$strMonthThai $strYearShort";
        }
        public function getThaidayAttribute()
		{
            $strDate = $this->created_at;
            $strDay= date("j",strtotime($strDate));
			return "$strDay";
        }    
        
        public function getDepartmentnameAttribute(){
            $name = "";
            $query = Department::where('department_id' , $this->department_id)->first();
            if(count($query) > 0){
                $name = $query->department_name;
            }
            return $name;
        }

        public function getBudgetnameAttribute(){
            $name = "";
            $query = Budget::where('budget_id' , $this->budget_id)->first();
            if(count($query) > 0){
                $name = $query->budget_name;
            }
            $name = str_replace("ค่า", "", $name);
            return $name;
        }

}
