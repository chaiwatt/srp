<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Skill extends Model{    
	
    protected $table = 'tb_skill';
    protected $primaryKey = 'skill_id';
	public $timestamps = false;
}
