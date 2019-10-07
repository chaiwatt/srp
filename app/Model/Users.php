<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;
use App\Model\Section;
use App\Model\Department;
use App\Model\Linenotify;


class Users extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';
    protected $hidden = [ 'password' ];   

    public function getSectionnameAttribute(){
		$name = "";
		$section = Section::where('section_id' , $this->section_id)->first();
		if(count($section) > 0){
			$name = $section->section_name;
		}
		return $name;
    }

    public function getDepartmentnameAttribute(){
		$name = "";
		$department = Department::where('department_id' , $this->department_id)->first();
		if(count($department) > 0){
			$name = $department->department_name;
		}
		return $name;
	}
    
    public function getUserstatusAttribute (){
        $status = Users::where('user_id' , $this->user_id)->first();
        if (count($status) > 0 && $status->isactive  == 1){
            return "ใช้งาน";
        }else{
            return "ปิดการใช้งาน";
        }
    }
    public function getLinenotifyAttribute (){
        $linenotify = Linenotify::where('linenotify_id' , $this->linenotify_id)->first();

        return $linenotify;
        
    }

    public function getLimitstartengAttribute(){
        return date('d/m/' , strtotime( $this->limitstart ) ).(date('Y',strtotime($this->limitstart)));
    }

    public function getLimitendengAttribute(){
        return date('d/m/' , strtotime( $this->limitend ) ).(date('Y',strtotime($this->limitend)));
    }
}

