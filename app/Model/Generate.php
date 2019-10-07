<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\ContractorPosition;
use App\Model\Contractor;
use App\Model\Section;

class Generate extends Model{    
	
    protected $table = 'tb_generate';
    protected $primaryKey = 'generate_id';
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

    public function getRegistercontractidAttribute(){
        $contract = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $contract = $query->contract_no;
        }
        return $contract;
    }



    public function getContractorpersonidAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->person_id;
        }
        return $name;
    }

    public function getContractorapplicationnoAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->application_no;
        }
        return $name;
    }
    public function getContractorcontractnoAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->contract_no;
        }
        return $name;
    }

    

    public function getContractorstarthiredateAttribute(){
        $_startdate = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $_startdate = $query->starthiredate;
        }
          return date('d/m/' , strtotime( $_startdate  ) ).(date('Y',strtotime($_startdate ))+543);
    }

    public function getContractorendhiredateAttribute(){
        $_enddate = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $_enddate = $query->endhiredate;
        }
          return date('d/m/' , strtotime( $_enddate  ) ).(date('Y',strtotime($_enddate ))+543);
    }
    public function getPositionsalaryAttribute(){
        $name = "";
        $query = Position::where('position_id' , $this->position_id)->first();
        if(count($query ) > 0){
            $name = $query->position_salary;
        }
        return $name;
    }

    public function getContractorPositionsalaryAttribute(){
        $name = "";
        $query = ContractorPosition::where('position_id' , $this->position_id)->first();
        if(count($query ) > 0){
            $name = $query->position_salary;
        }
        return $name;
    }

    public function getGeneratestatusnameAttribute(){
        if( $this->generate_status == 1 ){
            $name = "จัดจ้าง";
        }
        else{
            if( $this->generate_refund == 0 ){
                $name = "-";
            }
            else{
                $name = "คืนงบประมาณ";
            }
        }

        return $name;
    }

    public function getPaymentbalanceAttribute(){
        $number1 = $this->generate_allocation;
        $number2 = 0;

        $q = Payment::query();
        $q = $q->where('generate_id' , $this->generate_id);
        $q = $q->where('payment_status' , 1);
        $number2 = $q->sum('payment_salary');

        return $number1 - $number2;
    }

    // public function getMapcodeAttribute(){
    //     $section = $this->section_id;
    //     $mapcode = Province::where('section_id' , $this->generate_id)->first();
    //     return $mapcode;
    // }
    
}
