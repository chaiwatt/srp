<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Religion extends Model{    
	
    protected $table = 'tb_religion';
    protected $primaryKey = 'religion_id';
	public $timestamps = false;
}
