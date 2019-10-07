<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Department extends Model{    
	
    protected $table = 'tb_department';
    protected $primaryKey = 'department_id';
	public $timestamps = false;
}
