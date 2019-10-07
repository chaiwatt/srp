<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Prefix;
use App\Model\Register;
use App\Model\Group;

class ParticipateGroup extends Model
{
    protected $table = 'tb_participategroup';
    protected $primaryKey = 'participategroup_id';

    public function getRegisternameAttribute(){
		$prefix = Prefix::where('prefix_id' , $this->prefix_id)->first();
        $register = Register::where('register_id' , $this->register_id)->first();
        return $prefix->prefix_name . $register->name . " " .  $register->lastname;
    }
    public function getPersonidAttribute(){
        $register = Register::where('register_id' , $this->register_id)->first();
        return $register->person_id;
    }

    public function getGroupnameAttribute(){
        $register = Register::where('register_id' , $this->register_id)->first();
        $group = Group::where('group_id' , $register->group_id)->first();
        return $group->group_name;
    }

}
