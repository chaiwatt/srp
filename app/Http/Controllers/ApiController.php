<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use Hash;

use App\Model\Budget;
use App\Model\Department;
use App\Model\SettingYear;
use App\Model\SettingBudget;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\Section;
use App\Model\Allocation;
use App\Model\Prefix;
use App\Model\Religion;
use App\Model\Married;
use App\Model\Military;
use App\Model\Skill;
use App\Model\Software;
use App\Model\Province;
use App\Model\District;
use App\Model\Amphur;
use App\Model\Position;
use App\Model\Group;
use App\Model\Register;
use App\Model\Users;
use App\Model\Generate;
use App\Model\Registertype;
use App\Model\Payment;
use App\Model\ProjectReadiness;
use App\Model\ProjectParticipate;
use App\Model\ParticipateGroup;
use App\Model\Trainer;
use App\Model\ProjectReadinessOfficer;
use App\Model\Company;
use App\Model\ContractorPosition;
use App\Model\Contractor;
use App\Model\ContractorExperience;
use App\Model\FollowupSection;
use App\Model\FollowupInterview;
use App\Model\InterViewer;
use App\Model\RegisterExperience;
use App\Model\RegisterTraining;
use App\Model\Assessor;
use App\Model\PersonalAssessment;
use App\Model\ReadinessSection;
use App\Model\RegisterAssesmentFit;
use App\Model\RegisterAssessment;

class ApiController extends Controller{
    public function CheckWinLogin (){
        $user = Users::where('username' , Request::input('username'))->first();
        if( !empty($user)  ){
            if( Hash::check( Request::input('password') , $user->password  ) ){
                return $user;
            }
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ" . Request::input('password');
            }
        }   
        else{
            return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
        }
    }
    // กรมคุมประพฤติ
    public function RegisterSmartCardByDept(){
        $user = Users::where('username' , Request::input('username'))->first();
        if( !empty($user)  ){
            if( Hash::check( Request::input('password') , $user->password  ) ){

                $setting = SettingYear::where('setting_status' , 1)->first();
                $project = Project::where('year_budget' , $setting->setting_year)->first();

                $prefix = Request::input('prefix');
                $name = Request::input('name');
                $lastname = Request::input('lastname');
                $person_id = Request::input('person_id');
                $birthday = Request::input('birthday');
                $nationality = Request::input('nationality');
                $ethnicity = Request::input('ethnicity');
                $religion = Request::input('religion');

                $married = Request::input('married');
                $register_type = Request::input('register_type');
                $register_year = Request::input('register_year');
                $register_number = Request::input('register_number');
                $register_office = Request::input('register_office');
                $_father = Request::input('father');                
               
                $f = explode(" ", $_father);
                $father_name =  $f[0];
                $father_lastname =  $f[1];
                $_mother = Request::input('mother');

                $m = explode(" ", $_mother);
                $mother_name =  $m[0];
                $mother_lastname =  $m[1];

                $address = Request::input('address1')  ;
                $moo = Request::input('moo1');
                $soi = Request::input('soi1') ;
                $province = Request::input('province1');
                $amphur = Request::input('amphur1');
                $district = Request::input('district1');
                $postal = Request::input('postal1');

                $address_now = Request::input('address2') ;
                $moo_now = Request::input('moo2');
                $soi_now = Request::input('soi2') ;
                $province_now = Request::input('province2');
                $amphur_now = Request::input('amphur2');
                $district_now = Request::input('district2');
                $postal_now = Request::input('postal2');

                if( $person_id == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลบัตรประชาชน";
                }

                $q = Register::query();
                $q = $q->where('person_id' , $person_id);
                $q = $q->where('register_status' , 1);
                $register = $q->first();
                if(!empty($register) ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว";
                }

                if( $religion == "พุทธ" ){
                    $religion_id = 1;
                }
                elseif( $religion == "คริสต์" ){
                    $religion_id = 2;
                }
                elseif( $religion == "อิสลาม" ){
                    $religion_id = 3;
                }
                elseif( $religion == "ซิกส์" ){
                    $religion_id = 4;
                }
                elseif( $religion == "ฮินดู" ){
                    $religion_id = 5;
                }
                else{
                    $religion_id = 6;
                }

                if( $birthday == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลวันเดือนปีเดิด";
                }

                $day = substr( $birthday , 0 , 2);
                $month  = substr( $birthday , 2 , 2);
                $year = substr( $birthday , -4);
                $birthday = ($year-543)."-".$month."-".$day;

                $new = new Register;
                $new->project_id = $project->project_id;
                $new->year_budget = $project->year_budget;
                $new->department_id = $user->department_id;
                $new->section_id = $user->section_id;
                $new->person_id = $person_id;
                $new->prefix_id = $prefix;
                $new->name = $name;
                $new->lastname = $lastname;
                $new->birthday = $birthday;
                $new->nationality = $nationality;
                $new->ethnicity = $ethnicity;
                $new->religion_id = $religion_id;
                // $new->group_id = 25;

                $new->married_id = $married;
                $new->register_type_case = $register_type;
                $new->register_year_case = $register_year;
                $new->register_number_case = $register_number;
                $new->register_office_case = $register_office;

                $new->father_name = $father_name;
                $new->father_lastname = $father_lastname;
                $new->mother_name = $mother_name;
                $new->mother_lastname = $mother_lastname;
            
                $new->address = $address;
                $new->moo = $moo;
                $new->soi = $soi;
                $new->province_id = Province::where('province_code',$province )->first()->province_id ;
                $new->amphur_id = Amphur::where('amphur_code',$amphur)->first()->amphur_id ;
                $new->district_id = District::where('district_code',$district)->first()->district_id ;
                $new->postalcode = $postal;

                $new->address_now = $address_now;
                $new->moo_now = $moo_now;
                $new->soi_now = $soi_now;
                $new->province_id_now = Province::where('province_code',$province_now)->first()->province_id;
                $new->amphur_id_now = Amphur::where('amphur_code',$amphur_now)->first()->amphur_id ; 
                $new->district_id_now = District::where('district_code',$district_now)->first()->district_id ;
                $new->postalcode_now = $postal_now;
                
                $new->register_status = 1;
                $new->register_type = 0;
                $new->save();

                return "บันทึกข้อมูลเรียบร้อยแล้ว";
            }
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ" . Request::input('password');
            }
        }   
        else{
            return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
        }
    }
//กรมราชทัณฑ์
    public function RegisterSmartCardByDeptRT(){
        $user = Users::where('username' , Request::input('username'))->first();
        if( !empty($user)  ){
            if( Hash::check( Request::input('password') , $user->password  ) ){
                $setting = SettingYear::where('setting_status' , 1)->first();
                $project = Project::where('year_budget' , $setting->setting_year)->first();
                $prefix = Request::input('prefix');
                $name = Request::input('name');
                $lastname = Request::input('lastname');
                $person_id = Request::input('person_id');
                $birthday = Request::input('birthday');
                $nationality = Request::input('nationality');
                $ethnicity = Request::input('ethnicity');
                $religion = Request::input('religion');
                $married = Request::input('married');
                $register_type = Request::input('register_type');
                $_father = Request::input('father');                 
                $f = explode(" ", $_father);
                $father_name =  $f[0];
                $father_lastname =  $f[1];
                $_fathercareer = Request::input('fathercareer');  
                $_mother = Request::input('mother');
                $m = explode(" ", $_mother);
                $mother_name =  $m[0];
                $mother_lastname =  $m[1];
                $_mothercareer = Request::input('mothercareer');  
                $_contact = Request::input('contact');
                $c = explode(" ", $_contact);
                $contact_name =  $c[0];
                $contact_lastname =  $c[1];
                $_contactrelation = Request::input('contactrelation');  
                $_contactphone = Request::input('contactphone');  
                $address = Request::input('address1')  ;
                $moo = Request::input('moo1');
                $soi = Request::input('soi1') ;
                $province = Request::input('province1');
                $amphur = Request::input('amphur1');
                $district = Request::input('district1');
                $postal = Request::input('postal1');
                $address_now = Request::input('address2') ;
                $moo_now = Request::input('moo2');
                $soi_now = Request::input('soi2') ;
                $province_now = Request::input('province2');
                $amphur_now = Request::input('amphur2');
                $district_now = Request::input('district2');
                $postal_now = Request::input('postal2');
                if( $person_id == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลบัตรประชาชน";
                }

                $q = Register::query();
                $q = $q->where('person_id' , $person_id);
                $q = $q->where('register_status' , 1);
                $register = $q->first();
                if(!empty($register) ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว";
                }

                if( $religion == "พุทธ" ){
                    $religion_id = 1;
                }
                elseif( $religion == "คริสต์" ){
                    $religion_id = 2;
                }
                elseif( $religion == "อิสลาม" ){
                    $religion_id = 3;
                }
                elseif( $religion == "ซิกส์" ){
                    $religion_id = 4;
                }
                elseif( $religion == "ฮินดู" ){
                    $religion_id = 5;
                }
                else{
                    $religion_id = 6;
                }

                if( $birthday == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลวันเดือนปีเดิด";
                }

                $day = substr( $birthday , 0 , 2);
                $month  = substr( $birthday , 2 , 2);
                $year = substr( $birthday , -4);
                $birthday = ($year-543)."-".$month."-".$day;

                $new = new Register;
                $new->project_id = $project->project_id;
                $new->year_budget = $project->year_budget;
                $new->department_id = $user->department_id;
                $new->section_id = $user->section_id;
                $new->person_id = $person_id;
                $new->prefix_id = $prefix;
                $new->name = $name;
                $new->lastname = $lastname;
                $new->birthday = $birthday;
                $new->nationality = $nationality;
                $new->ethnicity = $ethnicity;
                $new->religion_id = $religion_id;

                $new->married_id = $married;

                $new->father_name = $father_name;
                $new->father_lastname = $father_lastname;
                $new->father_career = $_fathercareer;

                $new->mother_name = $mother_name;
                $new->mother_lastname = $mother_lastname;
                $new->mother_career = $_mothercareer;
            
                $new->urgent_name = $contact_name;
                $new->urgent_lastname = $contact_lastname;
                $new->urgent_relationship = $_contactrelation;
                $new->urgent_phone = $_contactphone;

                $new->address = $address;
                $new->moo = $moo;
                $new->soi = $soi;
                $new->province_id = $province ;
                $new->amphur_id = $amphur ;
                $new->district_id = $district ;
                $new->postalcode = $postal;

                $new->address_now = $address_now;
                $new->moo_now = $moo_now;
                $new->soi_now = $soi_now;
                $new->province_id_now = $province_now;
                $new->amphur_id_now = $amphur_now ; 
                $new->district_id_now =$district_now;
                $new->postalcode_now = $postal_now;
                
                $new->register_status = 1;
                $new->register_type = 0;
                $new->save();

                return "บันทึกข้อมูลเรียบร้อยแล้ว";
            }
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ" . Request::input('password');
            }
        }   
        else{
            return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
        }
    }

    //กรมพินิจ
    public function RegisterSmartCardByDeptPN(){
        $user = Users::where('username' , Request::input('username'))->first();
        if( !empty($user)  ){
            if( Hash::check( Request::input('password') , $user->password  ) ){
                $setting = SettingYear::where('setting_status' , 1)->first();
                $project = Project::where('year_budget' , $setting->setting_year)->first();
                $prefix = Request::input('prefix');
                $name = Request::input('name');
                $lastname = Request::input('lastname');
                $person_id = Request::input('person_id');
                $birthday = Request::input('birthday');
                $nationality = Request::input('nationality');
                $ethnicity = Request::input('ethnicity');
                $religion = Request::input('religion');
                $married = Request::input('married');
                $register_type = Request::input('register_type');
                $_father = Request::input('father');                 
                $f = explode(" ", $_father);
                $father_name =  $f[0];
                $father_lastname =  $f[1];
                $_fathercareer = Request::input('fathercareer');  
                $_mother = Request::input('mother');
                $m = explode(" ", $_mother);
                $mother_name =  $m[0];
                $mother_lastname =  $m[1];
                $_mothercareer = Request::input('mothercareer');  
                $_contact = Request::input('contact');
                $c = explode(" ", $_contact);
                $contact_name =  $c[0];
                $contact_lastname =  $c[1];
                $_contactrelation = Request::input('contactrelation');  
                $_contactphone = Request::input('contactphone');  
                $address = Request::input('address1')  ;
                $moo = Request::input('moo1');
                $soi = Request::input('soi1') ;
                $province = Request::input('province1');
                $amphur = Request::input('amphur1');
                $district = Request::input('district1');
                $postal = Request::input('postal1');
                $address_now = Request::input('address2') ;
                $moo_now = Request::input('moo2');
                $soi_now = Request::input('soi2') ;
                $province_now = Request::input('province2');
                $amphur_now = Request::input('amphur2');
                $district_now = Request::input('district2');
                $postal_now = Request::input('postal2');
                if( $person_id == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลบัตรประชาชน";
                }

                $q = Register::query();
                $q = $q->where('person_id' , $person_id);
                $q = $q->where('register_status' , 1);
                $register = $q->first();
                if(!empty($register) ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว";
                }

                if( $religion == "พุทธ" ){
                    $religion_id = 1;
                }
                elseif( $religion == "คริสต์" ){
                    $religion_id = 2;
                }
                elseif( $religion == "อิสลาม" ){
                    $religion_id = 3;
                }
                elseif( $religion == "ซิกส์" ){
                    $religion_id = 4;
                }
                elseif( $religion == "ฮินดู" ){
                    $religion_id = 5;
                }
                else{
                    $religion_id = 6;
                }

                if( $birthday == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลวันเดือนปีเดิด";
                }

                $day = substr( $birthday , 0 , 2);
                $month  = substr( $birthday , 2 , 2);
                $year = substr( $birthday , -4);
                $birthday = ($year-543)."-".$month."-".$day;

                $new = new Register;
                $new->project_id = $project->project_id;
                $new->year_budget = $project->year_budget;
                $new->department_id = $user->department_id;
                $new->section_id = $user->section_id;
                $new->person_id = $person_id;
                $new->prefix_id = $prefix;
                $new->name = $name;
                $new->lastname = $lastname;
                $new->birthday = $birthday;
                $new->nationality = $nationality;
                $new->ethnicity = $ethnicity;
                $new->religion_id = $religion_id;

                $new->married_id = $married;

                $new->father_name = $father_name;
                $new->father_lastname = $father_lastname;
                $new->father_career = $_fathercareer;

                $new->mother_name = $mother_name;
                $new->mother_lastname = $mother_lastname;
                $new->mother_career = $_mothercareer;
            
                $new->urgent_name = $contact_name;
                $new->urgent_lastname = $contact_lastname;
                $new->urgent_relationship = $_contactrelation;
                $new->urgent_phone = $_contactphone;

                $new->address = $address;
                $new->moo = $moo;
                $new->soi = $soi;
                $new->province_id = $province ;
                $new->amphur_id = $amphur ;
                $new->district_id = $district ;
                $new->postalcode = $postal;

                $new->address_now = $address_now;
                $new->moo_now = $moo_now;
                $new->soi_now = $soi_now;
                $new->province_id_now = $province_now;
                $new->amphur_id_now = $amphur_now ; 
                $new->district_id_now =$district_now;
                $new->postalcode_now = $postal_now;
                
                $new->register_status = 1;
                $new->register_type = 0;
                $new->save();

                return "บันทึกข้อมูลเรียบร้อยแล้ว";
            }
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ" . Request::input('password');
            }
        }   
        else{
            return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
        }
    }

    //ทะเบียนราษฎร์
    public function RegisterSmartCardGovernment(){
        $user = Users::where('username' , Request::input('username'))->first();
        if( !empty($user)  ){
            if( Hash::check( Request::input('password') , $user->password  ) ){

                $setting = SettingYear::where('setting_status' , 1)->first();
                $project = Project::where('year_budget' , $setting->setting_year)->first();

                $name = Request::input('name');
                $lastname = Request::input('lastname');
                $person_id = Request::input('person_id');
                $birthday = Request::input('birthday');
                $nationality = Request::input('nationality');
                $ethnicity = Request::input('ethnicity');
                $prefix = Request::input('prefix');
                $address = Request::input('address');

                if( $person_id == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลบัตรประชาชน";
                }

                $q = Register::query();
                $q = $q->where('person_id' , $person_id);
                $q = $q->where('register_status' , 1);
                $register = $q->first();
                if(!empty($register) ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว";
                }

                if( $prefix == "นาย" ){
                    $prefix = 1;
                }
                elseif( $prefix == "นาง" ){
                    $prefix = 2;
                }
                elseif( $prefix == "นางสาว" ){
                    $prefix = 3;
                }
                elseif( $prefix == "เด็กชาย" ){
                    $prefix = 4;
                }
                elseif( $prefix == "เด็กหญิง" ){
                    $prefix = 5;
                }
                else{
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากคำนำหน้าชื่อไม่ถูกตอง";
                }

                if( $birthday == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลวันเดือนปีเดิด";
                }

                $day = substr( $birthday , 0 , 2);
                $month  = substr( $birthday , 2 , 2);
                $year = substr( $birthday , -4);
                $birthday = ($year-543)."-".$month."-".$day;

                $new = new Register;
                $new->project_id = $project->project_id;
                $new->year_budget = $project->year_budget;
                $new->department_id = $user->department_id;
                $new->section_id = $user->section_id;
                $new->person_id = $person_id;
                $new->name = $name;
                $new->lastname = $lastname;
                $new->prefix_id = $prefix;
                $new->birthday = $birthday;
                $new->nationality = $nationality;
                $new->ethnicity = $ethnicity;
                $new->address = $address;
                $new->register_status = 1;
                $new->register_type = 0;
                $new->save();

                return "บันทึกข้อมูลเรียบร้อยแล้ว";
            }
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
            }
        }   
        else{
            return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
        }
    }

    // Offline Smart card
    public function RegisterSmartCard(){
        $user = Users::where('username' , Request::input('username'))->first();
        if( !empty($user)  ){
            if( Hash::check( Request::input('password') , $user->password  ) ){

                $setting = SettingYear::where('setting_status' , 1)->first();
                $project = Project::where('year_budget' , $setting->setting_year)->first();

                $name = Request::input('name');
                $lastname = Request::input('lastname');
                $person_id = Request::input('person_id');
                $birthday = Request::input('birthday');
                $nationality = Request::input('nationality');
                $ethnicity = Request::input('ethnicity');
                $prefix = Request::input('prefix');
                 $homeno = Request::input('homeno');
                 $address = Request::input('address');
                 $disttrictid = Request::input('disttrictid');
                 $amphurid = Request::input('amphurid');
                 $provinceid = Request::input('provinceid');

                if( $person_id == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลบัตรประชาชน";
                }

                $q = Register::query();
                $q = $q->where('person_id' , $person_id);
                $q = $q->where('register_status' , 1);
                $register = $q->first();
                if(!empty($register) ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสบัตรประชาชนนี้มีอยู่ในระบบแล้ว";
                }

                if( $prefix == "นาย" ){
                    $prefix = 1;
                }
                elseif( $prefix == "นาง" ){
                    $prefix = 2;
                }
                elseif( $prefix == "นางสาว" ){
                    $prefix = 3;
                }
                elseif( $prefix == "เด็กชาย" ){
                    $prefix = 4;
                }
                elseif( $prefix == "เด็กหญิง" ){
                    $prefix = 5;
                }
                else{
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากคำนำหน้าชื่อไม่ถูกตอง";
                }

                if( $birthday == "" ){
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลวันเดือนปีเดิด";
                }


                $day = substr( $birthday , 0 , 2);
                $month  = substr( $birthday , 2 , 2);
                $year = substr( $birthday , -4);
                $birthday = ($year-543)."-".$month."-".$day;

                $new = new Register;
                $new->project_id = $project->project_id;
                $new->year_budget = $project->year_budget;
                $new->department_id = $user->department_id;
                $new->section_id = $user->section_id;
                $new->person_id = $person_id;
                $new->name = $name;
                $new->lastname = $lastname;
                $new->prefix_id = $prefix;
                $new->birthday = $birthday;
                $new->nationality = $nationality;
                $new->ethnicity = $ethnicity;
 
                $new->address = $homeno;
                $new->moo = $address;
                $new->province_id = $provinceid;
                $new->amphur_id = $amphurid;
                $new->district_id = $disttrictid;

                $new->address_now = $homeno;
                $new->moo_now = $homeno;
                $new->province_id_now = $provinceid;
                $new->amphur_id_now = $amphurid;
                $new->district_id_now = $disttrictid;

                $new->register_status = 1;
                $new->register_type = 0;
                $new->save();

                return "บันทึกข้อมูลเรียบร้อยแล้ว";
            }
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
            }
        }   
        else{
            return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
        }
    }

        // Offline Smart card
        public function AddAssessment(){
            $user = Users::where('username' , Request::input('username'))->first();
            if( !empty($user)  ){
                if( Hash::check( Request::input('password') , $user->password  ) ){
    
                    $setting = SettingYear::where('setting_status' , 1)->first();
                    $project = Project::where('year_budget' , $setting->setting_year)->first();
    
                    $person_id = Request::input('person_id');
                    $realistic = Request::input('realistic');
                    $investigative = Request::input('investigative');
                    $artistic = Request::input('artistic');
                    $social = Request::input('social');
                    $conventional = Request::input('conventional');
                    $enterprising = Request::input('enterprising');
                    $entrepreneuiral = Request::input('entrepreneuiral');
                    $crosscultural = Request::input('crosscultural');
                    $adaptability = Request::input('adaptability');
                    $teamwork = Request::input('teamwork');
    
                    if( $person_id == "" ){
                        return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบข้อมูลบัตรประชาชน";
                    }
    
                    $register = Register::where('person_id' , $person_id)
                            ->where('register_status' , 1)
                            ->first();
                    if(empty($register) ){
                        return "ไม่พบผู้สมัครในโครงการ";
                    }
                    $regid= $register->register_id;

                    $generate = Generate::where('register_id' , $regid)
                    ->where('generate_status' , 1)
                    ->first();

                    if(empty($generate) ){
                        return "ไม่พบผู้สมัครไม่ได้คัดเลือกให้จ้างงาน";
                    }

                    $registersassesmentfit = RegisterAssesmentFit::where('register_id' , $regid)
                    ->orderBy('register_assesment_fit_id', 'desc')
                            ->first();
                    
                    $registeraassesmentfitid =0;
                    if(empty($registersassesmentfit) ){
                        $new = new RegisterAssesmentFit;
                        $new->project_id = $project->project_id;
                        $new->department_id = $user->department_id;
                        $new->section_id = $user->section_id;
                        $new->register_id = $regid;
                        $new->occupationbefore = "ไม่ระบุ";
                        $new->needhelp = "";
                        $new->needrecommend = "";
                        $new->save();

                        $registersassesmentfit = RegisterAssesmentFit::where('register_id' , $regid)
                        ->first();
                    }

                    $registeraassesmentfitid = $registersassesmentfit->register_assesment_fit_id;

                    RegisterAssessment::where('register_id' , $regid)
                    ->where('register_assesment_fit_id',$registeraassesmentfitid )
                    ->delete();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 1;
                    $new->register_assessment_point = $realistic;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 2;
                    $new->register_assessment_point = $investigative;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 3;
                    $new->register_assessment_point = $artistic;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 4;
                    $new->register_assessment_point = $social;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 5;
                    $new->register_assessment_point = $conventional;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 6;
                    $new->register_assessment_point = $enterprising;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 7;
                    $new->register_assessment_point = $entrepreneuiral;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 8;
                    $new->register_assessment_point = $crosscultural;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 9;
                    $new->register_assessment_point = $adaptability;
                    $new->save();

                    $new = new RegisterAssessment;
                    $new->register_id = $regid;
                    $new->project_id = $project->project_id;
                    $new->department_id = $user->department_id;
                    $new->section_id = $user->section_id;
                    $new->register_assesment_fit_id = $registeraassesmentfitid;
                    $new->assessment_id = 10;
                    $new->register_assessment_point = $teamwork;
                    $new->save();

                    return "บันทึกข้อมูลเรียบร้อยแล้ว";
                }
                else{
                    return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
                }
            }   
            else{
                return "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่พบผู้ใช้งานนี้ในระบบ";
            }
        }

    public function RegisterPerson(){
        $auth = Auth::user();

        if(strlen( Request::input('person_id') ) != 13){ 
            return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากรูปแบบไม่ถูกต้อง";
        }
        else{
            for($i=0, $sum=0; $i<12;$i++){
                $sum += (int)( Request::input('person_id')[$i] ) * (13-$i);
            }
            if((11-($sum%11))%10 == (int)(Request::input('person_id')[12] ) ){
                $q = Register::where('person_id' , Request::input('person_id'))->where('register_status' , 1)->first();
                if( !empty($q) ){
                    return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากมีอยู่ในระบบแล้ว";
                }
                else{
                    return "สามารถใช้รหัสบัตรประชาชนนี้ได้";
                }
            }
            else{
                return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากรูปแบบไม่ถูกต้อง";
            }
        }
    } //จบ function ตรวจสอบ เลขบัตรประชาชน

    public function RegisterContractor(){
        $personid = Request::input('person_id');
        if(strlen( $personid ) != 13){ 
            return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากรูปแบบไม่ถูกต้อง bbb";
        }
        else{
            for($i=0, $sum=0; $i<12;$i++){
                $sum += (int)( $personid[$i] ) * (13-$i);
            }
            if((11-($sum%11))%10 == (int)($personid[12] ) ){
                
                 $q = Contractor::where('person_id' , $personid)->where('contractor_status' , 1)->first();
                if( !empty($q) ){
                    return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากมีอยู่ในระบบแล้ว";
                }
                else{
                    return "สามารถใช้รหัสบัตรประชาชนนี้ได้";
                }
            }
            else{
                return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากรูปแบบไม่ถูกต้อง aaa";
            }
        }
    } //จบ function ตรวจสอบ เลขบัตรประชาชน


    public function CheckPerson(){
        $auth = Auth::user();
        $groupname = "";
        $register = Register::where('person_id' , Request::input('person_id'))
                        ->where('department_id' , Request::input('department_id'))
                        ->where('register_status' , 1)
                        ->get();
        //$register = Register::where('person_id' , '9428233509035')->where('register_status' , 1)->get();
        if( $register->count() > 0){
            $prefix = Prefix::where('prefix_id',$register->first()->prefix_id)->first()->prefix_name;
            $sectionname = Section::where('section_id',$register->first()->section_id)->first()->section_name;
            $_groupname = Group::where('group_id',$register->first()->group_id)->get();
            if($_groupname->count() > 0){
                $groupname = $_groupname->first()->group_name;
            }
    
            $customarray[] = array('prefix' => $prefix , 'section_name' => $sectionname , 'group_name' => $groupname ); 
    
            $customdata = collect( $customarray );
            return json_encode(array("register" => $register,"row" => $register->count(),"customdata" => $customdata, 'register_filter' => Request::input('register') ));
        }else{
            $customarray[] = array('prefix' => "" , 'section_name' => "" , 'group_name' => ""); 
            $customdata = collect( $customarray );
            return json_encode(array("register" => $register,"row" => $register->count(),"customdata" => $customdata, 'register_filter' => Request::input('register') ));
        }

    } 

    public function SectionExist(){
        $auth = Auth::user();
        $section = Section::where('section_id', Request::input('section_id'))
                    ->where('department_id',$auth->department_id)
                    ->first();
        if(!empty($section)){ 
            return "ไม่พบรหัส สำนักงานเจ้าของคดี";
        }else{
            return $section->section_name;
        }
    }
    
    public function DeleteParticipate(){
        $auth = Auth::user();
        $articipategroup = ParticipateGroup::where('register_id', Request::input('register_id'))
                    ->where('project_readiness_id',Request::input('readiness_id'))
                    ->where('department_id',$auth->department_id)
                    ->where('readiness_section_id',Request::input('readiness_section_id'))
                    ->where('project_type',Request::input('project_type'))
                    ->first();
        if( !empty($articipategroup) ){ 
            $articipategroup->delete();
            return "ลบผู้เข้าร่วมโครงการแล้ว";
        }
    }

    public function DeleteTrainer(){
        $auth = Auth::user();
        $trainer = Trainer::where('trainer_name', Request::input('trainer_name'))
                    ->where('project_readiness_id',Request::input('readiness_id'))
                    ->where('project_type',Request::input('project_type'))
                    ->where('readiness_section_id',Request::input('readiness_section_id'))
                    ->first();
        if( !empty($trainer) ){ 
            $trainer->delete();
            return "ลบวิทยากรแล้ว";
        }
    }

    public function DeleteRegisterExpereince(){
        $auth = Auth::user();
        $registerexperience = RegisterExperience::where('register_experience_id', Request::input('experience_id'))
                    ->first();
        if(!empty($registerexperience) ){ 
            $registerexperience->delete();
            return "ลบประสบการณ์การทำงานแล้ว";
        }
    }

        public function DeleteRegisterTraining(){
        $auth = Auth::user();
        $registertraining = RegisterTraining::where('register_training_id', Request::input('training_id'))
                    ->first();
        if(!empty($registertraining)){ 
            $registertraining->delete();
            return "ลบรายการอบรมแล้ว";
        }
    }

    


    public function DeleteInterviewee(){
        $auth = Auth::user();
        $followupinterview = FollowupInterview::where('followup_interview_id', Request::input('interview_id'))
                    ->where('project_followup_id',Request::input('projectfollowup_id'))
                    ->first();
        if(count($followupinterview) > 0){ 
            $followupinterview->delete();
            return "ลบข้อมูลการสัมภาษณ์แล้ว";
        } 
    }

    public function DeleteInterviewer(){
        $auth = Auth::user();
        $interviewer = InterViewer::where('interviewer_id', Request::input('interviewer_id'))
                    ->where('project_followup_id',Request::input('projectfollowup_id'))
                    ->first();
        if(count($interviewer) > 0){ 
            $interviewer->delete();
            return "ลบข้อมูลเจ้าหน้าที่แล้ว";
        } 
    }


    public function DeleteContractorExpereince(){
        $auth = Auth::user();
        $date = explode("/", Request::input('startdate'));
        $date_start = ($date[2]-543)."-".$date[1]."-".$date[0];

        $exp = ContractorExperience::where('contractor_experience_datestart', $date_start)
                    ->first();
        if(count($exp) > 0){ 
            $exp->delete();
            return "ลบประสบการณ์แล้ว";
        }
    }   

    public function DeleteAuthority(){
        $auth = Auth::user();
        $officer = ProjectReadinessOfficer::where('officer_name', Request::input('officer_name'))
                    ->where('project_readiness_id',Request::input('readiness_id'))
                    ->where('readiness_section_id',Request::input('readiness_section_id'))
                    ->where('project_type',Request::input('project_type'))
                    ->first();
        if(!empty($officer) ){ 
            $officer->delete();
            return "ลบเจ้าหน้าที่แล้ว";
        }
    }

    public function DeleteCompany(){
        $auth = Auth::user();
        $company = Company::where('company_name', Request::input('company'))
                    ->where('project_readiness_id',Request::input('readiness_id'))
                    ->where('project_type',Request::input('project_type'))
                    ->where('readiness_section_id',Request::input('readiness_section_id'))
                    ->first();
        if(count($company) > 0){ 
            $company->delete();
            return "ลบสถานประกอบการแล้ว";
        }
    }

    public function DeleteAssessor(){
        $auth = Auth::user();
        $assessor = Assessor::where('assessor_id', Request::input('assessor_id'))
                    ->first();
        if( !empty($assessor) ){ 
            $assessor->delete();
            return "ลบผู้ประเมินแล้ว";
        }
    }

    public function Group(){
        $auth = Auth::user();

        $group = Group::where('department_id' , $auth->department_id)->get();
        return json_encode(array("group" => $group,"row" => count($group), 'filter' => Request::input('group') ));
    }

    public function Province(){
        $province = Province::get();
        return json_encode(array("province" => $province,"row" => $province->count(), 'filter' => Request::input('province') ));
    }

    public function Amphur(){
        $amphur = Amphur::where('province_id' , '=' , Request::input('province') )->get();
        return json_encode(array("amphur" => $amphur,"row" => $amphur->count() , "filter" => Request::input('amphur') ));
    }

    public function District(){
        $district = District::where('amphur_id' , '=' , Request::input('amphur') )->get();
        return json_encode(array("district" => $district,"row" => $district->count() , "filter" => Request::input('district') ));
    }

    public function Skill(){
        $skill = Skill::get();
        return json_encode(array("skill" => $skill,"row" => $skill->count(), 'filter' => Request::input('skill') ));
    }

    public function Software(){
        $software = Software::get();
        return json_encode(array("software" => $software,"row" => $software->count(), 'filter' => Request::input('software') ));
    }

    public function Military(){
        $military = Military::get();
        return json_encode(array("military" => $military,"row" => $military->count(), 'filter' => Request::input('military') ));
    }

    public function Married(){
        $married = Married::get();
        return json_encode(array("married" => $married,"row" => $married->count(), 'filter' => Request::input('married') ));
    }

    public function Religion(){
        $religion = Religion::get();
        return json_encode(array("religion" => $religion,"row" => $religion->count(), 'filter' => Request::input('religion') ));
    }

    public function Prefix(){
        $prefix = Prefix::get();
        return json_encode(array("prefix" => $prefix,"row" => $prefix->count(), 'filter' => Request::input('prefix') ));
    }

    public function Registertype(){
        $registertype = Registertype::get();
        return json_encode(array("registertype" => $registertype,"row" => $registertype->count(), 'registertype_filter' => Request::input('registertype') ));
    }   

    public function Department(){
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$department = SettingDepartment::join('tb_department' , 'tb_department.department_id' , 'tb_setting_department.department_id')->where('setting_year' , $setting->setting_year)->where('department_status' , 1)->get();
		return json_encode(array("department" => $department,"row" => $department->count(), 'filter_department' => Request::input('department') ));
    }

    public function Budget(){
    	$setting = SettingYear::where('setting_status' , 1)->first();

    	$budget = SettingBudget::join('tb_budget' , 'tb_budget.budget_id' , 'tb_setting_budget.budget_id')->where('setting_year' , $setting->setting_year)->where('budget_status' , 1)->get();
		return json_encode(array("budget" => $budget,"row" => $budget->count(), 'filter_budget' => Request::input('budget') ));
    }

    public function ProjectAllocation(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->join('tb_budget' , 'tb_budget.budget_id' , 'tb_allocation.budget_id');
        $q = $q->where('project_id' , $project->project_id)->where('department_id' , $auth->department_id);
        $q = $q->wherenotin('allocation_price' , [0]);
        $q = $q->where('tb_budget.budget_id' , 1);
        $q = $q->where('allocation_type' , 1);
        $q = $q->select('tb_budget.budget_id' , 'budget_name');
        $budget = $q->get();
        
        return json_encode(array("budget" => $budget,"row" => $budget->count(), 'filter_budget' => Request::input('budget') ));
    }

    public function Position(){
        $auth = Auth::user();

        $position = Position::where('department_id' , $auth->department_id)->get();
        return json_encode(array("position" => $position,"row" => $position->count(), 'filter' => Request::input('position') ));
    }

    public function Position2(){
        $auth = Auth::user();
        $position = ContractorPosition::where('department_id' , $auth->department_id)->get();
        return json_encode(array("position" => $position,"row" => $position->count(), 'filter' => Request::input('position') ));
    }

    public function Section(){
        $auth = Auth::user();
        $section = Section::where('department_id' , Request::input('department'))->get();
        return json_encode(array("section" => $section,"row" => $section->count() ));
    }

    public function UploadProfileImage(){
        
    }

    public function GetSection(){
       $list = array();
       $list = Request::input('provincelist') ;
       $province = Province::whereIn('province_id',$list)->get();
       $provincearray = array();
       $sectionarray = array();

       foreach($province as $val){
        $provincearray[] = $val->map_code;
        }
     
       $section = Section::whereIn('map_code',$provincearray)->get();
       
       foreach($section as $val){
            $check = FollowupSection::where('section_id',$val->section_id)
                                    ->where('project_followup_id',Request::input('id'))
                                    ->get();
            if( $check->count() !=0 ){
                $sectionarray[] = array('check' => 1 );        
            }else{
                $sectionarray[] = array('check' => 0 ); 
            }
            
        }

        $selectselected = collect( $sectionarray );

        return json_encode(array("section" => $section,"row" => $section->count(),"selectselected" => $selectselected,"_row" => count($selectselected) ));
    }

    public function DeptReportRecurit(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $recuritarray = array();
        $sectionarray = array();

        $builder = "";
        foreach ($province as $key => $item){
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();
            
            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }

            if (count($section_arr) > 0) {
                $generate = Generate::where('department_id',$auth->department_id)
                                ->where('project_id',$project->project_id)
                                ->whereIn('section_id',$section_arr)
                                ->get();

                if($generate->count() > 0){
                    $builder = "จังหวัด " . $item->province_name . "\n\n";
                    $totalallocate = 0;                  
                    $totalhired = 0;
                    foreach($section_arr as $_item) {
                        $allocate = $generate->where('section_id',$_item)->count();
                        $hired = $generate->where('section_id',$_item)->where('generate_status',1)->count();
                        if($allocate > 0){
                            $totalallocate = $totalallocate + $allocate;
                            $totalhired = $totalhired + $hired;
                            $section = Section::where('section_id',$_item)->first();
                            $builder .= $section->section_name . " จัดสรร: " .   $allocate . " จ้างจริง: " . $hired  . " (".  number_format( ($hired/ $allocate) * 100 , 2) . "%) \n";
                            $sectionarray[] = array('label' => $section->section_name , 'value' => $totalhired );        
                        } 
                      }
                    $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalhired . " (" . number_format( ($totalhired / $totalallocate) * 100 , 2) . " %) \n";
                    $recuritarray[] = array('id' => $item->map_code , 'value' => number_format( ($totalhired / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                    
                }
            }
        }   

       //สร้าง collection 
        $recuritdata = collect( $recuritarray );
        $recuritdatabysection = collect( $sectionarray );
        return json_encode(array("recuritdatabysection" => $recuritdatabysection,"_row" => count($recuritdatabysection),"recuritdata" => $recuritdata,"row" => count($recuritdata), 'filter_recuritdata' => Request::input('recuritdata') ));  
    }

    public function DeptReportRecuritBudget(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $allocation = Allocation::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 1)
                                ->where('allocation_type' , 2)
                                ->get();

        $recuritarray = array();
        $sectionarray = array();

        $builder = "";
        foreach ($province as $key => $item){
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();

            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }
          
            if (count($section_arr) > 0) {
                $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->whereIn('section_id',$section_arr)
                            ->get(); 

                if($payment->count() > 0){
 
                    $builder = "จังหวัด " . $item->province_name . "\n\n";
                    $totalallocate = 0;                  
                    $totalpayment = 0;
                    foreach($section_arr as $_item) {
                         $allocate = $allocation->where('section_id',$_item)->first();
                         $_p = $payment->where('section_id',$_item)->first();

                        if( !empty($_p) ){
                           
                               $_payment = $payment->where('section_id',$_item)->sum('payment_salary');
                                $totalallocate = $totalallocate + $allocate->allocation_price ;
                                $totalpayment = $totalpayment + $_payment;
                            
                            $section = Section::where('section_id',$_item)->first();
                            
                            $builder .= $section->section_name . " จัดสรร: " .   $allocate->allocation_price . " เบิกจ่ายจริง: " . $_payment  . " (".  number_format( ($_payment/ $allocate->allocation_price) * 100 , 2) . "%) \n";
                            $sectionarray[] = array('label' => $section->section_name , 'value' => $_payment );        
                        } 
                      }
                    $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalpayment . " (" . number_format( ($totalpayment / $totalallocate) * 100 , 2) . " %) \n";
                    $recuritarray[] = array('id' => $item->map_code , 'value' => number_format( ($totalpayment / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                
                }
            }
        }   

       //สร้าง collection 
        $recuritdata = collect( $recuritarray );
        $recuritdatabysection = collect( $sectionarray );
        return json_encode(array("recuritdatabysection" => $recuritdatabysection,"_row" => count($recuritdatabysection),"recuritdata" => $recuritdata,"row" => count($recuritdata), 'filter_recuritdata' => Request::input('recuritdata') ));  
    }
    public function MainReportRecurit(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $recuritarray_dept1 = array();
        $sectionarray_dept1 = array();
        $recuritarray_dept2 = array();
        $sectionarray_dept2 = array();
        $recuritarray_dept3 = array();
        $sectionarray_dept3 = array();
        //================กรมคุมประพฤติ===============
        $builder = "";
        foreach ($province as $key => $item){
            //ในจังหวัด (map_code)มี section ไหนบ้าง
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();
            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }

            if (count($section_arr) > 0) {
                $generate = Generate::where('department_id',1)
                                ->where('project_id',$project->project_id)
                                ->whereIn('section_id',$section_arr)
                                ->get();

                if($generate->count() > 0){
                    $builder = "จังหวัด " . $item->province_name . "\n\n";
                    $totalallocate = 0;                  
                    $totalhired = 0;
                    foreach($section_arr as $_item) {
                        $allocate = $generate->where('section_id',$_item)->count();
                        $hired = $generate->where('section_id',$_item)->where('generate_status',1)->count();
                        if($allocate > 0){
                            $totalallocate = $totalallocate + $allocate;
                            $totalhired = $totalhired + $hired;
                            $section = Section::where('section_id',$_item)->first();
                            $builder .= $section->section_name . " จัดสรร: " .   $allocate . " จ้างจริง: " . $hired  . " (".  number_format( ($hired/ $allocate) * 100 , 2) . "%) \n";
                            $sectionarray_dept1[] = array('label' => $section->section_name , 'value' => $totalhired );        
                        } 
                      }
                    $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalhired . " (" . number_format( ($totalhired / $totalallocate) * 100 , 2) . " %) \n";
                    $recuritarray_dept1[] = array('id' => $item->map_code , 'value' => number_format( ($totalhired / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                    
                }
            }
        }   

       //สร้าง collection dept1
        $recuritdata_dept1 = collect( $recuritarray_dept1 );
        $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

       //================กรมคุมประราชทัณฑ์===============
       $builder = "";
       foreach ($province as $key => $item){
           //ในจังหวัด (map_code)มี section ไหนบ้าง
           $section = Section::where('map_code', $item->map_code)->get() ;
           $section_arr = array();
           foreach($section as $val){
               $section_arr[] = $val->section_id;
           }

           if (count($section_arr) > 0) {
               $generate = Generate::where('department_id',2)
                               ->where('project_id',$project->project_id)
                               ->whereIn('section_id',$section_arr)
                               ->get();

               if(count($generate) > 0){
                   $builder = "จังหวัด " . $item->province_name . "\n\n";
                   $totalallocate = 0;                  
                   $totalhired = 0;
                   foreach($section_arr as $_item) {
                       $allocate = $generate->where('section_id',$_item)->count();
                       $hired = $generate->where('section_id',$_item)->where('generate_status',1)->count();
                       if($allocate > 0){
                           $totalallocate = $totalallocate + $allocate;
                           $totalhired = $totalhired + $hired;
                           $section = Section::where('section_id',$_item)->first();
                           $builder .= $section->section_name . " จัดสรร: " .   $allocate . " จ้างจริง: " . $hired  . " (".  number_format( ($hired/ $allocate) * 100 , 2) . "%) \n";
                           $sectionarray_dept2[] = array('label' => $section->section_name , 'value' => $totalhired );        
                       } 
                     }
                   $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalhired . " (" . number_format( ($totalhired / $totalallocate) * 100 , 2) . " %) \n";
                   $recuritarray_dept2[] = array('id' => $item->map_code , 'value' => number_format( ($totalhired / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                   
               }
           }
       }   

      //สร้าง collection dept1
       $recuritdata_dept2 = collect( $recuritarray_dept2 );
       $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

       //================กรมคุมพินิจ===============
       $builder = "";
       foreach ($province as $key => $item){
           //ในจังหวัด (map_code)มี section ไหนบ้าง
           $section = Section::where('map_code', $item->map_code)->get() ;
           $section_arr = array();
           foreach($section as $val){
               $section_arr[] = $val->section_id;
           }

           if (count($section_arr) > 0) {
               $generate = Generate::where('department_id',3)
                               ->where('project_id',$project->project_id)
                               ->whereIn('section_id',$section_arr)
                               ->get();

               if(count($generate) > 0){
                   $builder = "จังหวัด " . $item->province_name . "\n\n";
                   $totalallocate = 0;                  
                   $totalhired = 0;
                   foreach($section_arr as $_item) {
                       $allocate = $generate->where('section_id',$_item)->count();
                       $hired = $generate->where('section_id',$_item)->where('generate_status',1)->count();
                       if($allocate > 0){
                           $totalallocate = $totalallocate + $allocate;
                           $totalhired = $totalhired + $hired;
                           $section = Section::where('section_id',$_item)->first();
                           $builder .= $section->section_name . " จัดสรร: " .   $allocate . " จ้างจริง: " . $hired  . " (".  number_format( ($hired/ $allocate) * 100 , 2) . "%) \n";
                           $sectionarray_dept3[] = array('label' => $section->section_name , 'value' => $totalhired );        
                       } 
                     }
                   $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalhired . " (" . number_format( ($totalhired / $totalallocate) * 100 , 2) . " %) \n";
                   $recuritarray_dept3[] = array('id' => $item->map_code , 'value' => number_format( ($totalhired / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );                
               }
           }
       }   

      //สร้าง collection dept1
       $recuritdata_dept3 = collect( $recuritarray_dept3 );
       $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

        return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
        "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
        "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
        'filter_recuritdata' => Request::input('recuritdata') ));  
    }

    public function MainReportRecuritBudget(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $recuritarray_dept1 = array();
        $sectionarray_dept1 = array();
        $recuritarray_dept2 = array();
        $sectionarray_dept2 = array();
        $recuritarray_dept3 = array();
        $sectionarray_dept3 = array();

        //================กรมคุมประพฤติ===============
        $builder = "";
        $allocation_section = Allocation::where('project_id' , $project->project_id)
                            ->where('department_id' , 1)
                            ->where('budget_id' , 1)
                            ->where('allocation_type' , 2)
                            ->get();
        foreach ($province as $key => $item){
            //ในจังหวัด (map_code)มี section ไหนบ้าง
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();
            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }

            if (count($section_arr) > 0) {

                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , 1)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->whereIn('section_id',$section_arr)
                                ->get();                 

                if(count($payment) > 0){

                    $builder = "จังหวัด " . $item->province_name . "\n\n";
                    $totalallocate = 0;                  
                    $totalpayment = 0;
                    foreach($section_arr as $_item) {
                         $allocate = $allocation_section->where('section_id',$_item)->first();
                         $_p = $payment->where('section_id',$_item)->first();
                        if( count($_p) > 0 ){
                            $_payment = $payment->where('section_id',$_item)->sum('payment_salary');
                            $totalallocate = $totalallocate + $allocate->allocation_price ;
                            $totalpayment = $totalpayment + $_payment;
                            $section = Section::where('section_id',$_item)->first();

                            $builder .= $section->section_name . " จัดสรร: " .   $allocate->allocation_price . " เบิกจ่ายจริง: " . $_payment  . " (".  number_format( ($_payment/ $allocate->allocation_price) * 100 , 2) . "%) \n";
                            $sectionarray_dept1[] = array('label' => $section->section_name , 'value' => $_payment );        
                        } 
                    }
                    $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalpayment . " (" . number_format( ($totalpayment / $totalallocate) * 100 , 2) . " %) \n";
                    $recuritarray_dept1[] = array('id' => $item->map_code , 'value' => number_format( ($totalpayment / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                }
            }
        }   

       //สร้าง collection dept1
        $recuritdata_dept1 = collect( $recuritarray_dept1 );
        $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    //================กรมคุมประราชทัณฑ์===============
    $builder = "";
    $allocation_section = Allocation::where('project_id' , $project->project_id)
                        ->where('department_id' , 2)
                        ->where('budget_id' , 1)
                        ->where('allocation_type' , 2)
                        ->get();
    foreach ($province as $key => $item){
        //ในจังหวัด (map_code)มี section ไหนบ้าง
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , 2)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->whereIn('section_id',$section_arr)
                            ->get();                 

            if(count($payment) > 0){

                $builder = "จังหวัด " . $item->province_name . "\n\n";
                $totalallocate = 0;                  
                $totalpayment = 0;
                foreach($section_arr as $_item) {
                     $allocate = $allocation_section->where('section_id',$_item)->first();
                     $_p = $payment->where('section_id',$_item)->first();
                    if( count($_p) > 0 ){
                        $_payment = $payment->where('section_id',$_item)->sum('payment_salary');
                        $totalallocate = $totalallocate + $allocate->allocation_price ;
                        $totalpayment = $totalpayment + $_payment;
                        $section = Section::where('section_id',$_item)->first();

                        $builder .= $section->section_name . " จัดสรร: " .   $allocate->allocation_price . " เบิกจ่ายจริง: " . $_payment  . " (".  number_format( ($_payment/ $allocate->allocation_price) * 100 , 2) . "%) \n";
                        $sectionarray_dept2[] = array('label' => $section->section_name , 'value' => $_payment );        
                    } 
                }
                $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalpayment . " (" . number_format( ($totalpayment / $totalallocate) * 100 , 2) . " %) \n";
                $recuritarray_dept2[] = array('id' => $item->map_code , 'value' => number_format( ($totalpayment / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
            }
        }
    }   

   //สร้าง collection dept2
    $recuritdata_dept2 = collect( $recuritarray_dept2 );
    $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    //================กรมคุมพินิจ===============
    $builder = "";
    $allocation_section = Allocation::where('project_id' , $project->project_id)
                        ->where('department_id' , 3)
                        ->where('budget_id' , 1)
                        ->where('allocation_type' , 2)
                        ->get();
    foreach ($province as $key => $item){
        //ในจังหวัด (map_code)มี section ไหนบ้าง
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , 3)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->whereIn('section_id',$section_arr)
                            ->get();                 

            if(count($payment) > 0){

                $builder = "จังหวัด " . $item->province_name . "\n\n";
                $totalallocate = 0;                  
                $totalpayment = 0;
                foreach($section_arr as $_item) {
                     $allocate = $allocation_section->where('section_id',$_item)->first();
                     $_p = $payment->where('section_id',$_item)->first();
                    if( count($_p) > 0 ){
                        $_payment = $payment->where('section_id',$_item)->sum('payment_salary');
                        $totalallocate = $totalallocate + $allocate->allocation_price ;
                        $totalpayment = $totalpayment + $_payment;
                        $section = Section::where('section_id',$_item)->first();

                        $builder .= $section->section_name . " จัดสรร: " .   $allocate->allocation_price . " เบิกจ่ายจริง: " . $_payment  . " (".  number_format( ($_payment/ $allocate->allocation_price) * 100 , 2) . "%) \n";
                        $sectionarray_dept3[] = array('label' => $section->section_name , 'value' => $_payment );        
                    } 
                }
                $builder .= "\nจัดสรรรวม " . $totalallocate . " จ้างจริงรวม " . $totalpayment . " (" . number_format( ($totalpayment / $totalallocate) * 100 , 2) . " %) \n";
                $recuritarray_dept3[] = array('id' => $item->map_code , 'value' => number_format( ($totalpayment / $totalallocate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
            }
        }
    }   

   //สร้าง collection dept2
    $recuritdata_dept3 = collect( $recuritarray_dept3 );
    $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

        return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
        "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
        "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
        'filter_recuritdata' => Request::input('recuritdata') ));  
    
    }


//   public function DeptReportOccupationFollowupEnoughExpense(){
//         $auth = Auth::user();
//         $setting = SettingYear::where('setting_status' , 1)->first();
//         $project = Project::where('year_budget' , $setting->setting_year)->first();
//         $province = Province::all();

//         $occupationarray = array();
//         $sectionarray = array();

//         $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
//         $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

//         $builder = "";
//         foreach ($province as $key => $item){
//             $section = Section::where('map_code', $item->map_code)->get() ;
//             $section_arr = array();

//             foreach($section as $val){
//                 $section_arr[] = $val->section_id;
//             }

//             if (count($section_arr) > 0) {
//                 $readiness = ProjectReadiness::where('project_id' , $project->project_id)
//                             ->where('project_type',2)
//                             ->where('department_id' , $auth->department_id)
//                             ->whereIn('section_id',$section_arr)
//                             ->get(); 

//                 if(count($readiness) > 0){
//                     $builder = "จังหวัด " . $item->province_name . "\n\n";
//                     $totaltargetparticipate = 0;                  
//                     $totalactualparticipate = 0;
//                     $totalhasoccupation = 0;
//                     $totalhasoccupation_enoughincome =0;
                    
//                     foreach($section_arr as $key => $_item) {
//                         $hasoccupation = 0;
//                         $hasoccupation_enoughincome = 0;
//                         $_p = $readiness->where('section_id',$_item)->first();
//                         if( count($_p) > 0 ){      
//                             $section = Section::where('section_id',$_item)->first();
//                             $participate = $readiness->where('section_id',$_item)->first();
//                             $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
//                                                                 ->where('project_type',2)
//                                                                 ->sum('participate_num');

//                             $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();

//                             if (count($registers) !=0 ){
//                                 foreach($registers as $_item){
                                     
//                                     $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
//                                                                             ->where('occupation_id','!=',1)
//                                                                             ->first();
//                                     if(count($registerhasoccupation) != 0 ){
//                                         $totalhasoccupation = $totalhasoccupation + 1;
//                                         $hasoccupation = $hasoccupation + 1;
//                                     }

//                                     $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
//                                                                                     ->where('occupation_id','!=',1)
//                                                                                     ->where('enoughincome_id',2)
//                                                                                     ->first();
//                                     if(count($registerhasoccupationenoughincome) != 0 ){
//                                         $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
//                                         $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
//                                     }


//                                 }
//                             }
//                             // echo "<br>------------------------<br>";
//                             // $totalhasoccupation_enoughincome = $totalactualparticipate + $actualparticipate ;

//                             $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้พอเพียง: " . $hasoccupation_enoughincome  . " (".  number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2) . "%) \n\n";                           
//                             $sectionarray[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome );        
//                         } 
//                       }

//                     $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2) . " %) \n";
//                     $occupationarray[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                
//                 }
//             }
//         }   

//        //สร้าง collection 
//         $occupationdata = collect( $occupationarray );
//         $occupationdatabysection = collect( $sectionarray );
//         return json_encode(array("occupationdatabysection" => $occupationdatabysection,"_row" => count($occupationdatabysection),"occupationdata" => $occupationdata,"row" => count($occupationdata), 'filter_occupationdata' => Request::input('occupationdata') ));  
//     }


    // public function MainReportHasIncome(){
    //     // --------------------
    //     $auth = Auth::user();
    //     $setting = SettingYear::where('setting_status' , 1)->first();
    //     $project = Project::where('year_budget' , $setting->setting_year)->first();
    //     $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
    //     $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

    //     $province = Province::all();
    //     $occupationarray_dept1 = array();
    //     $sectionarray_dept1 = array();
    //     $occupationarray_dept2 = array();
    //     $sectionarray_dept2 = array();
    //     $occupationarray_dept3 = array();
    //     $sectionarray_dept3 = array();

    //     //================กรมคุมประพฤติ===============
    //     $builder = "";
    //     foreach ($province as $key => $item){
    //         //ในจังหวัด (map_code)มี section ไหนบ้าง
    //         $section = Section::where('map_code', $item->map_code)->get() ;
    //         $section_arr = array();
    //         foreach($section as $val){
    //             $section_arr[] = $val->section_id;
    //         }

    //         if (count($section_arr) > 0) {
    //             $readiness = ProjectReadiness::where('project_id' , $project->project_id)
    //                         ->where('project_type',2)
    //                         ->where('department_id' , 1)
    //                         ->whereIn('section_id',$section_arr)
    //                         ->get();                 

    //             if(count($readiness) > 0){

    //                 $builder = "จังหวัด " . $item->province_name . "\n\n";
    //                 $totaltargetparticipate = 0;                  
    //                 $totalactualparticipate = 0;
    //                 $totalhasoccupation = 0;

    //                 foreach($section_arr as $_item) {
    //                     $hasoccupation = 0;
    //                     $_p = $readiness->where('section_id',$_item)->first();
    //                     if( count($_p) > 0 ){      
    //                         $section = Section::where('section_id',$_item)->first();
    //                         $participate = $readiness->where('section_id',$_item)->first();
    //                         $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
    //                                                             ->where('project_type',2)
    //                                                             ->sum('participate_num');
                                                                
    //                         $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();

    //                         if (count($registers) !=0 ){
    //                             foreach($registers as $_item){
                                     
    //                                 $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
    //                                                                         ->where('occupation_id','!=',1)
    //                                                                         ->first();
    //                                 if(count($registerhasoccupation) != 0 ){
    //                                     $totalhasoccupation = $totalhasoccupation + 1;
    //                                     $hasoccupation = $hasoccupation + 1;
    //                                 }
    //                             }
    //                         }
                            
    //                         $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

    //                         $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  number_format( ($hasoccupation/ $actualparticipate) * 100 , 2) . "%) \n\n";                           
    //                         $sectionarray_dept1[] = array('label' => $section->section_name , 'value' => $hasoccupation );  
    //                     } 
    //                 }
    //                 $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . number_format( ($totalhasoccupation / $totalactualparticipate) * 100 , 2) . " %) \n";

    //                 $occupationarray_dept1[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation / $totalactualparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );  

    //             }
    //         }
    //     }   

    //    //สร้าง collection dept1
    //     $recuritdata_dept1 = collect( $occupationarray_dept1 );
    //     $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    //     //================ราชทัณฑ์===============
    //     $builder = "";
    //     foreach ($province as $key => $item){
    //         //ในจังหวัด (map_code)มี section ไหนบ้าง
    //         $section = Section::where('map_code', $item->map_code)->get() ;
    //         $section_arr = array();
    //         foreach($section as $val){
    //             $section_arr[] = $val->section_id;
    //         }

    //         if (count($section_arr) > 0) {
    //             $readiness = ProjectReadiness::where('project_id' , $project->project_id)
    //                         ->where('project_type',2)
    //                         ->where('department_id' , 2)
    //                         ->whereIn('section_id',$section_arr)
    //                         ->get();                 

    //             if(count($readiness) > 0){

    //                 $builder = "จังหวัด " . $item->province_name . "\n\n";
    //                 $totaltargetparticipate = 0;                  
    //                 $totalactualparticipate = 0;
    //                 $totalhasoccupation = 0;

    //                 foreach($section_arr as $_item) {
    //                     $hasoccupation = 0;
    //                     $_p = $readiness->where('section_id',$_item)->first();
    //                     if( count($_p) > 0 ){      
    //                         $section = Section::where('section_id',$_item)->first();
    //                         $participate = $readiness->where('section_id',$_item)->first();
    //                         $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
    //                                                             ->where('project_type',2)
    //                                                             ->sum('participate_num');
                                                                
    //                         $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();

    //                         if (count($registers) !=0 ){
    //                             foreach($registers as $_item){
                                     
    //                                 $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
    //                                                                         ->where('occupation_id','!=',1)
    //                                                                         ->first();
    //                                 if(count($registerhasoccupation) != 0 ){
    //                                     $totalhasoccupation = $totalhasoccupation + 1;
    //                                     $hasoccupation = $hasoccupation + 1;
    //                                 }
    //                             }
    //                         }
                            
    //                         $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

    //                         $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  number_format( ($hasoccupation/ $actualparticipate) * 100 , 2) . "%) \n\n";                           
    //                         $sectionarray_dept2[] = array('label' => $section->section_name , 'value' => $hasoccupation );  
    //                     } 
    //                 }
    //                 $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . number_format( ($totalhasoccupation / $totalactualparticipate) * 100 , 2) . " %) \n";

    //                 $occupationarray_dept2[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation / $totalactualparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );  

    //             }
    //         }
    //     }   

    //    //สร้าง collection dept1
    //     $recuritdata_dept2 = collect( $occupationarray_dept2 );
    //     $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    //     //================พินิจ===============
    //     $builder = "";
    //     foreach ($province as $key => $item){
    //         //ในจังหวัด (map_code)มี section ไหนบ้าง
    //         $section = Section::where('map_code', $item->map_code)->get() ;
    //         $section_arr = array();
    //         foreach($section as $val){
    //             $section_arr[] = $val->section_id;
    //         }

    //         if (count($section_arr) > 0) {
    //             $readiness = ProjectReadiness::where('project_id' , $project->project_id)
    //                         ->where('project_type',2)
    //                         ->where('department_id' , 3)
    //                         ->whereIn('section_id',$section_arr)
    //                         ->get();                 

    //             if(count($readiness) > 0){

    //                 $builder = "จังหวัด " . $item->province_name . "\n\n";
    //                 $totaltargetparticipate = 0;                  
    //                 $totalactualparticipate = 0;
    //                 $totalhasoccupation = 0;

    //                 foreach($section_arr as $_item) {
    //                     $hasoccupation = 0;
    //                     $_p = $readiness->where('section_id',$_item)->first();
    //                     if( count($_p) > 0 ){      
    //                         $section = Section::where('section_id',$_item)->first();
    //                         $participate = $readiness->where('section_id',$_item)->first();
    //                         $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
    //                                                             ->where('project_type',2)
    //                                                             ->sum('participate_num');
                                                                
    //                         $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();

    //                         if (count($registers) !=0 ){
    //                             foreach($registers as $_item){
                                        
    //                                 $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
    //                                                                         ->where('occupation_id','!=',1)
    //                                                                         ->first();
    //                                 if(count($registerhasoccupation) != 0 ){
    //                                     $totalhasoccupation = $totalhasoccupation + 1;
    //                                     $hasoccupation = $hasoccupation + 1;
    //                                 }
    //                             }
    //                         }
                            
    //                         $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

    //                         $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  number_format( ($hasoccupation/ $actualparticipate) * 100 , 2) . "%) \n\n";                           
    //                         $sectionarray_dept3[] = array('label' => $section->section_name , 'value' => $hasoccupation );  
    //                     } 
    //                 }
    //                 $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . number_format( ($totalhasoccupation / $totalactualparticipate) * 100 , 2) . " %) \n";

    //                 $occupationarray_dept3[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation / $totalactualparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );  

    //             }
    //         }
    //     }   

    //     //สร้าง collection dept1
    //     $recuritdata_dept3 = collect( $occupationarray_dept3 );
    //     $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

    //     // return $recuritdatabysection_dept1;
   
    //     return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
    //     "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
    //     "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
    //     'filter_recuritdata' => Request::input('recuritdata') ));  
    
    // }

    // public function MainReportEnoughIncome(){
    //     // --------------------
    //     $auth = Auth::user();
    //     $setting = SettingYear::where('setting_status' , 1)->first();
    //     $project = Project::where('year_budget' , $setting->setting_year)->first();
    //     $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
    //     $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

    //     $province = Province::all();
    //     $occupationarray_dept1 = array();
    //     $sectionarray_dept1 = array();
    //     $occupationarray_dept2 = array();
    //     $sectionarray_dept2 = array();
    //     $occupationarray_dept3 = array();
    //     $sectionarray_dept3 = array();

    //     //================กรมคุมประพฤติ===============
    //     $builder = "";
    //     foreach ($province as $key => $item){
    //         //ในจังหวัด (map_code)มี section ไหนบ้าง
    //         $section = Section::where('map_code', $item->map_code)->get() ;
    //         $section_arr = array();
    //         foreach($section as $val){
    //             $section_arr[] = $val->section_id;
    //         }

    //         if (count($section_arr) > 0) {
    //             $readiness = ProjectReadiness::where('project_id' , $project->project_id)
    //                         ->where('project_type',2)
    //                         ->where('department_id' , 1)
    //                         ->whereIn('section_id',$section_arr)
    //                         ->get();   
                                                   
    //             if(count($readiness) > 0){

    //                 $builder = "จังหวัด " . $item->province_name . "\n\n";
    //                 $totaltargetparticipate = 0;                  
    //                 $totalactualparticipate = 0;
    //                 $totalhasoccupation = 0;
    //                 $totalhasoccupation_enoughincome =0;

    //                 foreach($section_arr as $_item) {
    //                     $hasoccupation = 0;
    //                     $hasoccupation_enoughincome = 0;
    //                     $_p = $readiness->where('section_id',$_item)->first();
    //                     if( count($_p) > 0 ){      
    //                         $section = Section::where('section_id',$_item)->first();
    //                         $participate = $readiness->where('section_id',$_item)->first();
    //                         $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
    //                                                             ->where('project_type',2)
    //                                                             ->sum('participate_num');
                                                                
    //                         $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();

    //                         if (count($registers) !=0 ){
    //                             foreach($registers as $_item){
                                     
    //                                 $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
    //                                                                         ->where('occupation_id','!=',1)
    //                                                                         ->first();
    //                                 if(count($registerhasoccupation) != 0 ){
    //                                     $totalhasoccupation = $totalhasoccupation + 1;
    //                                     $hasoccupation = $hasoccupation + 1;
    //                                 }
                    
    //                                 $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
    //                                                                                 ->where('occupation_id','!=',1)
    //                                                                                 ->where('enoughincome_id',2)
    //                                                                                 ->first();
    //                                 if(count($registerhasoccupationenoughincome) != 0 ){
    //                                     $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
    //                                     $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
    //                                 }
                    
    //                             }
    //                         }

    //                         if($hasoccupation !=0 ){
    //                             $_hasoccupation_enoughincome = number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
    //                         }else{
    //                             $_hasoccupation_enoughincome = 0;
    //                         }
                            
    //                         $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้พอเพียง: " . $hasoccupation_enoughincome  . " (".  $_hasoccupation_enoughincome . "%) \n\n";                           
    //                         $sectionarray_dept1[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome );        
    //                     } 
    //                 }
    //                 if($totalhasoccupation !=0 ){
    //                     $_totalhasoccupation_enoughincome = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
    //                 }else{
    //                     $_totalhasoccupation_enoughincome =0;
    //                 }
    //                 $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . $_totalhasoccupation_enoughincome . " %) \n";
    //                 $occupationarray_dept1[] = array('id' => $item->map_code , 'value' => $_totalhasoccupation_enoughincome  , 'province' => $item->province_name, 'message' => "$builder"   );        
    //             }
    //         }
    //     }   

    //    //สร้าง collection dept1
    //     $recuritdata_dept1 = collect( $occupationarray_dept1 );
    //     $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    //     //================กรมราชทัณฑ์===============
    //     $builder = "";
    //     foreach ($province as $key => $item){
    //         //ในจังหวัด (map_code)มี section ไหนบ้าง
    //         $section = Section::where('map_code', $item->map_code)->get() ;
    //         $section_arr = array();
    //         foreach($section as $val){
    //             $section_arr[] = $val->section_id;
    //         }

    //         if (count($section_arr) > 0) {
    //             $readiness = ProjectReadiness::where('project_id' , $project->project_id)
    //                         ->where('project_type',2)
    //                         ->where('department_id' , 2)
    //                         ->whereIn('section_id',$section_arr)
    //                         ->get();   
                                                   
    //             if(count($readiness) > 0){

    //                 $builder = "จังหวัด " . $item->province_name . "\n\n";
    //                 $totaltargetparticipate = 0;                  
    //                 $totalactualparticipate = 0;
    //                 $totalhasoccupation = 0;
    //                 $totalhasoccupation_enoughincome =0;

    //                 foreach($section_arr as $_item) {
    //                     $hasoccupation = 0;
    //                     $hasoccupation_enoughincome = 0;
    //                     $_p = $readiness->where('section_id',$_item)->first();
    //                     if( count($_p) > 0 ){      
    //                         $section = Section::where('section_id',$_item)->first();
    //                         $participate = $readiness->where('section_id',$_item)->first();
    //                         $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
    //                                                             ->where('project_type',2)
    //                                                             ->sum('participate_num');
                                                                
    //                         $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();

    //                         if (count($registers) !=0 ){
    //                             foreach($registers as $_item){
                                     
    //                                 $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
    //                                                                         ->where('occupation_id','!=',1)
    //                                                                         ->first();
    //                                 if(count($registerhasoccupation) != 0 ){
    //                                     $totalhasoccupation = $totalhasoccupation + 1;
    //                                     $hasoccupation = $hasoccupation + 1;
    //                                 }
                    
    //                                 $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
    //                                                                                 ->where('occupation_id','!=',1)
    //                                                                                 ->where('enoughincome_id',2)
    //                                                                                 ->first();
    //                                 if(count($registerhasoccupationenoughincome) != 0 ){
    //                                     $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
    //                                     $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
    //                                 }
                    
    //                             }
    //                         }
                            
    //                         if($hasoccupation !=0 ){
    //                             $_hasoccupation_enoughincome = number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
    //                         }else{
    //                             $_hasoccupation_enoughincome = 0;
    //                         }

    //                         $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้พอเพียง: " . $hasoccupation_enoughincome  . " (".  $_hasoccupation_enoughincome . "%) \n\n";                           
    //                         $sectionarray_dept2[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome );        
    //                     } 
    //                 }

    //                 if($totalhasoccupation !=0 ){
    //                     $_totalhasoccupation_enoughincome = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
    //                 }else{
    //                     $_totalhasoccupation_enoughincome =0;
    //                 }
    //                 $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . $_totalhasoccupation_enoughincome . " %) \n";
    //                 $occupationarray_dept2[] = array('id' => $item->map_code , 'value' => $_totalhasoccupation_enoughincome  , 'province' => $item->province_name, 'message' => "$builder"   );        
    //             }
    //         }
    //     }   

    //    //สร้าง collection dept1
    //     $recuritdata_dept2 = collect( $occupationarray_dept2 );
    //     $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    //      //================กรมพินิจ===============
    //      $builder = "";
    //      foreach ($province as $key => $item){
    //          //ในจังหวัด (map_code)มี section ไหนบ้าง
    //          $section = Section::where('map_code', $item->map_code)->get() ;
    //          $section_arr = array();
    //          foreach($section as $val){
    //              $section_arr[] = $val->section_id;
    //          }
 
    //          if (count($section_arr) > 0) {
    //              $readiness = ProjectReadiness::where('project_id' , $project->project_id)
    //                          ->where('project_type',2)
    //                          ->where('department_id' , 3)
    //                          ->whereIn('section_id',$section_arr)
    //                          ->get();   
                                                    
    //              if(count($readiness) > 0){
 
    //                  $builder = "จังหวัด " . $item->province_name . "\n\n";
    //                  $totaltargetparticipate = 0;                  
    //                  $totalactualparticipate = 0;
    //                  $totalhasoccupation = 0;
    //                  $totalhasoccupation_enoughincome =0;
 
    //                  foreach($section_arr as $_item) {
    //                      $hasoccupation = 0;
    //                      $hasoccupation_enoughincome = 0;
    //                      $_p = $readiness->where('section_id',$_item)->first();
    //                      if( count($_p) > 0 ){      
    //                          $section = Section::where('section_id',$_item)->first();
    //                          $participate = $readiness->where('section_id',$_item)->first();
    //                          $actualparticipate = ProjectParticipate::where('project_readiness_id',$participate->project_readiness_id)
    //                                                              ->where('project_type',2)
    //                                                              ->sum('participate_num');
                                                                 
    //                          $registers = $participategroup->where('project_readiness_id',$participate->project_readiness_id)->all();
 
    //                          if (count($registers) !=0 ){
    //                              foreach($registers as $_item){
                                      
    //                                  $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
    //                                                                          ->where('occupation_id','!=',1)
    //                                                                          ->first();
    //                                  if(count($registerhasoccupation) != 0 ){
    //                                      $totalhasoccupation = $totalhasoccupation + 1;
    //                                      $hasoccupation = $hasoccupation + 1;
    //                                  }
                     
    //                                  $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
    //                                                                                  ->where('occupation_id','!=',1)
    //                                                                                  ->where('enoughincome_id',2)
    //                                                                                  ->first();
    //                                  if(count($registerhasoccupationenoughincome) != 0 ){
    //                                      $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
    //                                      $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
    //                                  }
                     
    //                              }
    //                          }

    //                          if($hasoccupation !=0 ){
    //                             $_hasoccupation_enoughincome = number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
    //                         }else{
    //                             $_hasoccupation_enoughincome = 0;
    //                         }
                             
    //                          $builder .= "โครงการ: " . $participate->project_readiness_name . " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้พอเพียง: " . $hasoccupation_enoughincome  . " (".  $_hasoccupation_enoughincome . "%) \n\n";                           
    //                          $sectionarray_dept3[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome );        
    //                      } 
    //                  }

    //                 if($totalhasoccupation !=0 ){
    //                     $_totalhasoccupation_enoughincome = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
    //                 }else{
    //                     $_totalhasoccupation_enoughincome =0;
    //                 }

    //                  $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . $_totalhasoccupation_enoughincome . " %) \n";
    //                  $occupationarray_dept3[] = array('id' => $item->map_code , 'value' => $_totalhasoccupation_enoughincome , 'province' => $item->province_name, 'message' => "$builder"   );        
    //              }
    //          }
    //      }   
 
    //     //สร้าง collection dept1
    //      $recuritdata_dept3 = collect( $occupationarray_dept3 );
    //      $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );  


    //     return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
    //     "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
    //     "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
    //     'filter_recuritdata' => Request::input('recuritdata') ));  
    
    // }
    public function MainReportReadiness(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $readinessarray_dept1 = array();
        $sectionarray_dept1 = array();
        $readinessarray_dept2 = array();
        $sectionarray_dept2 = array();
        $readinessarray_dept3 = array();
        $sectionarray_dept3 = array();

        //================กรมคุมประพฤติ===============
        $builder = "";
        foreach ($province as $key => $item){
            //ในจังหวัด (map_code)มี section ไหนบ้าง
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();
            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }

            if (count($section_arr) > 0) {
                $readiness = ReadinessSection::where('project_id' , $project->project_id)
                            ->where('project_type',1)
                            ->where('department_id' , 1)
                            ->where('actualexpense' ,'!=', 0)
                            ->whereIn('section_id',$section_arr)
                            ->get();               

                            if(count($readiness) > 0){
                                $totaltargetparticipate = 0;                  
                                $totalactualparticipate = 0;
                                $_builder ="";
                                foreach($section_arr as $key => $_item) {
                                    $builder = "";
                                    $_p = $readiness->where('section_id',$_item)->first();
                                    if( count($_p) > 0 ){   
                                        $target = 0;  
                                        $actualparticipate = 0; 
                                        $sec_target = 0;  
                                        $sec_actualparticipate = 0; 
                                        $section = Section::where('section_id',$_item)->first();
                                        $_section = $readiness->where('section_id',$_item)->all();
                                        foreach($_section as $key => $sec){
                                            $target = $sec->projectreadinesstarget;
                                            $sec_target = $sec_target + $target ;
                                            $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                            // $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                            $actualparticipate = ParticipateGroup::where('readiness_section_id' , $sec->readiness_section_id)->count();                                            
                                            $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
            
                                            $percent = 0;
                                            if($target!=0){
                                                $percent = $actualparticipate/$target;
                                            }
            
                                            $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                                        }
                                        $_sec = Section::where('department_id',1)->where('section_id',$_item)->first();
                                        $builder =  $_sec->section_name  .  "\n" . $builder;
                                        $_builder .=  $builder;
                                        $sectionarray_dept1[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                                    } 
                                  }
                                $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                                $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                                $readinessarray_dept1[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                            }
            }
        }   

       //สร้าง collection dept1
        $recuritdata_dept1 = collect( $readinessarray_dept1 );
        $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    //================กรมคราชทัณฑ์==============
    $builder = "";
    foreach ($province as $key => $item){
        //ในจังหวัด (map_code)มี section ไหนบ้าง
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {
            $readiness = ReadinessSection::where('project_id' , $project->project_id)
                        ->where('project_type',1)
                        ->where('department_id' , 2)
                        ->where('actualexpense' ,'!=', 0)
                        ->whereIn('section_id',$section_arr)
                        ->get();                 

                        if(count($readiness) > 0){
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $_builder ="";
                            foreach($section_arr as $key => $_item) {
                                $builder = "";
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( count($_p) > 0 ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 
                                    $section = Section::where('section_id',$_item)->first();
                                    $_section = $readiness->where('section_id',$_item)->all();
                                    foreach($_section as $key => $sec){
                                        $target = $sec->projectreadinesstarget;
                                        $sec_target = $sec_target + $target ;
                                        $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                        // $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $sec->readiness_section_id)->count();
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
        
                                        $percent = 0;
                                        if($target!=0){
                                            $percent = $actualparticipate/$target;
                                        }
        
                                        $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                                    }
                                    $_sec = Section::where('department_id',2)->where('section_id',$_item)->first();
                                    $builder =  $_sec->section_name  .  "\n" . $builder;
                                    $_builder .=  $builder;
                                    $sectionarray_dept2[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                                } 
                            }
                            $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                            $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                            $readinessarray_dept2[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                        }
        }
    }   

    //สร้าง collection dept2
    $recuritdata_dept2 = collect( $readinessarray_dept2 );
    $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    //================กรมคราชทัณฑ์==============
    $builder = "";
    foreach ($province as $key => $item){
        //ในจังหวัด (map_code)มี section ไหนบ้าง
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {
            $readiness = ReadinessSection::where('project_id' , $project->project_id)
                        ->where('project_type',1)
                        ->where('department_id' , 3)
                        ->where('actualexpense' ,'!=', 0)
                        ->whereIn('section_id',$section_arr)
                        ->get();                 

                        if(count($readiness) > 0){
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $_builder ="";
                            foreach($section_arr as $key => $_item) {
                                $builder = "";
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( count($_p) > 0 ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 
                                    $section = Section::where('section_id',$_item)->first();
                                    $_section = $readiness->where('section_id',$_item)->all();
                                    foreach($_section as $key => $sec){
                                        $target = $sec->projectreadinesstarget;
                                        $sec_target = $sec_target + $target ;
                                        $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                        // $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $sec->readiness_section_id)->count();
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
        
                                        $percent = 0;
                                        if($target!=0){
                                            $percent = $actualparticipate/$target;
                                        }
        
                                        $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                                    }
                                    $_sec = Section::where('department_id',3)->where('section_id',$_item)->first();
                                    $builder =  $_sec->section_name  .  "\n" . $builder;
                                    $_builder .=  $builder;
                                    $sectionarray_dept3[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                                } 
                            }
                            $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                            $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                            $readinessarray_dept3[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                        }
        }
    }   

    //สร้าง collection dept3
    $recuritdata_dept3 = collect( $readinessarray_dept3 );
    $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

    return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
            "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
            "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
            'filter_recuritdata' => Request::input('recuritdata') ));  
    
    }

    public function DeptReportReadiness(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();

        $readinessarray = array();
        $sectionarray = array();

        $builder = "";
        foreach ($province as $key => $item){
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();

            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }
        
            if (count($section_arr) > 0) {
                $readiness = ReadinessSection::where('project_id' , $project->project_id)
                            ->where('project_type',1)
                            ->where('department_id' , $auth->department_id)
                            ->where('actualexpense' ,'!=', 0)
                            ->whereIn('section_id',$section_arr)
                            ->get(); 
// echo $readiness;
                if(count($readiness) > 0){
                    $totaltargetparticipate = 0;                  
                    $totalactualparticipate = 0;
                    $_builder ="";
                    foreach($section_arr as $key => $_item) {
                        $builder = "";
                        $_p = $readiness->where('section_id',$_item)->first();
                        if( count($_p) > 0 ){   
                            $target = 0;  
                            $actualparticipate = 0; 
                            $sec_target = 0;  
                            $sec_actualparticipate = 0; 
                            $section = Section::where('section_id',$_item)->first();
                            $_section = $readiness->where('section_id',$_item)->all();
                            foreach($_section as $key => $sec){
                                $target = $sec->projectreadinesstarget;
                                $sec_target = $sec_target + $target ;
                                $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                // $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                $actualparticipate = ParticipateGroup::where('readiness_section_id' , $sec->readiness_section_id)->count();                                            
                                $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

                                $percent = 0;
                                if($target!=0){
                                    $percent = $actualparticipate/$target;
                                }

                                $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                            }
                            $_sec = Section::where('department_id',$auth->department_id)->where('section_id',$_item)->first();
                            $builder =  $_sec->section_name  .  "\n" . $builder;
                            $_builder .=  $builder;
                            $sectionarray[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                        } 
                      }
                    $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                    $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                    $readinessarray[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                }
            }
        }   

       //สร้าง collection 
        $readinessdata = collect( $readinessarray );
        $readinessdatabysection = collect( $sectionarray );

        //  return $readinessdatabysection;
        return json_encode(array("readinessdatabysection" => $readinessdatabysection,"_row" => count($readinessdatabysection),"readinessdata" => $readinessdata,"row" => count($readinessdata), 'filter_readinessdata' => Request::input('readinessdata') ));  
    }
    
    public function DeptReportOccupation(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();

        $readinessarray = array();
        $sectionarray = array();

        $builder = "";
        foreach ($province as $key => $item){
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();

            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }
        
            if (count($section_arr) > 0) {
                $readiness = ReadinessSection::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->where('department_id' , $auth->department_id)
                            ->where('actualexpense' ,'!=', 0)
                            ->whereIn('section_id',$section_arr)
                            ->get(); 

                if(count($readiness) > 0){
                    $totaltargetparticipate = 0;                  
                    $totalactualparticipate = 0;
                    $_builder ="";
                    foreach($section_arr as $key => $_item) {
                        $builder = "";
                        $_p = $readiness->where('section_id',$_item)->first();
                        if( count($_p) > 0 ){   
                            $target = 0;  
                            $actualparticipate = 0; 
                            $sec_target = 0;  
                            $sec_actualparticipate = 0; 
                            $section = Section::where('section_id',$_item)->first();
                            $_section = $readiness->where('section_id',$_item)->all();
                            foreach($_section as $key => $sec){
                                $target = $sec->projectreadinesstarget;
                                $sec_target = $sec_target + $target ;
                                $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                // $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                $actualparticipate = ParticipateGroup::where('readiness_section_id' , $sec->readiness_section_id)->count();                                            
                                $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

                                $percent = 0;
                                if($target!=0){
                                    $percent = $actualparticipate/$target;
                                }

                                $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                            }
                            $_sec = Section::where('department_id',$auth->department_id)->where('section_id',$_item)->first();
                            $builder =  $_sec->section_name  .  "\n" . $builder;
                            $_builder .=  $builder;
                            $sectionarray[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                        } 
                      }
                    $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                    $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                    $readinessarray[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                }
            }
        }   

       //สร้าง collection 
        $readinessdata = collect( $readinessarray );
        $readinessdatabysection = collect( $sectionarray );
        return json_encode(array("readinessdatabysection" => $readinessdatabysection,"_row" => count($readinessdatabysection),"readinessdata" => $readinessdata,"row" => count($readinessdata), 'filter_readinessdata' => Request::input('readinessdata') ));  
    }

    public function MainReportOccupation(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $readinessarray_dept1 = array();
        $sectionarray_dept1 = array();
        $readinessarray_dept2 = array();
        $sectionarray_dept2 = array();
        $readinessarray_dept3 = array();
        $sectionarray_dept3 = array();

        //================กรมคุมประพฤติ===============
        $builder = "";
        foreach ($province as $key => $item){
            //ในจังหวัด (map_code)มี section ไหนบ้าง
            $section = Section::where('map_code', $item->map_code)->get() ;
            $section_arr = array();
            foreach($section as $val){
                $section_arr[] = $val->section_id;
            }

            if (count($section_arr) > 0) {
                $readiness = ReadinessSection::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->where('department_id' , 1)
                            ->where('actualexpense' ,'!=', 0)
                            ->whereIn('section_id',$section_arr)
                            ->get();               

                            if(count($readiness) > 0){
                                $totaltargetparticipate = 0;                  
                                $totalactualparticipate = 0;
                                $_builder ="";
                                foreach($section_arr as $key => $_item) {
                                    $builder = "";
                                    $_p = $readiness->where('section_id',$_item)->first();
                                    if( count($_p) > 0 ){   
                                        $target = 0;  
                                        $actualparticipate = 0; 
                                        $sec_target = 0;  
                                        $sec_actualparticipate = 0; 
                                        $section = Section::where('section_id',$_item)->first();
                                        $_section = $readiness->where('section_id',$_item)->all();
                                        foreach($_section as $key => $sec){
                                            $target = $sec->projectreadinesstarget;
                                            $sec_target = $sec_target + $target ;
                                            $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                            
                                            $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
            
                                            $percent = 0;
                                            if($target!=0){
                                                $percent = $actualparticipate/$target;
                                            }
            
                                            $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                                        }
                                        $_sec = Section::where('department_id',1)->where('section_id',$_item)->first();
                                        $builder =  $_sec->section_name  .  "\n" . $builder;
                                        $_builder .=  $builder;
                                        $sectionarray_dept1[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                                    } 
                                  }
                                $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                                $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                                $readinessarray_dept1[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                            }
            }
        }   

       //สร้าง collection dept1
        $recuritdata_dept1 = collect( $readinessarray_dept1 );
        $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    //================กรมคราชทัณฑ์==============
    $builder = "";
    foreach ($province as $key => $item){
        //ในจังหวัด (map_code)มี section ไหนบ้าง
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {
            $readiness = ReadinessSection::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->where('department_id' , 2)
                        ->where('actualexpense' ,'!=', 0)
                        ->whereIn('section_id',$section_arr)
                        ->get();                 

                        if(count($readiness) > 0){
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $_builder ="";
                            foreach($section_arr as $key => $_item) {
                                $builder = "";
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( count($_p) > 0 ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 
                                    $section = Section::where('section_id',$_item)->first();
                                    $_section = $readiness->where('section_id',$_item)->all();
                                    foreach($_section as $key => $sec){
                                        $target = $sec->projectreadinesstarget;
                                        $sec_target = $sec_target + $target ;
                                        $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
        
                                        $percent = 0;
                                        if($target!=0){
                                            $percent = $actualparticipate/$target;
                                        }
        
                                        $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                                    }
                                    $_sec = Section::where('department_id',2)->where('section_id',$_item)->first();
                                    $builder =  $_sec->section_name  .  "\n" . $builder;
                                    $_builder .=  $builder;
                                    $sectionarray_dept2[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                                } 
                            }
                            $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                            $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                            $readinessarray_dept2[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                        }
        }
    }   

    //สร้าง collection dept2
    $recuritdata_dept2 = collect( $readinessarray_dept2 );
    $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    //================กรมคราชทัณฑ์==============
    $builder = "";
    foreach ($province as $key => $item){
        //ในจังหวัด (map_code)มี section ไหนบ้าง
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {
            $readiness = ReadinessSection::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->where('department_id' , 3)
                        ->where('actualexpense' ,'!=', 0)
                        ->whereIn('section_id',$section_arr)
                        ->get();                 

                        if(count($readiness) > 0){
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $_builder ="";
                            foreach($section_arr as $key => $_item) {
                                $builder = "";
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( count($_p) > 0 ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 
                                    $section = Section::where('section_id',$_item)->first();
                                    $_section = $readiness->where('section_id',$_item)->all();
                                    foreach($_section as $key => $sec){
                                        $target = $sec->projectreadinesstarget;
                                        $sec_target = $sec_target + $target ;
                                        $totaltargetparticipate = $totaltargetparticipate +  $target ;
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$sec->readiness_section_id)->sum('participate_num');
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate;
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
        
                                        $percent = 0;
                                        if($target!=0){
                                            $percent = $actualparticipate/$target;
                                        }
        
                                        $builder .= "หลักสูตร: " . $sec->projectreadinessname . " เป้าหมาย: " .   $target . " เข้าร่วม: " . $actualparticipate  . " (".  number_format( ($percent) * 100 , 2) . "%) \n\n";                      
                                    }
                                    $_sec = Section::where('department_id',3)->where('section_id',$_item)->first();
                                    $builder =  $_sec->section_name  .  "\n" . $builder;
                                    $_builder .=  $builder;
                                    $sectionarray_dept3[] = array('label' => $_sec->section_name , 'value' => $sec_actualparticipate );        
                                } 
                            }
                            $builder = "จังหวัด " . $item->province_name . "\n\n" . $_builder  ;                   
                            $builder .= "\nสรุปผลรวม เป้าหมาย " . $totaltargetparticipate . " เข้าร่วม " . $totalactualparticipate . " (" . number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2) . " %) \n";
                            $readinessarray_dept3[] = array('id' => $item->map_code , 'value' => number_format( ($totalactualparticipate / $totaltargetparticipate) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   );        
                        }
        }
    }   

    //สร้าง collection dept3
    $recuritdata_dept3 = collect( $readinessarray_dept3 );
    $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

    return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
            "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
            "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
            'filter_recuritdata' => Request::input('recuritdata') ));  
    
    }
  
    public function DeptReportOccupationFollowup(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $occupationarray = array();
        $sectionarray = array();                    

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                foreach ($province as $key => $item){
                    $section = Section::where('map_code', $item->map_code)->get() ;
                    $section_arr = array();
                    foreach($section as $val){
                        $section_arr[] = $val->section_id;
                    }
        
                    if (count($section_arr) > 0) {
                        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('actualexpense' ,'!=', 0)
                                ->where('department_id' , $auth->department_id)
                                ->whereIn('section_id',$section_arr)
                                ->get();       
        
                        if($readiness->count() > 0){
                            $builder = "";
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $totalhasoccupation = 0;
                            $provincename="";
                            $numsection=0;
                            
                            foreach($section_arr as $key => $_item) {
                                $hasoccupation =0;
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( !empty($_p) ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 

                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();

                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        // $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();                                            
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                                    }

                                    $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                                    if (count($register) !=0 ){
                                        foreach($register as $_item){
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $totalhasoccupation = $totalhasoccupation + 1;
                                                $hasoccupation = $hasoccupation + 1;
                                            }
                                        }
                                    }

                                    if($sec_actualparticipate !=0 ){
                                        $percent =number_format( ($hasoccupation/ $sec_actualparticipate) * 100 , 2);
                                    }else{
                                        $percent =0;
                                    }                                    
                                    $builder .=  " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $sec_actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  $percent . "%) \n\n";                           
                                    $sectionarray[] = array('label' => $section->section_name , 'value' => $hasoccupation ); 
                                    
                                } 
                              }
                            if($totalactualparticipate !=0 ){
                                $percent =number_format( ($totalhasoccupation/ $totalactualparticipate) * 100 , 2);
                            }else{
                                $percent =0;
                            } 
                            
                            $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . $percent . " %)";
                            $occupationarray[] = array('id' => $item->map_code , 'value' => $percent  , 'province' => $item->province_name, 'message' => "$builder"   );  
                        }
                    }
                }  
                    
       //สร้าง collection 
        $occupationdata = collect( $occupationarray );
        $occupationdatabysection = collect( $sectionarray );
        return json_encode(array("occupationdatabysection" => $occupationdatabysection,"_row" => count($occupationdatabysection),"occupationdata" => $occupationdata,"row" => count($occupationdata), 'filter_occupationdata' => Request::input('occupationdata') ));  
    
    } 
 
    public function MainReportOccupationFollowup(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $province = Province::all();
        $occupationarray_dept1 = array();
        $sectionarray_dept1 = array();
        $occupationarray_dept2 = array();
        $sectionarray_dept2 = array();
        $occupationarray_dept3 = array();
        $sectionarray_dept3 = array();                   

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                foreach ($province as $key => $item){
                    $section = Section::where('map_code', $item->map_code)->get() ;
                    $section_arr = array();
                    foreach($section as $val){
                        $section_arr[] = $val->section_id;
                    }
        
                    if (count($section_arr) > 0) {
                        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id' , 1)
                                ->where('actualexpense' ,'!=', 0)
                                ->whereIn('section_id',$section_arr)
                                ->get();       
        
                        if($readiness->count() > 0){
                            $builder = "";
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $totalhasoccupation = 0;
                            $provincename="";
                            $numsection=0;
                            
                            foreach($section_arr as $key => $_item) {
                                $hasoccupation =0;
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( !empty($_p) ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 

                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();

                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        // $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                                    }

                                    $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                                    if (count($register) !=0 ){
                                        foreach($register as $_item){
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $totalhasoccupation = $totalhasoccupation + 1;
                                                $hasoccupation = $hasoccupation + 1;
                                                // echo $hasoccupation . "<br>";
                                            }
                                        }
                                    }

                                    // $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

                                    if($sec_actualparticipate !=0 ){
                                        $percent =number_format( ($totalhasoccupation/ $totalactualparticipate) * 100 , 2);
                                    }else{
                                        $percent =0;
                                    }                                    
                                    $builder .=  " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $sec_actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  $percent . "%) \n\n";                           
                                    
                                    $sectionarray_dept1[] = array('label' => $section->section_name , 'value' => $hasoccupation ); 
                                } 
                              }
                            //   echo $hasoccupation . "<br>";
                            if($totalactualparticipate !=0 ){
                                $percent =number_format( ($totalhasoccupation/ $totalactualparticipate) * 100 , 2);
                            }else{
                                $percent =0;
                            } 
                            $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . $percent . " %)";
                            $occupationarray_dept1[] = array('id' => $item->map_code , 'value' => $percent  , 'province' => $item->province_name, 'message' => "$builder"   );  
                        }
                    }
                }  

    //สร้าง collection dept1
    $recuritdata_dept1 = collect( $occupationarray_dept1 );
    $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    // กรมราชทัณฑ์
    $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                foreach ($province as $key => $item){
                    $section = Section::where('map_code', $item->map_code)->get() ;
                    $section_arr = array();
                    foreach($section as $val){
                        $section_arr[] = $val->section_id;
                    }
        
                    if (count($section_arr) > 0) {
                        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id' , 2)
                                ->where('actualexpense' ,'!=', 0)
                                ->whereIn('section_id',$section_arr)
                                ->get();       
        
                        if($readiness->count() > 0){
                            $builder = "";
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $totalhasoccupation = 0;
                            $provincename="";
                            $numsection=0;
                            
                            foreach($section_arr as $key => $_item) {
                                $hasoccupation =0;
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( !empty($_p) ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 

                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();

                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        // $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                                    }

                                    $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                                    if (count($register) !=0 ){
                                        foreach($register as $_item){
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $totalhasoccupation = $totalhasoccupation + 1;
                                                $hasoccupation = $hasoccupation + 1;
                                            }
                                        }
                                    }

                                    // $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

                                    if($sec_actualparticipate !=0 ){
                                        $percent =number_format( ($hasoccupation/ $sec_actualparticipate) * 100 , 2);
                                    }else{
                                        $percent =0;
                                    }                                    
                                    $builder .=  " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $sec_actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  $percent . "%) \n\n";                           
                                    $sectionarray_dept2[] = array('label' => $section->section_name , 'value' => $hasoccupation ); 
                                } 
                              }
                            if($totalactualparticipate !=0 ){
                                $percent =number_format( ($hasoccupation/ $sec_actualparticipate) * 100 , 2);
                            }else{
                                $percent =0;
                            } 
                            $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . $percent . " %)";
                            $occupationarray_dept2[] = array('id' => $item->map_code , 'value' => $percent  , 'province' => $item->province_name, 'message' => "$builder"   );  
                        }
                    }
                }  
                    
    //สร้าง collection dept2
    $recuritdata_dept2 = collect( $occupationarray_dept2 );
    $recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    // กรมพินิจ

    $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                foreach ($province as $key => $item){
                    $section = Section::where('map_code', $item->map_code)->get() ;
                    $section_arr = array();
                    foreach($section as $val){
                        $section_arr[] = $val->section_id;
                    }
        
                    if (count($section_arr) > 0) {
                        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id' , 3)
                                ->where('actualexpense' ,'!=', 0)
                                ->whereIn('section_id',$section_arr)
                                ->get();       
        
                        if($readiness->count() > 0){
                            $builder = "";
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $totalhasoccupation = 0;
                            $provincename="";
                            $numsection=0;
                            
                            foreach($section_arr as $key => $_item) {
                                $hasoccupation =0;
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( !empty($_p) ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 

                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();

                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        // $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                                    }

                                    $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                                    if (count($register) !=0 ){
                                        foreach($register as $_item){
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $totalhasoccupation = $totalhasoccupation + 1;
                                                $hasoccupation = $hasoccupation + 1;
                                            }
                                        }
                                    }

                                    // $totalactualparticipate = $totalactualparticipate + $actualparticipate ;

                                    if($sec_actualparticipate !=0 ){
                                        $percent =number_format( ($hasoccupation/ $sec_actualparticipate) * 100 , 2);
                                    }else{
                                        $percent =0;
                                    }                                    
                                    $builder .=  " สำนักงาน: ". $section->section_name . " เข้าร่วม: " . $sec_actualparticipate . " มีอาชีพ: " . $hasoccupation  . " (".  $percent . "%) \n\n";                           
                                    $sectionarray_dept3[] = array('label' => $section->section_name , 'value' => $hasoccupation ); 
                                } 
                              }
                            if($totalactualparticipate !=0 ){
                                $percent =number_format( ($hasoccupation/ $sec_actualparticipate) * 100 , 2);
                            }else{
                                $percent =0;
                            } 
                            $builder .= "\nเข้าร่วม " . $totalactualparticipate . " มีอาชีพ " . $totalhasoccupation . " (" . $percent . " %)";
                            $occupationarray_dept3[] = array('id' => $item->map_code , 'value' => $percent  , 'province' => $item->province_name, 'message' => "$builder"   );  
                        }
                    }
                }  
                    
    //สร้าง collection dept3
    $recuritdata_dept3 = collect( $occupationarray_dept3 );
    $recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

        return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
        "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
        "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
        'filter_recuritdata' => Request::input('recuritdata') ));  
    
    } 

    public function DeptReportOccupationFollowupEnoughExpense(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $occupationarray = array();
        $sectionarray = array();                
    

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                foreach ($province as $key => $item){
                    $section = Section::where('map_code', $item->map_code)->get() ;
                    $section_arr = array();
                    foreach($section as $val){
                        $section_arr[] = $val->section_id;
                    }
        
                    if (count($section_arr) > 0) {
                        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('actualexpense' ,'!=', 0)
                                ->where('department_id' , $auth->department_id)
                                ->whereIn('section_id',$section_arr)
                                ->get();       
        
                        if($readiness->count() > 0){
                            $builder = "จังหวัด " . $item->province_name . "\n\n";
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $totalhasoccupation = 0;
                            $totalhasoccupation_enoughincome = 0;
                            $provincename="";
                            $numproject=0;
                            
                            foreach($section_arr as $key => $_item) {
                                $hasoccupation = 0;
                                $hasoccupation_enoughincome = 0;
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( !empty($_p) ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 

                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();

                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                       
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                                    }

                                    $registers = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 
                                    if (!empty($registers) ){
                                        foreach($registers as $_item){
                                             
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $totalhasoccupation = $totalhasoccupation + 1;
                                                $hasoccupation = $hasoccupation + 1;
                                            }
        
                                            $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                                            ->where('occupation_id','!=',1)
                                                                                            ->where('enoughincome_id',2)
                                                                                            ->first();
                                            if(count($registerhasoccupationenoughincome) != 0 ){
                                                
                                                $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
                                                $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
                                            }
        
        
                                        }
                                    }

                                    if($hasoccupation !=0 ){
                                        $percent =number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
                                    }else{
                                        $percent =0;
                                    }                                    
                                    $builder .=  " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้เพียงพอ: " . $hasoccupation_enoughincome  . " (".  $percent . "%) \n\n";                           
                                    $sectionarray[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome ); 
                                    
                                } 
                              }
                            if($totalhasoccupation !=0 ){
                                $percent =number_format( ($totalhasoccupation_enoughincome/ $totalhasoccupation) * 100 , 2);
                            }else{
                                $percent =0;
                            } 
                            
                            $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2) . " %) \n";
                            $occupationarray[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   ); 
                                
                        }
                    }
                }  

       //สร้าง collection 
        $occupationdata = collect( $occupationarray );
        $occupationdatabysection = collect( $sectionarray );
        return json_encode(array("occupationdatabysection" => $occupationdatabysection,"_row" => count($occupationdatabysection),"occupationdata" => $occupationdata,"row" => count($occupationdata), 'filter_occupationdata' => Request::input('occupationdata') ));  
    
    } 
    public function MainReportEnoughIncome(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $province = Province::all();
        $province = Province::all();
        $occupationarray_dept1 = array();
        $sectionarray_dept1 = array();
        $occupationarray_dept2 = array();
        $sectionarray_dept2 = array();
        $occupationarray_dept3 = array();
        $sectionarray_dept3 = array();                   

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                foreach ($province as $key => $item){
                    $section = Section::where('map_code', $item->map_code)->get() ;
                    $section_arr = array();
                    foreach($section as $val){
                        $section_arr[] = $val->section_id;
                    }
        
                    if (count($section_arr) > 0) {
                        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id' , 1)
                                ->where('actualexpense' ,'!=', 0)
                                ->whereIn('section_id',$section_arr)
                                ->get();       
        
                        if($readiness->count() > 0){
                            $builder = "";
                            $totaltargetparticipate = 0;                  
                            $totalactualparticipate = 0;
                            $totalhasoccupation = 0;
                            $totalhasoccupation_enoughincome = 0;
                            $provincename="";
                            $numproject=0;
                            
                            foreach($section_arr as $key => $_item) {
                                $hasoccupation =0;
                                $hasoccupation_enoughincome = 0;
                                $_p = $readiness->where('section_id',$_item)->first();
                                if( !empty($_p) ){   
                                    $target = 0;  
                                    $actualparticipate = 0; 
                                    $sec_actualparticipate = 0; 
                                    $sec_target = 0;  
                                    $sec_actualparticipate = 0; 

                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();

                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                                        $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                                    }

                                    $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                                    if (count($register) !=0 ){
                                        foreach($register as $_item){
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $totalhasoccupation = $totalhasoccupation + 1;
                                                $hasoccupation = $hasoccupation + 1;
                                                // echo $hasoccupation . "<br>";
                                            }

                                            $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                            ->where('occupation_id','!=',1)
                                                                            ->where('enoughincome_id',2)
                                                                            ->first();
                                            if(count($registerhasoccupationenoughincome) != 0 ){

                                            $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
                                            $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
                                            }
                                        }
                                    }

                                    if($hasoccupation !=0 ){
                                        $percent =number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
                                    }else{
                                        $percent =0;
                                    }                                    
                                    $builder .=  " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้เพียงพอ: " . $hasoccupation_enoughincome  . " (".  $percent . "%) \n\n";                           
                                    $sectionarray_dept1[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome ); 
                                    
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $percent =number_format( ($totalhasoccupation_enoughincome/ $totalhasoccupation) * 100 , 2);
                            }else{
                                $percent =0;
                            } 
                            
                            $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2) . " %) \n";
                            $occupationarray_dept1[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   ); 
                              
                        }
                    }
                }  

    //สร้าง collection dept1
    $recuritdata_dept1 = collect( $occupationarray_dept1 );
    $recuritdatabysection_dept1 = collect( $sectionarray_dept1 );

    //กรมราชทัณฑ์
    foreach ($province as $key => $item){
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {
            $readiness = ReadinessSection::where('project_id' , $project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , 2)
                    ->where('actualexpense' ,'!=', 0)
                    ->whereIn('section_id',$section_arr)
                    ->get();       

            if($readiness->count() > 0){
                $builder = "";
                $totaltargetparticipate = 0;                  
                $totalactualparticipate = 0;
                $totalhasoccupation = 0;
                $totalhasoccupation_enoughincome = 0;
                $provincename="";
                $numproject=0;
                
                foreach($section_arr as $key => $_item) {
                    $hasoccupation =0;
                    $hasoccupation_enoughincome = 0;
                    $_p = $readiness->where('section_id',$_item)->first();
                    if( !empty($_p) ){   
                        $target = 0;  
                        $actualparticipate = 0; 
                        $sec_actualparticipate = 0; 
                        $sec_target = 0;  
                        $sec_actualparticipate = 0; 

                        $section = Section::where('section_id',$_item)->first();
                        $_readiness = $readiness->where('section_id',$_item)->all();

                        $readiness_arr = array();
                        foreach($_readiness as $r){
                            $readiness_arr[] = $r->readiness_section_id;
                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                            $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();
                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                            $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                        }

                        $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                        if (count($register) !=0 ){
                            foreach($register as $_item){
                                $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                        ->where('occupation_id','!=',1)
                                                                        ->first();
                                if(count($registerhasoccupation) != 0 ){
                                    $totalhasoccupation = $totalhasoccupation + 1;
                                    $hasoccupation = $hasoccupation + 1;
                                    // echo $hasoccupation . "<br>";
                                }

                                $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                ->where('occupation_id','!=',1)
                                                                ->where('enoughincome_id',2)
                                                                ->first();
                                if(count($registerhasoccupationenoughincome) != 0 ){

                                $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
                                $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
                                }
                            }
                        }

                        if($hasoccupation !=0 ){
                            $percent =number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
                        }else{
                            $percent =0;
                        }                                    
                        $builder .=  " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้เพียงพอ: " . $hasoccupation_enoughincome  . " (".  $percent . "%) \n\n";                           
                        $sectionarray_dept2[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome ); 
                        
                    } 
                  }

                  if($totalhasoccupation !=0 ){
                    $percent =number_format( ($totalhasoccupation_enoughincome/ $totalhasoccupation) * 100 , 2);
                }else{
                    $percent =0;
                } 
                
                $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2) . " %) \n";
                $occupationarray_dept2[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   ); 
                  
            }
        }
    }  

//สร้าง collection dept2
$recuritdata_dept2 = collect( $occupationarray_dept2 );
$recuritdatabysection_dept2 = collect( $sectionarray_dept2 );

    //กรมราชทัณฑ์
    foreach ($province as $key => $item){
        $section = Section::where('map_code', $item->map_code)->get() ;
        $section_arr = array();
        foreach($section as $val){
            $section_arr[] = $val->section_id;
        }

        if (count($section_arr) > 0) {
            $readiness = ReadinessSection::where('project_id' , $project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , 3)
                    ->where('actualexpense' ,'!=', 0)
                    ->whereIn('section_id',$section_arr)
                    ->get();       

            if($readiness->count() > 0){
                $builder = "";
                $totaltargetparticipate = 0;                  
                $totalactualparticipate = 0;
                $totalhasoccupation = 0;
                $totalhasoccupation_enoughincome = 0;
                $provincename="";
                $numproject=0;
                
                foreach($section_arr as $key => $_item) {
                    $hasoccupation =0;
                    $hasoccupation_enoughincome = 0;
                    $_p = $readiness->where('section_id',$_item)->first();
                    if( !empty($_p) ){   
                        $target = 0;  
                        $actualparticipate = 0; 
                        $sec_actualparticipate = 0; 
                        $sec_target = 0;  
                        $sec_actualparticipate = 0; 

                        $section = Section::where('section_id',$_item)->first();
                        $_readiness = $readiness->where('section_id',$_item)->all();

                        $readiness_arr = array();
                        foreach($_readiness as $r){
                            $readiness_arr[] = $r->readiness_section_id;
                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                            $actualparticipate = ParticipateGroup::where('readiness_section_id' , $r->readiness_section_id)->count();
                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
                            $sec_actualparticipate = $sec_actualparticipate + $actualparticipate ;
                        }

                        $register = $participategroup->whereIn('readiness_section_id',$readiness_arr)->all() ;//count('register_id'); 

                        if (count($register) !=0 ){
                            foreach($register as $_item){
                                $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                        ->where('occupation_id','!=',1)
                                                                        ->first();
                                if(count($registerhasoccupation) != 0 ){
                                    $totalhasoccupation = $totalhasoccupation + 1;
                                    $hasoccupation = $hasoccupation + 1;
                                    // echo $hasoccupation . "<br>";
                                }

                                $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                ->where('occupation_id','!=',1)
                                                                ->where('enoughincome_id',2)
                                                                ->first();
                                if(count($registerhasoccupationenoughincome) != 0 ){

                                $totalhasoccupation_enoughincome = $totalhasoccupation_enoughincome + 1;
                                $hasoccupation_enoughincome = $hasoccupation_enoughincome + 1;
                                }
                            }
                        }

                        if($hasoccupation !=0 ){
                            $percent =number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
                        }else{
                            $percent =0;
                        }                                    
                        $builder .=  " สำนักงาน: ". $section->section_name . " มีอาชีพ: " . $hasoccupation . " รายได้เพียงพอ: " . $hasoccupation_enoughincome  . " (".  $percent . "%) \n\n";                           
                        $sectionarray_dept3[] = array('label' => $section->section_name , 'value' => $hasoccupation_enoughincome ); 
                        
                    } 
                  }

                  if($totalhasoccupation !=0 ){
                    $percent =number_format( ($totalhasoccupation_enoughincome/ $totalhasoccupation) * 100 , 2);
                }else{
                    $percent =0;
                } 
                
                $builder .= "\nมีอาชีพ " . $totalhasoccupation . " รายได้พอเพียง " . $totalhasoccupation_enoughincome . " (" . number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2) . " %) \n";
                $occupationarray_dept3[] = array('id' => $item->map_code , 'value' => number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2)  , 'province' => $item->province_name, 'message' => "$builder"   ); 
                  
            }
        }
    }  

//สร้าง collection dept3
$recuritdata_dept3 = collect( $occupationarray_dept3 );
$recuritdatabysection_dept3 = collect( $sectionarray_dept3 );

        return json_encode(array("recuritdatabysection_dept1" => $recuritdatabysection_dept1,"_row1sec" => count($recuritdatabysection_dept1),"recuritdata_dept1" => $recuritdata_dept1,"_row1dept" => count($recuritdata_dept1),
        "recuritdatabysection_dept2" => $recuritdatabysection_dept2,"_row2sec" => count($recuritdatabysection_dept2),"recuritdata_dept2" => $recuritdata_dept2,"_row2dept" => count($recuritdata_dept2),
        "recuritdatabysection_dept3" => $recuritdatabysection_dept3,"_row3sec" => count($recuritdatabysection_dept3),"recuritdata_dept3" => $recuritdata_dept3,"_row3dept" => count($recuritdata_dept3),        
        'filter_recuritdata' => Request::input('recuritdata') ));  
    
    } 

}


