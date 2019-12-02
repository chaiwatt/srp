<?php

namespace App\Http\Controllers;
use Auth;
use Excel;
use Request;
use Session;
use App\Model\Group;
use App\Model\Skill;
use App\Model\Amphur;
use App\Model\Prefix;
use App\Model\Married;
use App\Model\Project;
use App\Model\Section;
use App\Model\District;
use App\Model\Generate;
use App\Model\Military;
use App\Model\Position;
use App\Model\Province;
use App\Model\Register;
use App\Model\Religion;
use App\Model\Software;
use App\Model\Education;
use App\Model\SettingYear;
use App\Model\Registertype;
use App\Model\RegisterSkill;
use App\Model\RegisterDocument;
use App\Model\RegisterSoftware;
use App\Model\RegisterTraining;
use App\Model\RegisterEducation;
use App\Model\RegisterExperience;

class RecuritRegisterDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
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
        if( $filter == "" ){
            $q = $q->where('year_budget' , $project->year_budget);
        }
        $q = $q->where('register_status' , 1);
        $q = $q->orderBy('position_id');
        $register = $q->get();

        return view('recurit.register.department.index')->withProject($project)
                                                ->withRegister($register)
                                                ->withEmploy($employ)
                                                ->withFilter($filter);
    }

    public function View($id){
        if( $this->authdepartment() ){
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
   
        $register = Register::where('register_id' , $id)->where('department_id' , $auth->department_id)->where('register_status' , 1)->first();

        // return $register;
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

        return view('recurit.register.department.view')->withRegister($register)->withProject($project)
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

    public function ExportExcel(){


        if( $this->authdepartment() ){
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
        if( $filter == "" ){
            $q = $q->where('year_budget' , $project->year_budget);
        }
        $q = $q->where('register_status' , 1);
        $q = $q->orderBy('position_id');
        $register = $q->orderBy('section_id','asc')->get();
        $summary_array[] = array('ชื่อ-สกุล','หน่วยงาน','ตำแหน่ง','สถานะ','ระยะเวลาจ้างงาน'); 

        // return view('recurit.register.department.index')->withProject($project)
                                                // ->withRegister($register)
                                                // ->withEmploy($employ)
                                                // ->withFilter($filter);


        // if( $this->authdepartment() ){
        //     return redirect('logout');
        // }
        // $auth = Auth::user();
        // $setting = SettingYear::where('setting_status' , 1)->first();
        // $project = Project::where('year_budget' , $setting->setting_year)->first();
        // $section = Section::where('section_id',$auth->section_id)->first();

        // $assessee = PersonalAssessment::where('project_assesment_id', $id)->get();
        // $assessment = ProjectAssesment::where('project_assesment_id', $id)->first();

        // $summary_array[] = array('ชื่อ-สกุล','เลขที่บัตรประชาชน','ผลการประเมิน','การติดตาม','ต้องการสนับสนุน','ความสัมพันธ์ในครอบครัว','การมีรายได้','การมีอาชีพ'); 
            foreach( $register as $item ){
                $check = $employ->where('register_id',$item->register_id)->first();
                $_status = $item->registertypename;
                if(!Empty($check)){
                    $_status = $item->registertypename .'(จ้างงาน)';
                }
                $summary_array[] = array(
                    'name' =>  $item->prefixname . $item->name . ' ' .$item->lastname ,
                    'section' => Section::where('section_id',$item->section_id)->first()->section_name ,
                    'position' => Position::where('position_id',$item->position_id)->first()->position_name  ,
                    'status' => $_status ,
                    'hireduration' => $this->starthiredateth($item->starthiredate) . " ". $this->endhiredateth($item->endhiredate)                   
                );
            }    

        $excelfile = Excel::create("register", function($excel) use ($summary_array){
            $excel->setTitle("ผู้สมัครเข้าร่วมโครงการ");
            $excel->sheet('ผู้สมัครเข้าร่วมโครงการ', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  
          
    }

    public function starthiredateth($starthiredate){
        if($starthiredate != '0000-00-00'){
            return  date('d/m/' , strtotime( $starthiredate ) ).(date('Y',strtotime($starthiredate))+543);
        }else{
            return null;
        }
        
    }

    public function endhiredateth($endhiredate){
        if($endhiredate != '0000-00-00'){
            return date('d/m/' , strtotime( $endhiredate ) ).(date('Y',strtotime($endhiredate))+543);
        }else{
            return null;
        }
        
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
