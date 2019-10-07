<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Employ extends Model{    
	
    protected $table = 'tb_employ';
    protected $primaryKey = 'employ_id';
	public $timestamps = false;
}
