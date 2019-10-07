<?php

namespace App\Http\Controllers;

use Request;
use Session;
use App\Model\SettingYear;
use App\Model\Education;
use App\Model\Software;
use App\Model\Skill;
use App\Model\Project;

class ApplicationController extends Controller
{
    public function Index(){
    	$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		$education = Education::get();
        $software = Software::get();
        $skill = Skill::get();

		return view('landing.register.index')->withProject($project)->withEducation($education)->withSoftware($software)->withSkill($skill);
    
    }
}
