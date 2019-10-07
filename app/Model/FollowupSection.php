<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Province;
use App\Model\Section;

class FollowupSection extends Model
{
    protected $table = 'tb_followup_section';
    protected $primaryKey = 'followup_section_id';

    public function getSectionnameAttribute(){
		$section = Section::where('section_id' , $this->section_id)->first();
        return $section->section_name;
	}
}
