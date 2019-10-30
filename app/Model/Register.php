<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Carbon\Carbon;
use App\Model\Married;
use App\Model\Religion;

class Register extends Model{    
	
    protected $table = 'tb_register';
    protected $primaryKey = 'register_id';

    protected $fillable = [];
    protected $guarded = [];
    
    public function getPrefixnameAttribute(){
    	$name = "";
    	$q = Prefix::where('prefix_id' , $this->prefix_id)->first();
    	if(count($q) > 0){
    		$name = $q->prefix_name;
    	}
    	return $name;
    }

    public function getDepartmentnameAttribute(){
        $name = "";
        $q = Department::where('department_id' , $this->department_id)->first();
        if(count($q) > 0){
            $name = $q->department_name;
        }
        return $name;
    }

    public function getReligionAttribute(){
        $name = "";
        $q = Religion::where('religion_id' , $this->religion_id)->first();
        if(count($q) > 0){
            $name = $q->religion_name;
        }
        return $name;
    }
    public function getMarriedAttribute(){
        $name = "";
        $q = Married::where('married_id' , $this->married_id)->first();
        if(count($q) > 0){
            $name = $q->married_name;
        }
        return $name;
    }

    public function getAgeyearAttribute(){
        return Carbon::parse($this->birthday)->age;
    }

    public function getAgeMonthAttribute(){
     return   Carbon::parse($this->birthday)->month ;
    }

    public function getSectionnameAttribute(){
        $name = "";
        $q = Section::where('section_id' , $this->section_id)->first();
        if(count($q) > 0){
            $name = $q->section_name;
        }
        return $name;
    }

    public function getPositionnameAttribute(){
        $name = "";
        $q = Position::where('position_id' , $this->position_id)->first();
        if(count($q) > 0){
            $name = $q->position_name;
        }
        return $name;
    }

    public function getBirthdayinputAttribute(){
        return date('d/m/' , strtotime( $this->birthday ) ).(date('Y',strtotime($this->birthday))+543);
    }

    public function getBirthdayinputEngAttribute(){
        return date('d/m/' , strtotime( $this->birthday ) ).(date('Y',strtotime($this->birthday)));
    }

    public function getEndhireinputAttribute(){
        return date('d/m/' , strtotime( $this->endhiredate ) ).(date('Y',strtotime($this->endhiredate)));
    }

    public function getStarthireinputAttribute(){
        return date('d/m/' , strtotime( $this->starthiredate ) ).(date('Y',strtotime($this->starthiredate)));
    }

    public function getMonthdiffAttribute(){
        return Carbon::parse( $this->starthiredate)->timezone('Asia/Bangkok')->diff(Carbon::parse( $this->endhiredate)->timezone('Asia/Bangkok')->addDays(1))->format('%m เดือน %d วัน');
    }

    public function getContractpaymentAttribute(){
        $m = intval(Carbon::parse( $this->starthiredate)->diff(Carbon::parse( $this->endhiredate)->addDays(1))->format('%m'))*9000;
        $d = intval(Carbon::parse( $this->starthiredate)->diff(Carbon::parse( $this->endhiredate)->addDays(1))->format('%d'))*300;
        return $m + $d; 
    }

    public function getConvertobathAttribute(){
        $m = intval(Carbon::parse( $this->starthiredate)->diff(Carbon::parse( $this->endhiredate)->addDays(1))->format('%m'))*9000;
        $d = intval(Carbon::parse( $this->starthiredate)->diff(Carbon::parse( $this->endhiredate)->addDays(1))->format('%d'))*300;
        $sum  = $m + $d; 
        return $this->convert($sum);
    }

    function convert(string $number)
    {
        $values = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
        $places = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
        $exceptions = ['หนึ่งสิบ' => 'สิบ', 'สองสิบ' => 'ยี่สิบ', 'สิบหนึ่ง' => 'สิบเอ็ด'];
    
        $output = '';
    
        foreach (str_split(strrev($number)) as $place => $value) {
            if ($place % 6 === 0 && $place > 0) {
                $output = $places[6].$output;
            }
    
            if ($value !== '0') {
                $output = $values[$value].$places[$place % 6].$output;
            }
        }
    
        foreach ($exceptions as $search => $replace) {
            $output = str_replace($search, $replace, $output);
        }
    
        return $output;
    }

    public function getThaibirthdateAttribute()
    {
        $strDate = $this->birthday;
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน.","พฤษภาคม","มิถุนายน","กรฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

  public function getThaiStarthiredateAttribute()
    {
        $strDate = $this->starthiredate;
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน.","พฤษภาคม","มิถุนายน","กรฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }


  public function getThaiEndhiredateAttribute()
    {
        $strDate = $this->endhiredate;
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน.","พฤษภาคม","มิถุนายน","กรฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }


    public function getStarthiredateinputAttribute(){
        return date('d/m/' , strtotime( $this->starthiredate ) ).(date('Y',strtotime($this->starthiredate))+543);
    }

    public function getEndhiredateinputAttribute(){
        return date('d/m/' , strtotime( $this->endhiredate ) ).(date('Y',strtotime($this->endhiredate))+543);
    }


    public function getRegistertypenameAttribute(){
        $name = "";
        
        if( $this->register_type == 0 ){
            $name = "ยังไม่ได้พิจารณา";
        }
        elseif( $this->register_type == 1 ){
            $name = "ผ่านการพิจารณา";
        }
        elseif( $this->register_type == 2 ){
            $name = "ไม่ผ่านการพิจารณา";
        }

        return $name;
    }

    public function getProvincenameAttribute(){
        $name = "";
        $q = Province::where('province_id' , $this->province_id)->first();
        if(count($q) > 0){
            $name = $q->province_name;
        }
        return $name;
    }

    public function getAmphurnameAttribute(){
        $name = "";
        $q = Amphur::where('amphur_id' , $this->amphur_id)->first();
        if(count($q) > 0){
            $name = $q->amphur_name;
        }
        return $name;
    }

    public function getDistrictnameAttribute(){
        $name = "";
        $q = District::where('district_id' , $this->district_id)->first();
        if(count($q) > 0){
            $name = $q->district_name;
        }
        return $name;
    }

        public function getProvincenownameAttribute(){
        $name = "";
        $q = Province::where('province_id' , $this->province_id_now)->first();
        if(count($q) > 0){
            $name = $q->province_name;
        }
        return $name;
    }

    public function getAmphurnownameAttribute(){
        $name = "";
        $q = Amphur::where('amphur_id' , $this->amphur_id_now)->first();
        if(count($q) > 0){
            $name = $q->amphur_name;
        }
        return $name;
    }

    public function getDistrictnownameAttribute(){
        $name = "";
        $q = District::where('district_id' , $this->district_id_now)->first();
        if(count($q) > 0){
            $name = $q->district_name;
        }
        return $name;
    }

}
