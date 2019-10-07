<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class RegisterEducation extends Model{    
	
    protected $table = 'tb_register_education';
    protected $primaryKey = 'register_education_id';
	public $timestamps = false;
}
