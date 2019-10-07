<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Session;
use Auth;
use DB;
use PDF;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Position;
use App\Model\Department;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\Participate;
use App\Model\ProjectParticipate;
use App\Model\Trainer;
use App\Model\ProjectReadinessOfficer;
use App\Model\Company;
use App\Model\Transfer;
use App\Model\ReadinessExpense;
use App\Model\ParticipateGroup;
use App\Model\Group;
use App\Model\Prefix;
use App\Model\Register;
use App\Model\TrainingStatus;
use App\Model\ReadinessSection;
use App\Model\LogFile;

class ProjectReadinessDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                ->where('department_id',$auth->department_id)
                                ->where('project_type',1)
                                ->get();
        
        $readinesssection = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('department_id',$auth->department_id)
                                ->get();      

        return view('readiness.project.department.index')->withProject($project)
                                                    ->withReadinesssection($readinesssection)
                                                    ->withReadiness($readiness);

    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        return view('readiness.project.department.create')->withProject($project);
    }

	public function CreateSave(){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();
        $date = explode("/", Request::input('projectdate'));
        $projectdate = ($date[2]-543)."-".$date[1]."-".$date[0];
       
        $new = new ProjectReadiness;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->project_readiness_name = Request::input('name');
        $new->targetparticipate = Request::input('number');
        $new->budget = Request::input('budget');
        $new->project_readiness_desc = Request::input('detail');
        $new->projectdate = $projectdate;
        $new->project_type = 1;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 30;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect("readiness/project/department")->withSuccess("สร้างโครงการฝึกอบรมเตรียมความพร้อม");
	}

    public function Register(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('department_id', $auth->department_id)
                                    ->where('project_type',1)
                                    ->get();

        return view('readiness.project.department.register')->withProject($project)
                                                    ->withReadiness($readiness);
    }

    public function Edit($id){

        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('project_readiness_id',$id)
                                    ->where('project_type',1)
                                    ->first();

        return view('readiness.project.department.edit')->withProject($project)
                                                ->withReadiness($readiness);
    }

    public function EditSave(){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $id = Request::input('id');

        $date = explode("/", Request::input('projectdate'));
        $projectdate = ($date[2]-543)."-".$date[1]."-".$date[0];

        ProjectReadiness::where('project_readiness_id',$id)
                    ->where('project_type',1)
                    ->update([ 
                        'targetparticipate' => Request::input('number'), 
                        'budget' => Request::input('budget'),
                        'project_readiness_desc' => Request::input('detail'),
                        'projectdate' => $projectdate,
                        ]);
        ProjectParticipate::where('project_readiness_id',$id)
                        ->update([ 
                            'projectdate' => $projectdate,
                        ]);
        ParticipateGroup::where('project_readiness_id',$id)
                    ->update([ 
                         'projectdate' => $projectdate,
                    ]);  

        $new = new LogFile;
        $new->loglist_id = 31;
        $new->user_id = $auth->user_id;
        $new->save();                          

        return redirect('readiness/project/department')->withSuccess("โครงการอบรมได้แก้ไขแล้ว");

    }
    
    public function Delete($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user(); 
        ProjectReadiness::where('project_readiness_id' ,$id)
                        ->where('project_type',1)
                        ->delete();
        $new = new LogFile;
        $new->loglist_id = 32;
        $new->user_id = $auth->user_id;
        $new->save();
        return redirect('readiness/project/department')->withSuccess("ลบโครงการอบรมแล้ว");
    }

    public function Manage($id){
     
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();   
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $trainer = Trainer::where('project_readiness_id' ,$id)->get();
        $officer = ProjectReadinessOfficer::where('project_readiness_id' ,$id)->get();
        $company = Company::where('project_readiness_id' ,$id)->get();
        $reparticipate = ProjectParticipate::where('project_readiness_id' ,$id)->get();
        $participate = Participate::where('department_id', $auth->department_id)->get();
        $status = TrainingStatus::get();

        $department = Department::where('department_id',$auth->department_id)->first();

        $readiness = ProjectReadiness::where('project_readiness_id' ,$id)
                                    ->where('project_type',1)
                                    ->first();
        $section = Section::where('department_id',$auth->department_id)->get();
        $readinessexpense = ReadinessExpense::where('project_readiness_id' ,$id)
                                    ->where('project_type',1)
                                    ->first();
        $participategroup = ParticipateGroup::where('project_readiness_id' ,$id)
                                    ->where('project_type',1)
                                    ->where('department_id' , $auth->department_id)
                                    ->get();   

        $register = Register::get();                           
        $group = Group::where('group_status' , 1)->get();
        $prefix = Prefix::get();

        $exp = ReadinessExpense::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where('department_id' , $auth->department_id)
                                    ->sum('cost');

        $transfer = Transfer::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 4)
                                    ->where('transfer_status' , 1)
                                    ->sum('transfer_price');   

        $allreadinessexpense  =   $transfer - $exp ;                                                                       

        return view('readiness.project.department.manage')->withReadiness($readiness)
                                                        ->withSection($section)
                                                        ->withTrainer($trainer)
                                                        ->withCompany($company)
                                                        ->withOfficer($officer)
                                                        ->withStatus($status)
                                                        ->withReparticipate($reparticipate)
                                                        ->withReadinessexpense($readinessexpense)
                                                        ->withAllreadinessexpense($allreadinessexpense)
                                                        ->withParticipate($participate)
                                                        ->withRegister($register)
                                                        ->withParticipategroup($participategroup)
                                                        ->withGroup($group)
                                                        ->withDepartment($department)
                                                        ->withGroup($group)
                                                        ->withPrefix($prefix);
    }
    
    public function ManageSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $id = Request::input('id');
        $auth = Auth::user();  
        if (Request::input('section') == ""){
            return redirect('readiness/project/department/register')->withError("ไม่ได้เลือกหน่วยงานย่อย");
        }

        $date = explode("/", Request::input('projectdate'));
        $projectdate = ($date[2]-543)."-".$date[1]."-".$date[0];

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 4)
                        ->where('transfer_status' , 1)
                        ->sum('transfer_price');

    	if( $transfer == 0 ){
    		return redirect('readiness/project/department/register')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่มีเงินรับโอน");
        }
        
        $expense = ReadinessExpense::where('project_id' , $project->project_id)
                                ->where('project_type',1)
                                ->where('department_id' , $auth->department_id)
                                ->sum('cost');

        $allreadinessexpense = ReadinessExpense::where('project_id' , $project->project_id)
                                ->where('project_type',1)
                                ->where('department_id' , $auth->department_id)
                                ->get();

        $readinessexpense = ReadinessExpense::where('project_readiness_id',$id)
                                ->where('project_type',1)
                                ->get();

        if (count($readinessexpense) == 0){
            $sum = ( $allreadinessexpense->sum('cost') + Request::input('actualexpense') );
            if( $sum > $transfer ){
                return redirect('readiness/project/department/register')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากเงินรับโอนไม่เพียงพอกับเงินเบิกจ่ายจริง (คงเหลือ " . number_format( ($transfer) , 2 ) . " บาท)" );
            }
            $new = new ReadinessExpense;
            $new->project_readiness_id = $id;
            $new->department_id = $auth->department_id;
            $new->section_id = Request::input('section') ;
            $new->user_id = $auth->user_id;
            $new->cost = Request::input('actualexpense');
            $new->budget_id = 4;
            $new->year_budget = $setting->setting_year;
            $new->project_id = $project->project_id;
            $new->project_type = 1;
            $new->save();
        }else{

            $val = $allreadinessexpense->where('project_readiness_id',$id)->first();
            $diff = Request::input('actualexpense') - $val->cost ;

            if( ($allreadinessexpense->sum('cost') +  $diff ) > $transfer ){
                return redirect('readiness/project/department/register')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากเงินรับโอนไม่เพียงพอกับเงินเบิกจ่ายจริง (คงเหลือ " . number_format( ($allreadinessexpense->sum('cost') - $transfer) , 2 ) . " บาท เกิน " . number_format( ($diff) , 2 ) . " บาท )" );
            }
                ReadinessExpense::where('project_readiness_id',$id)
                                ->where('project_type',1)
                                ->update([ 
                                    'section_id' => Request::input('section'), 
                                    'cost' => Request::input('actualexpense'),
                                    'user_id' => $auth->user_id,
                                    ]);
        }
        
        $allrojectparticipate =  ProjectParticipate::where('project_readiness_id', $id)
                                                ->where('project_type',1)
                                                ->get();
        $participate = Participate::where('department_id', $auth->department_id)->get();
        if( count($participate) > 0 ){
            foreach( $participate as $key => $item ){
                $val =  $allrojectparticipate->where('participate_id', $item->participate_id)->first();
                if(count($val) == 0){ //Add New
                    if( Request::input('participate')[ $item->participate_id ] != "" ){
                        $projectparticipate = new ProjectParticipate;
                        $projectparticipate->project_readiness_id = $id;
                        $projectparticipate->project_id = $project->project_id;
                        $projectparticipate->projectdate = $projectdate;
                        $projectparticipate->department_id = $auth->department_id;
                        $projectparticipate->year_budget = $setting->setting_year;
                        $projectparticipate->participate_id = $item->participate_id;
                        $projectparticipate->participate_num = Request::input('participate')[ $item->participate_id ];
                        $projectparticipate->project_type = 1;
                        $projectparticipate->save();
                    }
                }else{
                    //update
                    ProjectParticipate::where('project_readiness_id',$id)
                                ->where('project_type',1)
                                ->where('participate_id',$item->participate_id)
                                ->update([ 
                                    'participate_num' => Request::input('participate')[ $item->participate_id ], 
                                    'projectdate' => $projectdate,
                                ]);
                }
            }
        }

        $allparticipategroup = ParticipateGroup::where('project_readiness_id', $id)->get();
        if( count( Request::input('participategroup_id') ) > 0 ){
            foreach( Request::input('participategroup_id') as $key => $item ){
                if(count( @$allparticipategroup[$key]) > 0){
                    ParticipateGroup::where('project_readiness_id',$id)
                                        ->where('participategroup_id', $allparticipategroup[$key]->participategroup_id)
                                        ->update([ 
                                            'register_id' => Request::input('participategroup_id')[$key], 
                                            'projectdate' => $projectdate,
                                            'trainning_status_id' => Request::input('status')[$key],
                                        ]);
            
                }else{
                    if( Request::input('participategroup_id')[$key] != "" ){  
                        $new = new ParticipateGroup;
                        $new->project_readiness_id = $id;
                        $new->register_id = Request::input('participategroup_id')[$key];
                        $new->project_id = $project->project_id;
                        $new->projectdate = $projectdate;
                        $new->year_budget = $setting->setting_year;
                        $new->department_id = $auth->department_id;
                        $new->trainning_status_id = Request::input('status')[$key];
                        $new->project_type = 1;
                        $new->save();
                    }
                }
            }
        }
      
        $alltrainer = Trainer::where('project_readiness_id', $id)->get();
        if( count( Request::input('trainer') ) > 0 ){
            foreach( Request::input('trainer') as $key => $item ){
                if(count( @$alltrainer[$key]) > 0){
                    Trainer::where('project_readiness_id',$id)
                                        ->where('trainer_id', $alltrainer[$key]->trainer_id)
                                        ->update([ 
                                            'trainer_name' => Request::input('trainer')[$key], 
                                            'trainer_position' => Request::input('trainerposition')[$key], 
                                            'company' => Request::input('trainercompany')[$key], 
                                            'course' => Request::input('course')[$key], 
                                        ]);
            
                }else{
                    if( Request::input('trainer')[$key] != "" ){      
                        $trainer = Request::input('trainer')[$key]; 
                        $trainerposition = Request::input('trainerposition')[$key]; 
                        $trainercompany = Request::input('trainercompany')[$key]; 
                        $course = Request::input('course')[$key]; 
                        $new = new Trainer;
                        $new->project_readiness_id = $id;
                        $new->trainer_name = $trainer;
                        $new->trainer_position = $trainerposition;
                        $new->company = $trainercompany;
                        $new->course = $course;
                        $new->project_type = 1;
                        $new->save();
                    }
                }
            }
        }

        $allofficer = ProjectReadinessOfficer::where('project_readiness_id', $id)->get();
        if( count( Request::input('authority') ) > 0 ){
            foreach( Request::input('authority') as $key => $item ){
                if(count( @$allofficer[$key]) > 0){
                    ProjectReadinessOfficer::where('project_readiness_id',$id)
                                        ->where('project_readiness_officer_id', $allofficer[$key]->project_readiness_officer_id)
                                        ->update([ 
                                            'officer_name' => Request::input('authority')[$key], 
                                            'officer_position' => Request::input('authority_position')[$key], 
                                            'officer_company' => Request::input('authority_company')[$key], 
                                        ]);
            
                }else{
                    if(  Request::input('authority')[$key] != ""){
                        $authority = Request::input('authority')[$key]; 
                        $authorityposition = Request::input('authority_position')[$key]; 
                        $authoritycompany = Request::input('authority_company')[$key]; 
                        $new = new ProjectReadinessOfficer;
                        $new->project_readiness_id = $id;
                        $new->officer_name = $authority;
                        $new->officer_position = $authorityposition;
                        $new->officer_company = $authoritycompany;
                        $new->project_type = 1;
                        $new->save();
                    }
                }
            }
        }

        $allcompany = Company::where('project_readiness_id', $id)->get();
        if( count( Request::input('company') ) > 0 ){
            foreach( Request::input('company') as $key => $item ){
                if(count( @$allcompany[$key]) > 0){
                    Company::where('project_readiness_id',$id)
                            ->where('company_id', $allcompany[$key]->company_id)
                            ->update([ 
                                'company_name' => Request::input('company')[$key], 
                            ]);
                }else{
                    if(  Request::input('company')[$key] != ""){
                        $company = Request::input('company')[$key]; 
                        echo $company . " <br>";
                        $new = new Company;
                        $new->project_readiness_id = $id;
                        $new->company_name = $company;
                        $new->project_type = 1;
                        $new->save();
                    }
                }

            }
        }
        
        ProjectReadiness::where('project_readiness_id',$id)
                        ->where('project_type',1)
                        ->update([ 
                            'project_readiness_name' => Request::input('name'), 
                            'project_readiness_desc' => Request::input('detail'),
                            'projectdate' => $projectdate,
                            'problemdesc' => Request::input('problem'),
                            'section_id' => Request::input('section'),
                            'recommenddesc' => Request::input('suggestion')
                            ]);
        $new = new LogFile;
        $new->loglist_id = 33;
        $new->user_id = $auth->user_id;
        $new->save();                          

        return redirect('readiness/project/department/register')->withSuccess("บันทึกข้อมูลโครงการสำเร็จ");
    }

    public function SectionList($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readinesssection = ReadinessSection::where('project_readiness_id',$id)->get();
        $projectreadiness = ProjectReadiness::where('project_readiness_id',$id)->first();
       
        return view('readiness.project.department.sectionlist')->withProject($project)
                                ->withProjectreadiness($projectreadiness)
                                ->withReadinesssection($readinesssection);
    }

    public function ApproveToggle(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $_status =0 ;
        if(Request::input('status') == 'true' ){
            $_status = 1 ;
        }
        // echo $_status;
        ReadinessSection::where('project_readiness_id',Request::input('readiness_id'))
            ->where('department_id',Request::input('department'))
            ->where('section_id',Request::input('section'))
             ->update([ 
                 'status' => $_status , 
            ]);
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
