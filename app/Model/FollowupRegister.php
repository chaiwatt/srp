<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Department;
use App\Model\Section;
use App\Model\Register;
use App\Model\Satisfaction;


class FollowupRegister extends Model
{
    protected $table = 'tb_followup_register';
    protected $primaryKey = 'followup_register_id';

    public function getSectionidAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->section_id;
        }
        return $name;
    }

    public function getRegisterprefixnameAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->prefixname;
        }
        return $name;
    }

    public function getRegisternameAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->name;
        }
        return $name;
    }
    public function getRegisterlastnameAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->lastname;
        }
        return $name;
    }
    public function getRegisterpersonidAttribute(){
        $name = "";
        $query = Register::where('register_id' , $this->register_id)->first();
        if(count($query ) > 0){
            $name = $query->person_id;
        }
        return $name;
    }
    public function getRegistersatisfactionAttribute(){
        $name = "";
        $query = Satisfaction::where('satisfaction_id' , $this->satisfaction_id)->first();
        if(count($query ) > 0){
            $name = $query->satisfaction_name;
        }
        return $name;
    }
}
