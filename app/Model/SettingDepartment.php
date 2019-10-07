<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class SettingDepartment extends Model{    
	
    protected $table = 'tb_setting_department';
    protected $primaryKey = 'setting_department_id';
	public $timestamps = false;

	public function getDepartmentnameAttribute(){
		$name = "";
		$query = Department::where('department_id' , $this->department_id)->first();
		if(count($query ) > 0){
			$name = $query->department_name;
		}
		return $name;
    }

}
