<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Budget extends Model{    
	
    protected $table = 'tb_budget';
    protected $primaryKey = 'budget_id';
	public $timestamps = false;
}
