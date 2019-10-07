<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Reason extends Model{    
	
    protected $table = 'tb_reason';
    protected $primaryKey = 'reason_id';
	public $timestamps = false;
}
