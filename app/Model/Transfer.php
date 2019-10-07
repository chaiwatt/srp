<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Transfer extends Model{    
	
    protected $table = 'tb_transfer';
    protected $primaryKey = 'transfer_id';

    public function getTransferdatethAttribute(){
        return date('d/m/' , strtotime( $this->transfer_date ) ).(date('Y',strtotime($this->transfer_date))+543);
    }

    public function getDepartmentnameAttribute(){
        $name = "";
        $query = Department::where('department_id' , $this->department_id)->first();
        if(count($query ) > 0){
            $name = $query->department_name;
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

    public function getSectionnameAttribute(){
        $name = "";
        $query = Section::where('section_id' , $this->section_id)->first();
        if(count($query ) > 0){
            $name = $query->section_name;
        }
        return $name;
    }

    public function getAllocationpriceAttribute(){
        $allocation = "";
        $q = Allocation::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('allocation_type' , $this->transfer_type);
        if( $this->transfer_type == 2 ){
            $q = $q->where('section_id' , $this->section_id);
        }
        $query = $q->first();
        if(count($query ) > 0){
            $allocation = $query->allocation_price;
        }
        return $allocation;
    }

    public function getTransfercountAttribute(){
        $q = Transfer::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('transfer_type' , $this->transfer_type);
        $q = $q->where('transfer_status' , 1);
        if( $this->transfer_type == 2){
            $q = $q->where('section_id' , $this->section_id);
        }
        $query = $q->count();


        return $query;
    }

    public function getTransfersumpriceAttribute(){
        $number = "";
        $query = Transfer::where('budget_id' , $this->budget_id)->where('department_id' , $this->department_id)->where('project_id' , $this->project_id)->where('transfer_status' , 1)->where('transfer_type' , 1)->get();
        if(count($query ) > 0){
            $number = $query->sum('transfer_price');
        }
        return $number;
    }

    public function getRefundpriceAttribute(){
        $q = Refund::query();
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('refund_type' , 1);
        $refund = $q->sum('refund_price');

        return $refund;
    }

    

    public function getTransferpercentAttribute(){
        $number1 = $this->getAllocationpriceAttribute();
        $number2 = $this->getTransfersumpriceAttribute();
        $number3 = $this->getRefundpriceAttribute();

        if( $number1 == 0 ){
            return 0;
        }
        else{
            return $number2 / ( $number1 + $number3  ) * 100;
        }

    }

}
