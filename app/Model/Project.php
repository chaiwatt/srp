<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Project extends Model{    
	
    protected $table = 'tb_project';
    protected $primaryKey = 'project_id';
	public $timestamps = false;

	public function getAdddatethAttribute(){
        return date('d/m/' , strtotime( $this->adddate ) ).(date('Y',strtotime($this->adddate))+543);
    }

	public function getStartdatethAttribute(){
        return date('d/m/' , strtotime( $this->startdate ) ).(date('Y',strtotime($this->startdate))+543);
    }

    public function getEnddatethAttribute(){
        return date('d/m/' , strtotime( $this->enddate ) ).(date('Y',strtotime($this->enddate))+543);
    }

    public function getStartdateinputAttribute(){
        return date('d/m/' , strtotime( $this->startdate ) ).(date('Y',strtotime($this->startdate)));
    }

    public function getEnddateinputAttribute(){
        return date('d/m/' , strtotime( $this->enddate ) ).(date('Y',strtotime($this->enddate)));
    }

}
