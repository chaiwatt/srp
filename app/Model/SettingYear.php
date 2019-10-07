<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class SettingYear extends Model{    
	
    protected $table = 'tb_setting_year';
    protected $primaryKey = 'setting_year_id';
	public $timestamps = false;
}
