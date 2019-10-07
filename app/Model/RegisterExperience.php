<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class RegisterExperience extends Model{    
	
    protected $table = 'tb_register_experience';
    protected $primaryKey = 'register_experience_id';


    public function getDatestartinputAttribute(){
        return date('d/m/' , strtotime( $this->register_experience_datestart ) ).(date('Y',strtotime($this->register_experience_datestart))+543);
    }

    public function getDateendinputAttribute(){
        return date('d/m/' , strtotime( $this->register_experience_dateend ) ).(date('Y',strtotime($this->register_experience_dateend))+543);
    }


    public function getDatestartShortAttribute()
    {
        $strDate = $this->register_experience_datestart;
        $strYear = date("Y",strtotime($strDate))+543;
        $strYearShort = substr($strYear, -2);
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค","ก.พ","มี.ค","เม.ย.","พ.ค","มิ.ย","ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay$strMonthThai$strYearShort";
    }

    public function getDateendShortAttribute()
    {
        $strDate = $this->register_experience_dateend;
        $strYear = date("Y",strtotime($strDate))+543;
        $strYearShort = substr($strYear, -2);
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค","ก.พ","มี.ค","เม.ย.","พ.ค","มิ.ย","ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay$strMonthThai$strYearShort";
    }

}
