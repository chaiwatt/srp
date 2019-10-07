<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class RegisterSkill extends Model{    
	
    protected $table = 'tb_register_skill';
    protected $primaryKey = 'register_skill_id';
	public $timestamps = false;
}
