<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Users;
use App\Model\Department;
use App\Model\Section;
use App\Model\LogList;


class LogFile extends Model
{
    protected $table = 'tb_logfile';
    protected $primaryKey = 'logfile_id';

    public function getNameAttribute(){
        $name = "";
        $query = Users::where('user_id' , $this->user_id)->first();
        if(count($query ) > 0){
            $name = $query->name;
        }
        return $name;
    }

    public function getUsernameAttribute(){
        $name = "";
        $query = Users::where('user_id' , $this->user_id)->first();
        if(count($query ) > 0){
            $name = $query->username;
        }
        return $name;
    }

    public function getUsertypeAttribute(){
        $name = "";
        $query = Users::where('user_id' , $this->user_id)->first();
        if(count($query ) > 0){
            $name = $query->usertype;
        }
        return $name;
    }

    public function getDepartmentnameAttribute(){
        $dept_id = 0;

        $query = Users::where('user_id' , $this->user_id)->first();
        if(count($query ) > 0){
            $dept_id = $query->department_id;
        }


        if($dept_id != 0){
            return Department::where('department_id',$dept_id)->first()->department_name;
        }else{
            return "";
        }
    }

    public function getSectionnameAttribute(){
        $sectionid = 0;

        $query = Users::where('user_id' , $this->user_id)->first();
        if(count($query ) > 0){
            $sectionid = $query->section_id;
        }
      
        if($sectionid != 0){
            return Section::where('section_id',$sectionid)->first()->section_name;
        }else{
            return "";
        }
    }

    public function getLogAttribute(){
        $name = "";
        $query = LogList::where('loglist_id' , $this->loglist_id)->first();
        if(count($query ) > 0){
            $name = $query->log_name;
        }
        return $name;
    }

    public function getLogdateAttribute(){
        return date('d/m/' , strtotime( $this->created_at ) ).(date('Y',strtotime($this->created_at))+543) . " " . $this->created_at->format('H:i:s');
    }

}
