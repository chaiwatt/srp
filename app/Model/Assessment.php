<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Assessment extends Model{    
	
    protected $table = 'tb_assessment';
    protected $primaryKey = 'assessment_id';
    public $timestamps = false;
    
}
