<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Military extends Model{    
	
    protected $table = 'tb_military';
    protected $primaryKey = 'military_id';
	public $timestamps = false;
}
