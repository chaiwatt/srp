<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectAssesment extends Model
{
    protected $table = 'tb_project_assesment';
    protected $primaryKey = 'project_assesment_id';


    public function getAssigndateAttribute(){
        return date('d/m/' , strtotime( $this->assesmentdate ) ).(date('Y',strtotime($this->assesmentdate))+543);
    }
}
