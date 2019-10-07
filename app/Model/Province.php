<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class Province extends Model{    
	
    protected $table = 'tb_province';
    protected $primaryKey = 'province_id';
	public $timestamps = false;
}
	