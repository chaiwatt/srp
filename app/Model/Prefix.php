<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Prefix extends Model{    
	
    protected $table = 'tb_prefix';
    protected $primaryKey = 'prefix_id';
	public $timestamps = false;
}
