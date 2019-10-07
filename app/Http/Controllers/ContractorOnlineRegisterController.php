<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Contractor;
use App\Model\ContractorDocument;
use App\Model\ContractorEducation;
use App\Model\ContractorExperience;
use App\Model\ContractorSkill;
use App\Model\ContractorSoftware;
use App\Model\ContractorTraining;
use App\Model\SettingYear;
use App\Model\Education;
use App\Model\Software;
use App\Model\Skill;
use App\Model\ContractorPosition;
use App\Model\Allocation;
use App\Model\Prefix;
use App\Model\Military;
use App\Model\Religion;
use App\Model\Married;
use App\Model\LogFile;

class ContractorOnlineRegisterController extends Controller
{
    public function Index(){
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        if(Empty($project)){
            return redirect('landing');
        }

		$education = Education::get();
        $software = Software::get();
        $skill = Skill::get();
        $allocation = Allocation::where('project_id',$project->project_id)
                            ->where('budget_id',6)
                            ->first();
                           
        $prefix = Prefix::get();        
        $military = Military::get();  
        $religion = Religion::get();  
        $married = Married::get();  
        $departmentid = $allocation->department_id;

        $position = ContractorPosition::where('department_id',$allocation->department_id)->get();

        return view('landing.register.index')
                    ->withProject($project)
                    ->withEducation($education)
                    ->withSoftware($software)
                    ->withPosition($position)
                    ->withPrefix($prefix)
                    ->withMarried($married)
                    ->withMilitary($military)
                    ->withReligion($religion)
                    ->withDepartmentid($departmentid)
                    ->withAuth($auth)
                    ->withSkill($skill);
	}

    public function CreateSave(){
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        $extension_picture = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        $extension_pdf = array('pdf');

        $allocate = Allocation::where('project_id',$project->project_id)->where('budget_id',6)->get();

        $departmentid = Request::input('departmentid')  ;

		$birthday = "";

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		$education = Education::get();

		$contractor = Contractor::where('person_id' , Request::input('person_id') )->first();
		if( count($contractor) > 0 ){
			return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว");
		}

		if( Request::input('birthday') != "" ){
			$date = explode("/", Request::input('birthday'));
        	$birthday = ($date[2]-543)."-".$date[1]."-".$date[0];
		}

		$new = new Contractor;
		$new->project_id = $project->project_id;
		$new->year_budget = $project->year_budget;
		$new->department_id = $departmentid ;
		$new->section_id = 0;
		$new->position_id = Request::input('position');
		$new->person_id = Request::input('person_id');
		$new->prefix_id = Request::input('prefix');
		$new->name = Request::input('name');
		$new->lastname = Request::input('lastname');
		$new->birthday = $birthday;
		if(Request::hasFile('picture')){
            $file = Request::file('picture');
            if( in_array($file->getClientOriginalExtension(), $extension_picture) ){
                $new_name = str_random(10).".".$file->getClientOriginalExtension();
                $file->move('storage/uploads/register/pictures' , $new_name);
                $new->picture = "storage/uploads/register/pictures/".$new_name;
            }
        }
        $new->nationality = Request::input('nationality');
        $new->ethnicity = Request::input('ethnicity');
        $new->religion_id = Request::input('religion');
        $new->military_id = Request::input('military');
        $new->married_id = Request::input('married');
        $new->baby = Request::input('baby');
        $new->phone = Request::input('phone');
        $new->email = Request::input('email');
        $new->facebook = Request::input('facebook');
        $new->father_name = Request::input('father_name');
        $new->father_lastname = Request::input('father_lastname');
        $new->father_career = Request::input('father_career');
        $new->mother_name = Request::input('mother_name');
        $new->mother_lastname = Request::input('mother_lastname');
        $new->mother_career = Request::input('mother_career');
        $new->spouse_name = Request::input('spouse_name');
        $new->spouse_lastname = Request::input('spouse_lastname');
        $new->spouse_career = Request::input('spouse_career');
        $new->urgent_name = Request::input('urgent_name');
        $new->urgent_lastname = Request::input('urgent_lastname');
        $new->urgent_relationship = Request::input('urgent_relationship');
        $new->urgent_phone = Request::input('urgent_phone');
        $new->urgent_email = Request::input('urgent_email');
        $new->address = Request::input('address');
        $new->province_id = Request::input('province');
        $new->amphur_id = Request::input('amphur');
        $new->district_id = Request::input('district');
        $new->address_now = Request::input('address_now');
        $new->province_id_now = Request::input('province_now');
        $new->amphur_id_now = Request::input('amphur_now');
        $new->district_id_now = Request::input('district_now');
        $new->software_about = Request::input('software_about');
        $new->skill_about = Request::input('skill_about');
        $new->description = Request::input('description');

        $new->save();

        $contractor = Contractor::orderBy('contractor_id' , 'desc')->first();

        if( count( Request::input('software') ) > 0 ){
        	foreach( Request::input('software') as $item ){
            	$new = new ContractorSoftware;
            	$new->contractor_id = $contractor->contractor_id;
                $new->software_id = $item;
            	$new->save();
        	}
        }

        if( count( Request::input('skill') ) > 0 ){
            foreach( Request::input('skill') as $item ){
                $new = new ContractorSkill;
                $new->contractor_id = $contractor->contractor_id;
                $new->skill_id = $item;
                $new->save();
            }
        }

        if( count($education) > 0 ){
            foreach( $education as $item ){

                if( Request::input('education_name')[ $item->education_id ] != "" ){
                    $new = new ContractorEducation;
                    $new->contractor_id = $contractor->contractor_id;
                    $new->education_id = $item->education_id;
                    $new->contractor_education_name = Request::input('education_name')[ $item->education_id ];
                    $new->contractor_education_year = Request::input('education_year')[ $item->education_id ];
                    $new->save();
                }
            }
        }



        if( count( Request::input('training_datestart') ) > 0 ){
        	foreach( Request::input('training_datestart') as $key => $item ){

                if(  Request::input('training_datestart')[$key] != ""){
                    $datestart = "";
                    $dateend = "";

            		if( Request::input('training_datestart')[$key] != "" ){
            			$date = explode("/", Request::input('training_datestart')[$key] );
            			$datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
            		}

            		if( Request::input('training_dateend')[$key] != "" ){
            			$date = explode("/", Request::input('training_dateend')[$key] );
            			$dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
            		}

            		$new = new ContractorTraining;
            		$new->contractor_id = $contractor->contractor_id;
            		$new->contractor_training_datestart = $datestart;
            		$new->contractor_training_dateend = $dateend;
            		$new->contractor_training_course = Request::input('course')[$key];
            		$new->contractor_training_department = Request::input('department')[$key];
            		$new->save();
                }
        	}
        }


        if( count( Request::input('experience_datestart') ) > 0 ){
        	foreach( Request::input('experience_datestart') as $key => $item ){


                if( Request::input('experience_datestart')[$key] != "" ){

                    $datestart = "";
                    $dateend = "";

            		if( Request::input('experience_datestart')[$key] != "" ){
            			$date = explode("/", Request::input('experience_datestart')[$key] );
            			$datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
            		}

            		if( Request::input('experience_dateend')[$key] != "" ){
            			$date = explode("/", Request::input('experience_dateend')[$key] );
            			$dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
            		}

            		$new = new ContractorExperience;
            		$new->contractor_id = $contractor->contractor_id;
            		$new->contractor_experience_datestart = $datestart;
            		$new->contractor_experience_dateend = $dateend;
            		$new->contractor_experience_company = Request::input('experience_company')[$key];
            		$new->contractor_experience_position = Request::input('experience_position')[$key];
            		$new->contractor_experience_description = Request::input('experience_description')[$key];
            		$new->contractor_experience_resign = Request::input('experience_resign')[$key];
            		$new->save();
                }
        	}
        }

        if(Request::file('document')){   
            $files = request::file('document');
            foreach($files as $file){
                if( $file != null ){
                    if( in_array($file->getClientOriginalExtension(), $extension_pdf) ){

                        $new_name = str_random(10).".".$file->getClientOriginalExtension();
                        $file->move('storage/uploads/register/document' , $new_name);

                        $new = new ContractorDocument;
                        $new->contractor_id = $contractor->contractor_id;
                        $new->contractor_document_name = $file->getClientOriginalName();
                        $new->contractor_document_file = "storage/uploads/register/document/".$new_name;
                        $new->save();
                    }
                }
            }
        }



        return redirect()->back()->withSuccess("บันทึกข้อมูลเรียบร้อยแล้ว");
	}

}
