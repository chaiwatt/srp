<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class TransferTransaction extends Model{    
	
    protected $table = 'tb_transfer_transaction';
    protected $primaryKey = 'transfer_transaction_id';
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
        $query = Budget::where('department_id' , $this->department_id)->first();
        if(count($query) > 0){
            $name = $query->department_name;
        }
        return $name;
    }

}
