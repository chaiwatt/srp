<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectFollowup extends Model
{
    protected $table = 'tb_project_followup';
    protected $primaryKey = 'project_followup_id';

    public function getProjectstartdateAttribute(){
        return date('d/m/' , strtotime( $this->start_date ) ).(date('Y',strtotime($this->start_date))+543);
    }
    public function getProjectenddateAttribute(){
        return date('d/m/' , strtotime( $this->end_date ) ).(date('Y',strtotime($this->end_date))+543);
    }
}
