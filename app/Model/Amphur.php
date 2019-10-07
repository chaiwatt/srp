<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class Amphur extends Model{    
	
    protected $table = 'tb_amphur';
    protected $primaryKey = 'amphur_id';
	public $timestamps = false;
}
	