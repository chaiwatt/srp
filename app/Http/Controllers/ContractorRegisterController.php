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
use App\Model\LogFile;
use App\Model\Married;
use App\Model\Military;
use App\Model\Religion;
use App\Model\Prefix;


class ContractorRegisterController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
        $filter = Request::input('filter')==""?"":Request::input('filter');

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();

    	$q = Contractor::query();
        $q = $q->where('department_id' , $auth->department_id);
        if( $filter == "" ){
            $q = $q->where('year_budget' , $project->year_budget);
        }
        $q = $q->where('contractor_status' , 1);
        $contractor = $q->get();

        return view('contractor.register.index')->withProject($project)->withContractor($contractor)->withFilter($filter);
    
    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		$education = Education::get();
        $software = Software::get();
        $skill = Skill::get();
        $married = Married::get();
        $military = Military::get();
        $religion = Religion::get();
        $prefix = Prefix::get();
        $position = ContractorPosition::where('department_id' , $auth->department_id)->get();
        
        return view('contractor.register.create')->withProject($project)
                                            ->withEducation($education)
                                            ->withSoftware($software)
                                            ->withMarried($married)
                                            ->withMilitary($military)
                                            ->withPosition($position)
                                            ->withReligion($religion)
                                            ->withPrefix($prefix)
                                            ->withSkill($skill);
	}

    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $extension_picture = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        $extension_pdf = array('pdf');
		$auth = Auth::user();
        $birthday = "";
        $sameaddress = Request::input('chksameaddress') ;

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
		$new->department_id = $auth->department_id;
		$new->section_id = 0;
        $new->position_id = Request::input('position');
        $new->application_no = Request::input('application_no');
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
        $new->moo = Request::input('moo');
        $new->soi = Request::input('soi');
        $new->province_id = Request::input('province');
        $new->amphur_id = Request::input('amphur');
        $new->district_id = Request::input('district');
        $new->postalcode = Request::input('postalcode');

        if (($sameaddress != "") || (Request::input('province_now') == 0) ){
            $new->address_now = Request::input('address');
            $new->moo_now = Request::input('moo');
            $new->soi_now = Request::input('soi');
            $new->province_id_now = Request::input('province');
            $new->amphur_id_now = Request::input('amphur');
            $new->district_id_now = Request::input('district');
            $new->postalcode_now = Request::input('postalcode');
        }else{
            $new->address_now = Request::input('address_now');
            $new->moo_now = Request::input('moo_now');
            $new->soi_now = Request::input('soi_now');
            $new->province_id_now = Request::input('province_now');
            $new->amphur_id_now = Request::input('amphur_now');
            $new->district_id_now = Request::input('district_now');
            $new->postalcode_now = Request::input('postalcode_now');
        }

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

        $new = new LogFile;
        $new->loglist_id = 13;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('contractor/register')->withSuccess("บันทึกข้อมูลเรียบร้อยแล้ว");
	}

    public function EditSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }


        $extension_picture = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        $extension_pdf = array('pdf');
        $auth = Auth::user();
        
        if( Request::input('submit') == "consider" ){

            $contractor = Contractor::where('contractor_id' , Request::input('id'))->where('department_id' , $auth->department_id)->where('contractor_status' , 1)->first();
            if( count($contractor) == 0 ){
                return redirect()->back()->withError("ไม่พอข้อมูลผู้เข้าร่วมโครงการ");
            }

            $update = Contractor::where('contractor_id' , $contractor->contractor_id )->where('contractor_status' , 1)->first();
            $update->contractor_type = Request::input('stackRadio');
            $update->save();

            return redirect('contractor/register')->withSuccess("บันทึกผลพิจารณาเรียบร้อยแล้ว");
        }
        else{

          
            $birthday = "";

            $setting = SettingYear::where('setting_status' , 1)->first();
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $education = Education::get();
            // $assessment = Assessment::get();

            $contractor = Contractor::where('person_id' , Request::input('person_id') )
                            ->where('contractor_status' , 1)
                            ->wherenotin('contractor_id' , [Request::input('id')] )
                            ->first();
              

            if( count($contractor) > 0 ){
                return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว");
            }

            $contractor = Contractor::where('contractor_id' , Request::input('id'))->first();

            if( Request::input('birthday') != $contractor->birthdayinput ){
                $date = explode("/", Request::input('birthday'));
                $birthday = ($date[2]-543)."-".$date[1]."-".$date[0];
            }
            else{
                $birthday = $contractor->birthday;
            }
        
            $new = Contractor::where('contractor_id' , $contractor->contractor_id )->where('contractor_status' , 1)->first();
            
            if(Request::input('starthiredate') != ""){
                $date = explode("/", Request::input('starthiredate'));
                $starthiredate = ($date[2]-543)."-".$date[1]."-".$date[0];
                $new->starthiredate = $starthiredate;
            }

            if(Request::input('endhiredate') != ""){
                $date = explode("/", Request::input('endhiredate'));
                $endhiredate = ($date[2]-543)."-".$date[1]."-".$date[0];
                $new->endhiredate = $endhiredate;
            }

            $new->contractor_type = Request::input('stackRadio');
            $new->project_id = $project->project_id;
            $new->year_budget = $project->year_budget;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
            $new->position_id = Request::input('position');
            $new->application_no = Request::input('application_no');
            $new->contract_no = Request::input('contract_no');
            $new->representativename = Request::input('representativename');
            $new->representativeposition = Request::input('representativeposition');
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

                @unlink( $contractor->picture );
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
            $new->group_id = Request::input('group');
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
            $new->moo = Request::input('moo');
            $new->soi = Request::input('soi');
            $new->province_id = Request::input('province');
            $new->amphur_id = Request::input('amphur');
            $new->district_id = Request::input('district');
            $new->postalcode = Request::input('postalcode');
            $new->address_now = Request::input('address_now');
            $new->moo_now = Request::input('moo_now');
            $new->soi_now = Request::input('soi_now');
            $new->province_id_now = Request::input('province_now');
            $new->amphur_id_now = Request::input('amphur_now');
            $new->district_id_now = Request::input('district_now');
            $new->postalcode_now = Request::input('postalcode_now');
            $new->software_about = Request::input('software_about');
            $new->skill_about = Request::input('skill_about');
            $new->description = Request::input('description');

            $new->save();
            
            if( count($education) > 0 ){
                foreach( $education as $item ){
                
                    $check = ContractorEducation::where('contractor_id' , $contractor->contractor_id)
                    ->where('education_id' , $item->education_id)
                    ->first();

                    if( count($check) > 0 ){
                         ContractorEducation::where('contractor_id' , $contractor->contractor_id)
                         ->where('education_id' , $item->education_id)
                         ->update([ 
                             'contractor_education_name' =>  Request::input('education_name')[ $item->education_id ], 
                             'contractor_education_year' => Request::input('education_year')[ $item->education_id ],
                             ]);
                    }
                    else{
                        $new = new ContractorEducation;
                        $new->contractor_id = $contractor->contractor_id;
                        $new->education_id = $item->education_id;
                        $new->contractor_education_name = Request::input('education_name')[ $item->education_id ];
                        $new->contractor_education_year = Request::input('education_year')[ $item->education_id ];
                        $new->save();
                    }
                }
            }

            $allcontractorexperience = ContractorExperience::where('contractor_id' , $contractor->contractor_id)->orderBy('contractor_experience_id')->get();
            if( count( Request::input('experience_datestart') ) > 0 ){
                foreach( Request::input('experience_datestart') as $key => $item ){
                    echo Request::input('experience_dateend')[$key];
                    if( Request::input('experience_datestart')[$key] !=  ""  ){
                        $date = explode("/", Request::input('experience_datestart')[$key] );
                        $datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
                    }
                    else{
                        $datestart = "";
                    }
        
                    if( Request::input('experience_dateend')[$key] != "" ){
                        $date = explode("/", Request::input('experience_datestart')[$key] );
                        $dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
                    }
                    else{
                        $dateend = "";
                    }
        
                    if(count( @$allcontractorexperience[$key]) > 0){
                        ContractorExperience::where('contractor_id',$contractor->contractor_id)
                                            ->where('contractor_experience_id', $allcontractorexperience[$key]->contractor_experience_id)
                                            ->update([ 
                                                'contractor_experience_datestart' => $datestart, 
                                                'contractor_experience_dateend' => $dateend, 
                                                'contractor_experience_company' => Request::input('experience_company')[$key], 
                                                'contractor_experience_position' => Request::input('experience_position')[$key], 
                                                'contractor_experience_description' => Request::input('experience_description')[$key], 
                                                'contractor_experience_resign' => Request::input('experience_resign')[$key], 
                                            ]);
                
                    }else{
                        if( Request::input('experience_datestart')[$key] != "" ){      
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
            }
            
            unset($number);
            if( count( Request::input('software') ) > 0 ){
                foreach( Request::input('software') as $item ){
                    $q = ContractorSoftware::query();
                    $q = $q->where('contractor_id' , $contractor->contractor_id);
                    $q = $q->where('software_id' , $item);
                    $check = $q->first();
                    if( count( $check ) == 0){
                        $new = new ContractorSoftware;
                        $new->contractor_id = $contractor->contractor_id;
                        $new->software_id = $item;
                        $new->save();
                    }
                    $number[] = $item;
                }
                $q = ContractorSoftware::query();
                $q = $q->where('contractor_id' , $contractor->contractor_id);
                $q = $q->wherenotin( 'software_id' , $number );
                $q = $q->delete();
            }
            else{
                ContractorSoftware::where('contractor_id' , $contractor->contractor_id)->delete();
            }

            unset($number);
            if( count( Request::input('skill') ) > 0 ){
                foreach( Request::input('skill') as $item ){
                    $q = ContractorSkill::query();
                    $q = $q->where('contractor_id' , $contractor->contractor_id);
                    $q = $q->where('skill_id' , $item);
                    $check = $q->first();
                    if( count( $check ) == 0){
                        $new = new ContractorSkill;
                        $new->contractor_id = $contractor->contractor_id;
                        $new->skill_id = $item;
                        $new->save();
                    }
                    $number[] = $item;
                }
                $q = ContractorSkill::query();
                $q = $q->where('contractor_id' , $contractor->contractor_id);
                $q = $q->wherenotin( 'skill_id' , $number );
                $q = $q->delete();
            }
            else{
                ContractorSkill::where('contractor_id' , $contractor->contractor_id)->delete();
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

            $new = new LogFile;
            $new->loglist_id = 14;
            $new->user_id = $auth->user_id;
            $new->save();
        
        return redirect('contractor/register')->withSuccess("แก้ไขข้อมูลเรียบร้อยแล้ว");

        }
    }

    public function Edit($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $education = Education::get();
        $software = Software::get();
        $skill = Skill::get();

        $contractor = Contractor::where('contractor_id' , $id)->where('department_id' , $auth->department_id)->where('contractor_status' , 1)->first();
        if(count($contractor) == 0){
            return redirect()->back();
        }

        $contractoreducation = ContractorEducation::where('contractor_id' , $id)->get();
        $contractortraining = ContractorTraining::where('contractor_id' , $id)->get();
        $contractorexperience = ContractorExperience::where('contractor_id' , $id)->get();
        $contractordocument = ContractorDocument::where('contractor_id' , $id)->get();
        $contractorsoftware = ContractorSoftware::where('contractor_id' , $id)->get();
        $contractorskill = ContractorSkill::where('contractor_id' , $id)->get();

        return view('contractor.register.edit')->withContractor($contractor)
                                        ->withProject($project)
                                        ->withContractoreducation($contractoreducation)
                                        ->withContractortraining($contractortraining)
                                        ->withContractorexperience($contractorexperience)
                                        ->withContractordocument($contractordocument)
                                        ->withContractorskill($contractorskill)
                                        ->withContractorsoftware($contractorsoftware)
                                        ->withEducation($education)
                                        ->withSoftware($software)
                                        ->withSkill($skill);
    }
    public function DeleteFile($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $document = ContractorDocument::where('contractor_document_id' , $id)->first();
        if( count($document) == 0 ){
            return redirect()->back();
        }

        @unlink( $document->contractor_document_file );

        ContractorDocument::where('contractor_document_id' , $id)->delete();

        return redirect()->back()->withSuccess("ลบไฟล์เอกสารเรียบร้อยแล้ว");
    }

    public function Compact($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $q = Contractor::query();
        $q = $q->where('contractor_id' , $id);
        $contractor = $q->first();

        if( count($contractor) == 0 ){
            return redirect()->back();
        }

        $q = ContractorPosition::query();
        $q = $q->where('position_id' , $contractor->position_id);
        $position = $q->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $pdf->loadView("contractor/register/compact" , [ 'contractor' => $contractor , 'position' => $position ]);
        return $pdf->download('ข้อตกลงจ้างเหมา.pdf');
    }

    public function Application($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $q = Contractor::query();
        $q = $q->where('contractor_id' , $id);
        $contractor = $q->first();
        $education = ContractorEducation::where('contractor_id',$id)->get();

        if( count($contractor) == 0 ){
            return redirect()->back();
        }

        $q = ContractorPosition::query();
        $q = $q->where('position_id' , $contractor->position_id);
        $position = $q->first();

        $contractorsoftware = ContractorSoftware::where('contractor_id',$id)->get();
        $contractorskill = ContractorSkill::where('contractor_id',$id)->get();
        $contractorexperience = ContractorExperience::where('contractor_id',$id)->get()->take(5);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $pdf->loadView("contractor/register/application" , [ 
                            'contractor' => $contractor ,
                            'education' => $education , 
                            'position' => $position ,
                            'contractorsoftware' => $contractorsoftware ,
                            'contractorskill' => $contractorskill,
                            'contractorexperience' => $contractorexperience,
                        ]);
        return $pdf->download('เอกสารสมัคร.pdf');
    }

    public function authdepartment(){
        $auth = Auth::user();
        if( $auth->permission != 2 ){
            return true;
        }
        else{
            return false;
        }
    }

}
