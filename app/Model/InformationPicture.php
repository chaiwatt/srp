<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class InformationPicture extends Model{    
	
    protected $table = 'tb_information_picture';
    protected $primaryKey = 'information_picture_id';
	public $timestamps = false;
}
