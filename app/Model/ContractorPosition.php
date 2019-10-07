<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Department;

class ContractorPosition extends Model
{
    protected $table = 'tb_contractor_position';
    protected $primaryKey = 'position_id';

        public function getDepartmentnameAttribute(){
        $name = "";
        $q = Department::where('department_id' , $this->department_id)->first();
        if(count($q) > 0){
            $name = $q->department_name;
        }
        return $name;
    }
}
