<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class RegisterTraining extends Model{    
	
    protected $table = 'tb_register_training';
    protected $primaryKey = 'register_training_id';



    public function getDatestartinputAttribute(){
        return date('d/m/' , strtotime( $this->register_training_datestart ) ).(date('Y',strtotime($this->register_training_datestart))+543);
    }

    public function getDateendinputAttribute(){
        return date('d/m/' , strtotime( $this->register_training_dateend ) ).(date('Y',strtotime($this->register_training_dateend))+543);
    }

    public function getDatestartShortAttribute()
    {
        $strDate = $this->register_training_datestart;
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
        $strDate = $this->register_training_dateend;
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
