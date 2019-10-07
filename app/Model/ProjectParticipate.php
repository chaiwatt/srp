<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Participate;

class ProjectParticipate extends Model
{
    protected $table = 'tb_project_participate';
    protected $primaryKey = 'project_participate';


    public function getParticipatenameAttribute(){
      $participate = Participate::where('participate_id' , $this->participate_id)->first();
      return $participate->participate_position;
    }

}
