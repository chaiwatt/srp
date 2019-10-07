<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Department;

class WebApi extends Model
{
    protected $table = 'tb_webapi';
    protected $primaryKey = 'webapi_id';

    public function getDepartmentnameAttribute(){
        $name = "";
        $query = Department::where('department_id' , $this->department_id)->first();
        if(count($query) > 0){
            $name = $query->department_name;
        }
        return $name;
    }
}
