<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Position extends Model{    
	
    protected $table = 'tb_position';
    protected $primaryKey = 'position_id';
	public $timestamps = false;

	public function getDepartmentnameAttribute(){
		$name = "";
		$department = Department::where('department_id' , $this->department_id)->first();
		if(count($department) > 0){
			$name = $department->department_name;
		}

		return $name;
    }

}
