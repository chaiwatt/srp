<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class District extends Model{    
	
    protected $table = 'tb_district';
    protected $primaryKey = 'district_id';
	public $timestamps = false;
}
	