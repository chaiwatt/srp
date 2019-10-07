<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class RegisterDocument extends Model{    
	
    protected $table = 'tb_register_document';
    protected $primaryKey = 'register_document_id';
	public $timestamps = false;
}
