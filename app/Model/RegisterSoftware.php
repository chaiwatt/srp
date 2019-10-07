<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class RegisterSoftware extends Model{    
	
    protected $table = 'tb_register_software';
    protected $primaryKey = 'register_software_id';
	public $timestamps = false;
}
