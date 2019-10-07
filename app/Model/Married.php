<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Married extends Model{    
	
    protected $table = 'tb_married';
    protected $primaryKey = 'married_id';
	public $timestamps = false;
}
