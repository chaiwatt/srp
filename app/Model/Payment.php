<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\Contractor;

class Payment extends Model{    
	
    protected $table = 'tb_payment';
    protected $primaryKey = 'payment_id';
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
        $query = Generate::where('generate_code' , $this->generate_code)->first();
        if(count($query ) > 0){
            $name = $query->positionname;
        }
        return $name;
    }

    public function getBudgetnameAttribute(){
    	$name = "";
        $query = Budget::where('budget_id' , $this->budget_id)->first();
        if(count($query ) > 0){
            $name = $query->budget_name;
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

    public function getContractorstarthiredateAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->starthiredate;
        }
         return $name;
    }


    public function getContractorendhiredateAttribute(){
        $name = "";
        $query = Contractor::where('contractor_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->endhiredate;
        }
         return $name;
        // return date('d/m/' , strtotime( $name ).(date('Y',strtotime($name))+543);
    }

    // public function getContractorpersonidAttribute(){
    //     $name = "";
    //     $query = Contractor::where('contractor_id' , $this->register_id)->first();
    //     if(count($query ) > 0){
    //         $name = $query->person_id;
    //     }
    //     return $name;
    // }

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

    public function getPaymentdateinputAttribute(){
        return date('d/m/' , strtotime( $this->payment_date ) ).(date('Y',strtotime($this->payment_date)));
    }

	public function getPaymentdatethAttribute(){
        return date('d/m/' , strtotime( $this->payment_date ) ).(date('Y',strtotime($this->payment_date))+543);
    }

    public function getRegisterstarthiredateAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->starthiredate;
        }
         return date('d/m/' , strtotime( $name ) ).(date('Y',strtotime($name))+543);
    }

    public function getRegisterendhiredateAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->endhiredate;
        }
         return date('d/m/' , strtotime( $name ) ).(date('Y',strtotime($name))+543);
    }

    public function getRegisterapplicationnoAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->application_no;
        }
        return $name;
    }
    public function getRegistercontractnoAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->contract_no;
        }
        return $name;
    }


    public function getPaymentdepartmentabsenceAttribute(){
        $number = "";
        
        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_month' , $this->payment_month);
        $number = $q->sum('payment_absence');

        return $number;
    }

    public function getPaymentdepartmentfineAttribute(){
        $number = "";
        
        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_month' , $this->payment_month);
        $number = $q->sum('payment_fine');

        return $number;
    }

    public function getPaymentdepartmentsalaryAttribute(){
        $number = "";
        
        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_month' , $this->payment_month);
        $number = $q->sum('payment_salary');

        return $number;
    }

    public function getPaymentsectionabsenceAttribute(){
        $number = "";
        
        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , $this->section_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_month' , $this->payment_month);
        $number = $q->sum('payment_absence');

        return $number;
    }

    public function getPaymentsectionfineAttribute(){
        $number = "";
        
        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , $this->section_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_month' , $this->payment_month);
        $number = $q->sum('payment_fine');

        return $number;
    }

    public function getPaymentsectionsalaryAttribute(){
        $number = "";
        
        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , $this->section_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_month' , $this->payment_month);
        $number = $q->sum('payment_salary');

        return $number;
    }

}
