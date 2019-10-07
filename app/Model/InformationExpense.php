<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Model\Department;

class InformationExpense extends Model{    
	
    protected $table = 'tb_information_expense';
    protected $primaryKey = 'expense_id';
	public $timestamps = true;

	public function getDepartmentnameAttribute(){
            $name = "";
            $query = Department::where('department_id' , $this->department_id)->first();
            if(count($query) > 0){
                $name = $query->department_name;
            }
            return $name;
    }
}
