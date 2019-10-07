<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class ProjectBudget extends Model{    
	
    protected $table = 'tb_project_budget';
    protected $primaryKey = 'project_budget_id';
	public $timestamps = false;

	public function getBudgetnameAttribute(){
		$name = "";
		$query = Budget::where('budget_id' , $this->budget_id)->first();
		if(count($query) > 0){
			$name = $query->budget_name;
		}
		return $name;
    }

   
}
