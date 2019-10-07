<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Software extends Model{    
	
    protected $table = 'tb_software';
    protected $primaryKey = 'software_id';
	public $timestamps = false;
}
