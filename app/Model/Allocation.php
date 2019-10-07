<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\Department;

class Allocation extends Model{    
	
    protected $table = 'tb_allocation';
    protected $primaryKey = 'allocation_id';

	public function getBudgetnameAttribute(){
		$name = "";
		$query = Budget::where('budget_id' , $this->budget_id)->first();
		if(count($query) > 0){
			$name = $query->budget_name;
		}
		return $name;
    }

    public function getBudgetcategorynameAttribute(){
        $name = "";
        $query = Budget::where('budget_id' , $this->budget_id)->first();
        if(count($query) > 0){
            $name = $query->budget_name;
        }
        $name = str_replace("ค่า", "", $name);
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

    public function getSectionnameAttribute(){
        $name = "";
        $query = Section::where('section_id' , $this->section_id)->first();
        if(count($query) > 0){
            $name = $query->section_name;
        }
        return $name;
    }

    public function getTransactioncostAttribute(){
        $name = "";
        
        $q = AllocationTransaction::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('transaction_type' , $this->allocation_type);
        if( $this->allocation_type == 2 ){
            $q = $q->where('section_id' , $this->section_id);
        }
        $q = $q->orderBy('allocation_transaction_id' , 'desc');
        $query = $q->first();
        if( count($query) > 0 ){
            $name = $query->transaction_cost;
        }

        return $name;
    }

    public function getTransferallocationAttribute(){
        $name = "";
        
        $q = Transfer::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('transfer_type' , $this->allocation_type);
        $q = $q->where('transfer_status' , 1);
        if( $this->allocation_type == 2){
            $q = $q->where('section_id' , $this->section_id);
        }
        $query = $q->sum('transfer_price');

        return $query;
    }

        public function getSumtransferAttribute(){
        $name = "";
        
        $q = Transfer::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('transfer_type' , 2);
        $q = $q->where('transfer_status' , 1);
        $query = $q->sum('transfer_price');

        return $query;
    }

    public function getTransactionbalanceAttribute(){
        $name = "";
        
        $q = TransferTransaction::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('transaction_type' , $this->allocation_type);
        if( $this->allocation_type == 2 ){
            $q = $q->where('section_id' , $this->section_id);
        }
        $q = $q->orderBy('transfer_transaction_id' , 'desc');
        $query = $q->first();

        if( count($query) > 0 ){
            $name = $query->transaction_balance;
        }
        else{
           $name = $this->allocation_price;
        }

        return $name;
    }

    public function getTransfercountAttribute(){
        $name = "";
        
        $q = Transfer::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('budget_id' , $this->budget_id);
        $q = $q->where('transfer_type' , $this->allocation_type);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_refund' , 0);
        
        if( $this->allocation_type == 2){
            $q = $q->where('section_id' , $this->section_id);
        }
        $query = $q->count();


        return $query;
    }

    public function getTransferpriceAttribute(){
        $number = 0;

        $q = Transfer::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , $this->section_id);
        $q = $q->where('transfer_type' , $this->allocation_type);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->sum('transfer_price');

        return $transfer;
    }

    public function getTransferpaymentbalanceAttribute(){
        
        $transfer = $this->getTransferpriceAttribute();

        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , $this->section_id);
        $q = $q->where('payment_status' , 1);
        $payment = $q->sum('payment_salary');

        if( $transfer == 0 ){
            return 0;
        }
        else{
            return $transfer - $payment;
        }

    }

    public function getTotaltransferpaymentbalanceAttribute(){
        
        $transfer = $this->getCheckTransferpriceAttribute();

        $q = Payment::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('payment_status' , 1);
        $payment = $q->sum('payment_salary');

        if( $transfer == 0 ){
            return 0;
        }
        else{
            return $transfer - $payment;
        }

    }

    
    public function getCheckTransferpriceAttribute(){
        $number = 0;

        $q = Transfer::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , 6);
        $q = $q->where('transfer_type' , 1);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->sum('transfer_price');

        return $transfer;
    }

    public function getRefundallocationAttribute(){

        $q = Refund::query();
        $q = $q->where('project_id' , $this->project_id);
        $q = $q->where('department_id' , $this->department_id);
        $q = $q->where('section_id' , $this->section_id);
        $q = $q->where('refund_status' , 1);
        $q = $q->where('refund_type' , 2);
        $refund = $q->sum('refund_price');

        if( $refund == 0 ){
            return 0;
        }
        else{
            return $refund;
        }

    }


}
