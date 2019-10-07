<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Registertype extends Model
{
    protected $table = 'tb_register_type';
    protected $primaryKey = 'register_type_id';
	public $timestamps = false;
}
