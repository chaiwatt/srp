<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'tb_month';
    protected $primaryKey = 'month_id';
	public $timestamps = false;
}
