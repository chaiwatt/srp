<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Education extends Model{    
	
    protected $table = 'tb_education';
    protected $primaryKey = 'education_id';
	public $timestamps = false;
}
