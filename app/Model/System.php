<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class System extends Model{    
	
    protected $table = 'tb_system';
    protected $primaryKey = 'system_id';
	public $timestamps = false;

}
