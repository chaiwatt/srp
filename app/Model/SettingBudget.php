<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class SettingBudget extends Model{    
	
    protected $table = 'tb_setting_budget';
    protected $primaryKey = 'setting_budget_id';
	public $timestamps = false;

	public function getBudgetnameAttribute(){
		$name = "";
		$query = Budget::where('budget_id' , $this->budget_id)->first();
		if(count($query ) > 0){
			$name = $query->budget_name;
		}
		return $name;
    }
}
