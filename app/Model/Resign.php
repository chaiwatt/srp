<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\ContractorPosition;
use App\Model\Contractor;

class Resign extends Model{    
	
    protected $table = 'tb_resign';
    protected $primaryKey = 'resign_id';
	public $timestamps = true;

	public function getDepartmentnameAttribute(){
        $name = "";
        $query = Department::where('department_id' , $this->department_id)->first();
        if(count($query ) > 0){
            $name = $query->department_name;
        }
        return $name;
    }

    public function getSectionnameAttribute(){
        $name = "";
        $query = Section::where('section_id' , $this->section_id)->first();
        if(count($query ) > 0){
            $name = $query->section_name;
        }
        return $name;
    }

    public function getPositionnameAttribute(){
        $name = "";
        $query = Position::where('position_id' , $this->position_id)->first();
        if(count($query ) > 0){
            $name = $query->position_name;
        }
        return $name;
    }

    public function getContractorpositionnameAttribute(){
        $name = "";
        $query = ContractorPosition::where('position_id' , $this->position_id)->first();
        if(count($query ) > 0){
            $name = $query->position_name;
        }
        return $name;
    }  

    public function getRegisterprefixnameAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->prefixname;
        }
        return $name;
    }

    public function getContractorprefixnameAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->prefixname;
        }
        return $name;
    }

    public function getRegisternameAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->name;
        }
        return $name;
    }

    public function getContractornameAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->name;
        }
        return $name;
    }

    public function getRegisterlastnameAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->lastname;
        }
        return $name;
    }


    public function getContractorlastnameAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->lastname;
        }
        return $name;
    }

    public function getRegisterpersonidAttribute(){
		$name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->person_id;
        }
        return $name;
    }

    public function getContractorpersonidAttribute(){
		$name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->person_id;
        }
        return $name;
    }

    public function getReasonnameAttribute(){
        $name = "";
        $query = Reason::where('reason_id' , $this->reason_id)->first();
        if(count($query ) > 0){
            $name = $query->reason_name;
        }
        return $name;
    }

	public function getResigndatethAttribute(){
        return date('d/m/' , strtotime( $this->resign_date ) ).(date('Y',strtotime($this->resign_date))+543);
    }
}
