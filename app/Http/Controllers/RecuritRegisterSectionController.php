<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Education;
use App\Model\Assessment;
use App\Model\Software;
use App\Model\Skill;
use App\Model\RegisterEducation;
use App\Model\RegisterTraining;
use App\Model\RegisterExperience;
use App\Model\RegisterDocument;
use App\Model\RegisterAssessment;
use App\Model\RegisterSkill;
use App\Model\RegisterSoftware;
use App\Model\Position;
use App\Model\Group;
use App\Model\Married;
use App\Model\Military;
use App\Model\Religion;
use App\Model\Prefix;
use App\Model\Registertype;
use App\Model\Province;
use App\Model\Amphur;
use App\Model\District;
use App\Model\Generate;
use App\Model\LogFile;

class RecuritRegisterSectionController extends Controller{

    public function Compact($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $q = Register::query();
        $q = $q->where('register_id' , $id);
        $register = $q->first();
        $education = RegisterEducation::where('register_id',$id)->get();

        if( count($register) == 0 ){
            return redirect()->back();
        }

        $q = Position::query();
        $q = $q->where('position_id' , $register->position_id);
        $position = $q->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $pdf->loadView("recurit/register/section/compact" , [ 'register' => $register ,'education' => $education , 'position' => $position ]);
        return $pdf->download('ข้อตกลงจ้างงาน.pdf');
    }

        public function CreateCert($id){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $register = Register::where('register_id' , $id)->first();
        
        $position = Position::where('position_id' , $register->position_id)->first();

        return view('recurit.register.section.createcert')->withProject($project)
        ->withRegister($register);
    
    }

    public function CreateCertSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $register = Register::where('register_id' , Request::input('register_id'))->first();

        $position = Position::where('position_id' , $register->position_id)->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $pdf->loadView("recurit/register/section/cert" , [ 
            'register' => $register ,
            'position' => $position ,
            'certdatestart' => Request::input('certdatestart'),
            'certdateend' =>  Request::input('certdateend') ,
            'nummonthwork' => Request::input('nummonthwork') ,
            'certername' => Request::input('certername') ,
            'certerposition' => Request::input('certerposition') ,
            
            ]);
        return $pdf->download('ใบรับรอง.pdf');
    }


    public function Application($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $q = Register::query();
        $q = $q->where('register_id' , $id);
        $register = $q->first();
        $education = RegisterEducation::where('register_id',$id)->get();

        if( count($register) == 0 ){
            return redirect()->back();
        }

        $q = Position::query();
        $q = $q->where('position_id' , $register->position_id);
        $position = $q->first();

        $registersoftware = RegisterSoftware::where('register_id',$id)->get();
        $registerskill = RegisterSkill::where('register_id',$id)->get();
        $registertraining = RegisterTraining::where('register_id',$id)->get()->take(4);

        $registerexperience = RegisterExperience::where('register_id',$id)->get()->take(5);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $pdf->loadView("recurit/register/section/application" , [ 
                            'register' => $register ,
                            'education' => $education , 
                            'position' => $position ,
                            'registersoftware' => $registersoftware ,
                            'registerskill' => $registerskill,
                            'registertraining' => $registertraining,
                            'registerexperience' => $registerexperience,
                        ]);
        return $pdf->download('เอกสารสมัคร.pdf');
    }

    public function downloadregister(){
        
    }

    public function DeleteSave($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $education = Education::get();

        $register = Register::where('register_id' , $id)
                ->where('department_id' , $auth->department_id)
                ->where('section_id' , $auth->section_id)
                ->where('register_status' , 1)
                ->first();
        if(count($register) == 0){
            return redirect()->back();
        }

        $generate = Generate::where('project_id', $project->project_id)->where('register_id',$id)
        ->where('generate_status', 1)->first();

        if(!Empty($generate)){
            return redirect('recurit/register/section')->withError("ไม่สามารถลบผู้กำลังจ้างงาน"); 
        }
        
        $register->register_status = 0;
        $register->save();

        $new = new LogFile;
        $new->loglist_id = 47;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/register/section')->withSuccess("ลบข้อมูลเรียบร้อยแล้ว"); // redirect()->back()->withSuccess("ลบข้อมูลเรียบร้อยแล้ว");
    }

    public function DeleteFile($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $document = RegisterDocument::where('register_document_id' , $id)->first();
        $register_id = $document->register_id;
        if( count($document) == 0 ){
            return redirect()->back();
        }

        @unlink( $document->register_document_file );
        RegisterDocument::where('register_document_id' , $id)->delete();
        return redirect(url('recurit/register/section/edit/'.$register_id))->withSuccess("ลบไฟล์เอกสารเรียบร้อยแล้ว");
    }

    public function EditSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $extension_picture = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        $extension_pdf = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png','pdf','doc','docx','xls','xlsx');
        $auth = Auth::user();
        
        if( Request::input('submit') == "consider" ){

            $register = Register::where('register_id' , Request::input('id'))->where('department_id' , $auth->department_id)->where('section_id' , $auth->section_id)->where('register_status' , 1)->first();
            if( count($register) == 0 ){
                return redirect()->back()->withError("ไม่พอข้อมูลผู้เข้าร่วมโครงการ");
            }

            $update = Register::where('register_id' , $register->register_id )->where('register_status' , 1)->first();
            $update->register_type = Request::input('stackRadio');
            $update->save();

            return redirect('recurit/register/section')->withSuccess("บันทึกผลพิจารณาเรียบร้อยแล้ว");
        }
        else{
            $birthday = "";

            $setting = SettingYear::where('setting_status' , 1)->first();
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $education = Education::get();

            $register = Register::where('person_id' , Request::input('person_id') )
                                ->where('register_status' , 1)
                                ->wherenotin('register_id' , [Request::input('id')] )
                                ->first();

            if( count($register) > 0 ){
                return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว");
            }

        
            $register = Register::where('register_id' , Request::input('id'))->first();

            if( Request::input('birthday') != $register->birthdayinput ){

                $date = explode("/", Request::input('birthday'));
                $birthday = ($date[2]-543)."-".$date[1]."-".$date[0];
            }
            else{

                $birthday = $register->birthday;
            }

            $new = Register::where('register_id' , $register->register_id )->where('register_status' , 1)->first();

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
                        
            $new->register_type = Request::input('stackRadio');
            $new->project_id = $project->project_id;
            $new->year_budget = $project->year_budget;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
            $new->position_id = Request::input('position');
            $new->career = Request::input('career');
            $new->career_future = Request::input('career_future');
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

                @unlink( $register->picture );
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

            $new->register_office_case = Request::input('register_office_case');
            $new->register_number_case = Request::input('register_number_case');
            $new->register_type_case = Request::input('register_type_case');                
            $new->register_year_case = Request::input('register_year_case'); 

            $new->save();

            if( count($education) > 0 ){
                foreach( $education as $item ){
                    $q = RegisterEducation::query();
                    $q = $q->where('register_id' , $register->register_id);
                    $q = $q->where('education_id' , $item->education_id);
                    $check = $q->first();
                    if( count($check) > 0 ){
                        $check->register_education_name = Request::input('education_name')[ $item->education_id ];
                        $check->register_education_year = Request::input('education_year')[ $item->education_id ];
                        $check->save();
                    }
                    else{
                        $new = new RegisterEducation;
                        $new->register_id = $register->register_id;
                        $new->education_id = $item->education_id;
                        $new->register_education_name = Request::input('education_name')[ $item->education_id ];
                        $new->register_education_year = Request::input('education_year')[ $item->education_id ];
                        $new->save();
                    }
                }
            }

            $allregistertraining = RegisterTraining::where('register_id', $register->register_id)->get();
            if( count( Request::input('training_datestart') ) > 0 ){
                foreach( Request::input('training_datestart') as $key => $item ){
                    if( Request::input('training_datestart')[$key] !=  ""  ){
                        $date = explode("/", Request::input('training_datestart')[$key] );
                        $datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
                    }else{
                        $datestart = "";
                    }

                    if( Request::input('training_dateend')[$key] != "" ){
                        $date = explode("/", Request::input('training_dateend')[$key] );
                        $dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
                    }else{
                        $dateend = "";
                    }

                    if(count( @$allregistertraining[$key]) > 0){
                        RegisterTraining::where('register_id',$register->register_id)
                                            ->update([ 
                                                'register_training_datestart' => $datestart , 
                                                'register_training_dateend' => $dateend , 
                                                'register_training_course' => Request::input('course')[$key], 
                                                'register_training_department' => Request::input('department')[$key], 
                                            ]);
                
                    }else{
                        if( Request::input('training_datestart')[$key] != "" ){      
                            $new = new RegisterTraining;
                            $new->register_id = $register->register_id;
                            $new->register_training_datestart = $datestart;
                            $new->register_training_dateend = $dateend;
                            $new->register_training_course = Request::input('course')[$key];
                            $new->register_training_department = Request::input('department')[$key];
                            $new->save();
                        }
                    }
                }
            }

            unset($number);

            $allregisterexperience = RegisterExperience::where('register_id', $register->register_id)->get();
            if( count( Request::input('experience_datestart') ) > 0 ){
                foreach( Request::input('experience_datestart') as $key => $item ){
                    if( Request::input('experience_datestart')[$key] !=  ""  ){
                        $date = explode("/", Request::input('experience_datestart')[$key] );
                        $datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
                    }else{
                        $datestart = "";
                    }

                    if( Request::input('experience_dateend')[$key] != "" ){
                        $date = explode("/", Request::input('experience_dateend')[$key] );
                        $dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
                    }else{
                        $dateend = "";
                    }

                    if(count( @$allregisterexperience[$key]) > 0){
                        RegisterExperience::where('register_id',$register->register_id)
                                            ->update([ 
                                                'register_experience_datestart' => $datestart , 
                                                'register_experience_dateend' => $dateend , 
                                                'register_experience_company' => Request::input('experience_company')[$key], 
                                                'register_experience_position' => Request::input('experience_position')[$key], 
                                                'register_experience_description' => Request::input('experience_description')[$key], 
                                                'register_experience_resign' => Request::input('experience_resign')[$key], 
                                            ]);
                
                    }else{
                        if( Request::input('experience_datestart')[$key] != "" ){      
                            $new = new RegisterExperience;
                            $new->register_experience_datestart = $datestart;
                            $new->register_id = $register->register_id;
                            $new->register_experience_dateend = $dateend;
                            $new->register_experience_company = Request::input('experience_company')[$key];
                            $new->register_experience_position = Request::input('experience_position')[$key];
                            $new->register_experience_description = Request::input('experience_description')[$key];
                            $new->register_experience_resign = Request::input('experience_resign')[$key];
                            $new->save();
                        }
                    }
                }
            }

            unset($number);
            if( count( Request::input('software') ) > 0 ){
                foreach( Request::input('software') as $item ){
                    $q = RegisterSoftware::query();
                    $q = $q->where('register_id' , $register->register_id);
                    $q = $q->where('software_id' , $item);
                    $check = $q->first();
                    if( count( $check ) == 0){
                        $new = new RegisterSoftware;
                        $new->register_id = $register->register_id;
                        $new->software_id = $item;
                        $new->save();
                    }
                    $number[] = $item;
                }
                $q = RegisterSoftware::query();
                $q = $q->where('register_id' , $register->register_id);
                $q = $q->wherenotin( 'software_id' , $number );
                $q = $q->delete();
            }
            else{
                RegisterSoftware::where('register_id' , $register->register_id)->delete();
            }

            unset($number);
            if( count( Request::input('skill') ) > 0 ){
                foreach( Request::input('skill') as $item ){
                    $q = RegisterSkill::query();
                    $q = $q->where('register_id' , $register->register_id);
                    $q = $q->where('skill_id' , $item);
                    $check = $q->first();
                    if( count( $check ) == 0){
                        $new = new RegisterSkill;
                        $new->register_id = $register->register_id;
                        $new->skill_id = $item;
                        $new->save();
                    }
                    $number[] = $item;
                }
                $q = RegisterSkill::query();
                $q = $q->where('register_id' , $register->register_id);
                $q = $q->wherenotin( 'skill_id' , $number );
                $q = $q->delete();
            }
            else{
                RegisterSkill::where('register_id' , $register->register_id)->delete();
            }

            if(Request::file('document')){   
                $files = request::file('document');
                foreach($files as $file){
                  
                    if( $file != null ){
                        if( in_array($file->getClientOriginalExtension(), $extension_pdf) ){

                            $new_name = str_random(10).".".$file->getClientOriginalExtension();
                            $file->move('storage/uploads/register/document' , $new_name);

                            $new = new RegisterDocument;
                            $new->register_id = $register->register_id;
                            $new->register_document_name = $file->getClientOriginalName();
                            $new->register_document_file = "storage/uploads/register/document/".$new_name;
                            $new->save();
                        }
                    }
                }
            }
        }

        $new = new LogFile;
        $new->loglist_id = 46;
        $new->user_id = $auth->user_id;
        $new->save();
        
        return redirect('recurit/register/section')->withSuccess("แก้ไขข้อมูลเรียบร้อยแล้ว");

    }

    public function Edit($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $software = Software::get();
        $skill = Skill::get();

        $education = Education::get();
        $software = Software::get();
        $skill = Skill::get();
        $group = Group::where('department_id',$auth->department_id)->get();
        $married = Married::get();
        $military = Military::get();
        $religion = Religion::get();
        $prefix = Prefix::get();
        $registertype = Registertype::where('department_id',$auth->department_id)->get();
        $position = Position::where('department_id',$auth->department_id)->get();

        $register = Register::where('register_id' , $id)->where('department_id' , $auth->department_id)->where('section_id' , $auth->section_id)->where('register_status' , 1)->first();
        if(count($register) == 0){
            return redirect()->back();
        }

        $registereducation = RegisterEducation::where('register_id' , $id)->get();
        $registertraining = RegisterTraining::where('register_id' , $id)->get();
        $registerexperience = RegisterExperience::where('register_id' , $id)->get();
        $registerdocument = RegisterDocument::where('register_id' , $id)->get();
        $registersoftware = RegisterSoftware::where('register_id' , $id)->get();
        $registerskill = RegisterSkill::where('register_id' , $id)->get();
        $province = Province::get();
        $amphur = Amphur::where('province_id',$register->province_id )->get();
        $district = District::where('province_id',$register->province_id )
                            ->where('amphur_id',$register->amphur_id )
                            ->get();

        $amphurnow = Amphur::where('province_id',$register->province_id_now )->get();
        $districtnow = District::where('province_id',$register->province_id_now )
                            ->where('amphur_id',$register->amphur_id_now )
                            ->get();

        return view('recurit.register.section.edit')->withRegister($register)->withProject($project)
                                                ->withRegistereducation($registereducation)
                                                ->withRegistertraining($registertraining)
                                                ->withRegisterexperience($registerexperience)
                                                ->withRegisterdocument($registerdocument)
                                                ->withPosition($position)
                                                ->withPrefix($prefix)
                                                ->withMarried($married)
                                                ->withGroup($group)
                                                ->withReligion($religion)
                                                ->withMilitary($military)
                                                ->withRegistertype($registertype)
                                                ->withRegisterskill($registerskill)
                                                ->withRegistersoftware($registersoftware)
                                                ->withEducation($education)
                                                ->withSoftware($software)
                                                ->withProvince($province)
                                                ->withAmphur($amphur)
                                                ->withDistrict($district)
                                                ->withSkill($skill);
    }

	public function CreateSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }

    //   return  Request::input('register_type_case');
        $extension_picture = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        $extension_pdf = array('pdf');

		$auth = Auth::user();

        $sameaddress = Request::input('chksameaddress') ;
		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		$education = Education::get();

		$register = Register::where('person_id' , Request::input('person_id') )->first();
		if( count($register) > 0 ){
			return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว");
		}

		if( Request::input('birthday') != "" ){
			$date = explode("/", Request::input('birthday'));
        	$birthday = ($date[2]-543)."-".$date[1]."-".$date[0];
		}

		$new = new Register;
		$new->project_id = $project->project_id;
		$new->year_budget = $project->year_budget;
		$new->department_id = $auth->department_id;
		$new->section_id = $auth->section_id;
		$new->position_id = Request::input('position');
		$new->career = Request::input('career');
        $new->career_future = Request::input('career_future');
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
        $new->register_office_case = Request::input('register_office_case');
        $new->register_number_case = Request::input('register_number_case');         
        $new->register_year_case = Request::input('register_year_case');   

        if(Request::input('register_type_case') != ""){
            $new->register_type_case = Request::input('register_type_case');  
        }else{
            $new->register_type_case = "";  
        }
        $new->save();

        $register = Register::orderBy('register_id' , 'desc')->first();

        if( count( Request::input('software') ) > 0 ){
        	foreach( Request::input('software') as $item ){
            	$new = new RegisterSoftware;
            	$new->register_id = $register->register_id;
                $new->software_id = $item;
            	$new->save();
        	}
        }

        if( count( Request::input('skill') ) > 0 ){
            foreach( Request::input('skill') as $item ){
                $new = new RegisterSkill;
                $new->register_id = $register->register_id;
                $new->skill_id = $item;
                $new->save();
            }
        }

        if( count($education) > 0 ){
            foreach( $education as $item ){

                if( Request::input('education_name')[ $item->education_id ] != "" ){
                    $new = new RegisterEducation;
                    $new->register_id = $register->register_id;
                    $new->education_id = $item->education_id;
                    $new->register_education_name = Request::input('education_name')[ $item->education_id ];
                    $new->register_education_year = Request::input('education_year')[ $item->education_id ];
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

            		$new = new RegisterTraining;
            		$new->register_id = $register->register_id;
            		$new->register_training_datestart = $datestart;
            		$new->register_training_dateend = $dateend;
            		$new->register_training_course = Request::input('course')[$key];
            		$new->register_training_department = Request::input('department')[$key];
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

            		$new = new RegisterExperience;
            		$new->register_id = $register->register_id;
            		$new->register_experience_datestart = $datestart;
            		$new->register_experience_dateend = $dateend;
            		$new->register_experience_company = Request::input('experience_company')[$key];
            		$new->register_experience_position = Request::input('experience_position')[$key];
            		$new->register_experience_description = Request::input('experience_description')[$key];
            		$new->register_experience_resign = Request::input('experience_resign')[$key];
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

                        $new = new RegisterDocument;
                        $new->register_id = $register->register_id;
                        $new->register_document_name = $file->getClientOriginalName();
                        $new->register_document_file = "storage/uploads/register/document/".$new_name;
                        $new->save();
                    }
                }
            }
        }

        $new = new LogFile;
        $new->loglist_id = 45;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/register/section')->withSuccess("บันทึกข้อมูลเรียบร้อยแล้ว");

	}

	public function Create(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		$education = Education::get();
        $software = Software::get();
        $skill = Skill::get();
        $group = Group::where('department_id',$auth->department_id)->get();
        $married = Married::get();
        $military = Military::get();
        $religion = Religion::get();
        $prefix = Prefix::get();
        $registertype = Registertype::where('department_id',$auth->department_id)->get();
        $position = Position::where('department_id',$auth->department_id)->get();

        return view('recurit.register.section.create')->withProject($project)
                                            ->withEducation($education)
                                            ->withGroup($group)
                                            ->withMarried($married)
                                            ->withMilitary($military)
                                            ->withSoftware($software)
                                            ->withReligion($religion)
                                            ->withPrefix($prefix)
                                            ->withPosition($position)
                                            ->withRegistertype($registertype)
                                            ->withSkill($skill);
	}

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
        $filter = Request::input('filter')==""?"":Request::input('filter');

		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $employ = Generate::where('project_id' , $project->project_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->get();
		
    	$q = Register::query();
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        if( $filter == "" ){
            $q = $q->where('year_budget' , $project->year_budget);
        }
        $q = $q->where('register_status' , 1);
        $q = $q->orderBy('position_id');
        $register = $q->get();

        return view('recurit.register.section.index')->withProject($project)
                                                ->withRegister($register)
                                                ->withEmploy($employ)
                                                ->withFilter($filter);
    }

    public function authsection(){
        $auth = Auth::user();
        if( $auth->permission != 3 ){
            return true;
        }
        else{
            return false;
        }
    }

}


