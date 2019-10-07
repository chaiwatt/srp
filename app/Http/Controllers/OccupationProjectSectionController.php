<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use DB;
use Request;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Position;
use App\Model\Department;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\ReadinessSection;
use App\Model\Trainer;
use App\Model\Company;
use App\Model\Participate;
use App\Model\TrainingStatus;
use App\Model\ProjectReadinessOfficer;
use App\Model\ReadinessExpense;
use App\Model\ParticipateGroup;
use App\Model\Group;
use App\Model\Prefix;
use App\Model\ProjectParticipate;
use App\Model\Register;
use App\Model\Transfer;
use App\Model\ReadinessSectionDocument;
use App\Model\LogFile;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;

class OccupationProjectSectionController extends Controller
{
    
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                ->where('department_id',$auth->department_id)
                                ->where('project_type',2)
                                ->get();
        
        $readinesssection = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('department_id',$auth->department_id)
                                ->where('section_id',$auth->section_id)
                                ->where('project_type',2)
                                ->get();
       

        return view('occupation.project.section.index')->withProject($project)
                                                    ->withReadinesssection($readinesssection)
                                                    ->withReadiness($readiness);

    }

    public function List(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('department_id',$auth->department_id)
                                ->where('section_id',$auth->section_id)
                                ->where('project_type',2)
                                ->where('status',1)
                                ->get();
       
        $readinesssection = ReadinessSection::where('project_id',$project->project_id)
        ->where('section_id',$auth->section_id)
        ->where('project_type',2)
        ->get();

        return view('occupation.project.section.list')->withProject($project)
                                                    ->withAuth($auth)
                                                    ->withReadinesssection($readinesssection)
                                                    ->withReadiness($readiness);


    }

    public function ToggleSection(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $readinesssection = ReadinessSection::where('project_readiness_id',Request::input('readiness_id'))
                            ->where('department_id',  Request::input('department'))
                            ->where('section_id',Request::input('section'))
                            ->first();
        if(!empty($readinesssection)){
            if(Request::input('status') == 'false' ){
                ReadinessSection::where('project_readiness_id',Request::input('readiness_id'))->delete();
            }
        
        }else{

            $budget = ProjectReadiness::where('project_readiness_id',Request::input('readiness_id'))->first()->budget;

            $new = new ReadinessSection;
            $new->project_readiness_id = Request::input('readiness_id');
            $new->department_id = Request::input('department');
            $new->project_type = 2;
            $new->budget = 0;
            $new->section_id = Request::input('section');
            $new->project_id = Request::input('project_id');
            $new->save();
        }
    }


    public function Manage($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
  
        $auth = Auth::user();   
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $trainer = Trainer::where('readiness_section_id' ,$id)->get();
        $officer = ProjectReadinessOfficer::where('readiness_section_id' ,$id)->get();
        $company = Company::where('readiness_section_id' ,$id)->get();
        $reparticipate = ProjectParticipate::where('readiness_section_id' ,$id)->get();
        $participate = Participate::where('department_id', $auth->department_id)->get();
        $status = TrainingStatus::get();

        $department = Department::where('department_id',$auth->department_id)->first();

        $readiness = ReadinessSection::where('readiness_section_id' ,$id)
                                    ->where('project_type',2)
                                    ->first();

        $section = Section::where('department_id',$auth->department_id)->get();
        $readinessexpense = ReadinessExpense::where('readiness_section_id' ,$id)
                                    ->where('project_type',2)
                                    ->first();
        $participategroup = ParticipateGroup::where('readiness_section_id' ,$id)
                                    ->where('project_type',2)
                                    ->where('department_id' , $auth->department_id)
                                    ->get(); 

        $readinesssectiondocument = ReadinessSectionDocument::where('readiness_section_id' ,$id)
                                    ->get(); 

        $register = Register::get();                           
        $group = Group::where('group_status' , 1)->get();
        $prefix = Prefix::get();

        $exp = ReadinessExpense::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id' , $auth->department_id)
                                    ->sum('cost');

        $transfer = Transfer::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 4)
                                    ->where('transfer_status' , 1)
                                    ->sum('transfer_price');   

        $allreadinessexpense  =   $transfer - $exp ;                                                                       

        return view('occupation.project.section.manage')->withReadiness($readiness)
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
                                                        ->withReadinesssectiondocument($readinesssectiondocument)
                                                        ->withGroup($group)
                                                        ->withPrefix($prefix);
    }

    public function Register(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();   
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        if(strlen( Request::input('personid') ) != 13){ 
            return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากรูปแบบไม่ถูกต้อง";
        }
        else{
            for($i=0, $sum=0; $i<12;$i++){
                $sum += (int)( Request::input('personid')[$i] ) * (13-$i);
            }
            
            if((11-($sum%11))%10 == (int)(Request::input('personid')[12] ) ){
                $q = Register::where('person_id' , Request::input('personid'))->where('register_status' , 1)->first();
                if( !empty($q) ){
                    return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากมีอยู่ในระบบแล้ว";
                }
                else{
                    $new = new Register;
                    $new->project_id = $project->project_id;
                    $new->year_budget = $project->year_budget;
                    $new->department_id = $auth->department_id;
                    $new->section_id = Request::input('section');
                    $new->person_id = Request::input('personid');
                    $new->name =Request::input('name');
                    $new->lastname = Request::input('lastname');
                    $new->prefix_id = Request::input('prefix');
                    $new->group_id = Request::input('group');
                    $new->save();
                    return "เพิ่มรายชื่อสำเร็จ";
                }
            }
            else{
                return "ไม่สามารถใช้รหัสบัตรประชาชนนี้ได้ เนื่องจากรูปแบบไม่ถูกต้อง";
            }
        }
    }

    public function ManageSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $id = Request::input('id');
        $auth = Auth::user();  

        $date = explode("/", Request::input('projectdate'));
        $projectdate = ($date[2]-543)."-".$date[1]."-".$date[0];

        $readiness_section_id =  Request::input('readiness_section_id');
        $project_readiness_id =  Request::input('id');

    	if( Request::input('actualexpense') == 0 ){
    		return redirect('occupation/project/section/list')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่ได้กรอกเบิกจ่ายจริง");
        }
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    	$transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 4)
                        ->where('transfer_status' , 1)
                        ->sum('transfer_price');

    	if( $transfer == 0 ){
    		return redirect('occupation/project/section/list')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่มีเงินรับโอน");
        }
        
        $budget = ReadinessSection::where('project_id' , $project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->sum('budget');

        $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , 0)
                    ->where('budget_id' , 4)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 1)
                    ->sum('transfer_price');

        $refund = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('refund');             

        $payment = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('budget'); 

        $allocation = ProjectReadiness::where('project_id',$project->project_id)
                    ->where('project_readiness_id',$project_readiness_id)
                    ->first()
                    ->budget;
                    
        $remmain = $transfer-$payment+$refund;

        if( Request::input('actualexpense') > $allocation){
            return redirect('occupation/project/section/list')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากเงินเบิกจ่ายมากกว่าเงินจัดสรร " );
        }

        if( Request::input('actualexpense') > $remmain){
            return redirect('occupation/project/section/list')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากเงินรับโอนไม่เพียงพอกับเงินเบิกจ่ายจริง (คงเหลือ " . number_format( ($remmain) , 2 ) . " บาท)" );
        }

        $date = explode("/", Request::input('projectdate'));
        $_helddate = ($date[2]-543)."-".$date[1]."-".$date[0];

        if(Request::input('actualexpense') == Request::input('budget') ){
            ReadinessSection::where('readiness_section_id',$readiness_section_id)
                            ->update([ 
                                'note' => Request::input('detail'), 
                                'actualexpense' => Request::input('actualexpense'),
                                'helddate' => $_helddate,
                                'problemdesc' => Request::input('problem'),
                                'recommenddesc' => Request::input('suggestion'),
                                'completed' => 1,
                                'refund_status' => 1,
                    ]);
        }else{
            ReadinessSection::where('readiness_section_id',$readiness_section_id)
                            ->update([ 
                                'note' => Request::input('detail'), 
                                'actualexpense' => Request::input('actualexpense'),
                                'helddate' => $_helddate,
                                'problemdesc' => Request::input('problem'),
                                'recommenddesc' => Request::input('suggestion'),
                                'completed' => 1,
                    ]);
        }



        $allrojectparticipate =  ProjectParticipate::where('project_readiness_id', $id)
                                                ->where('readiness_section_id',$readiness_section_id)
                                                ->where('project_type',2)
                                                ->get();
        $participate = Participate::where('department_id', $auth->department_id)
                                ->get();      
        
        if( $participate->count() ){
            foreach( $participate as $key => $item ){
                $val =  $allrojectparticipate->where('participate_id', $item->participate_id)->first();
                if(count($val) == 0){ //Add New
                    if( Request::input('participate')[ $item->participate_id ] != "" ){
                        $projectparticipate = new ProjectParticipate;
                        $projectparticipate->project_readiness_id = $project_readiness_id;
                        $projectparticipate->readiness_section_id = $readiness_section_id; 
                        $projectparticipate->project_id = $project->project_id;
                        $projectparticipate->projectdate = $projectdate;
                        $projectparticipate->department_id = $auth->department_id;
                        $projectparticipate->year_budget = $setting->setting_year;
                        $projectparticipate->participate_id = $item->participate_id;
                        $projectparticipate->participate_num = Request::input('participate')[ $item->participate_id ];
                        $projectparticipate->project_type = 2;
                        $projectparticipate->save();
                    }
                }else{
                    //update
                    ProjectParticipate::where('project_readiness_id',$project_readiness_id)
                            ->where('readiness_section_id',$readiness_section_id)
                            ->where('project_type',2)
                            ->where('participate_id',$item->participate_id)
                            ->update([ 
                                'participate_num' => Request::input('participate')[ $item->participate_id ], 
                                'projectdate' => $projectdate,
                            ]);
                }
            }
        }

        $allparticipategroup = ParticipateGroup::where('readiness_section_id', Request::input('readiness_section_id'))->get();

        if( count( Request::input('participategroup_id') ) > 0 ){
            foreach( Request::input('participategroup_id') as $key => $item ){
                if(count( @$allparticipategroup[$key]) > 0){
                    //  return $readiness_section_id;
                    ParticipateGroup::where('project_readiness_id',$project_readiness_id)
                                        ->where('readiness_section_id',$readiness_section_id)
                                        ->where('participategroup_id', $allparticipategroup[$key]->participategroup_id)
                                        ->update([ 
                                            'register_id' => Request::input('participategroup_id')[$key], 
                                            'projectdate' => $projectdate,
                                            'trainning_status_id' => Request::input('status')[$key],
                                        ]);
            
                }else{
                    if( Request::input('participategroup_id')[$key] != "" ){  
                        $new = new ParticipateGroup;
                        $new->project_readiness_id = $project_readiness_id;
                        $new->register_id = Request::input('participategroup_id')[$key];
                        $new->project_id = $project->project_id;
                        $new->readiness_section_id = $readiness_section_id; 
                        $new->projectdate = $projectdate;
                        $new->year_budget = $setting->setting_year;
                        $new->department_id = $auth->department_id;
                        $new->trainning_status_id = Request::input('status')[$key];
                        $new->project_type = 2;
                        $new->save();
                    }
                }
            }
        }

        $alltrainer = Trainer::where('project_readiness_id', $project_readiness_id)
                    ->where('readiness_section_id',$readiness_section_id)
                    ->get();
        if( count( Request::input('trainer') ) > 0 ){
            foreach( Request::input('trainer') as $key => $item ){
                if(count( @$alltrainer[$key]) > 0){
                    Trainer::where('project_readiness_id',$project_readiness_id)
                                        ->where('trainer_id', $alltrainer[$key]->trainer_id)
                                        ->where('readiness_section_id',$readiness_section_id)
                                        ->update([ 
                                            'trainer_name' => Request::input('trainer')[$key], 
                                            'trainer_position' => Request::input('trainerposition')[$key], 
                                            'company' => Request::input('trainercompany')[$key], 
                                            'course' => Request::input('course')[$key], 
                                            'notice' => Request::input('notice')[$key], 
                                        ]);
            
                }else{
                    if( Request::input('trainer')[$key] != "" ){      
                        $new = new Trainer;
                        $new->project_readiness_id = $project_readiness_id;
                        $new->readiness_section_id = $readiness_section_id; 
                        $new->trainer_name = Request::input('trainer')[$key];
                        $new->trainer_position = Request::input('trainerposition')[$key]; 
                        $new->company = Request::input('trainercompany')[$key]; 
                        $new->course = Request::input('course')[$key];
                        $new->notice = Request::input('notice')[$key];
                        $new->project_type = 2;
                        $new->save();
                    }
                }
            }
        }

        $allofficer = ProjectReadinessOfficer::where('project_readiness_id', $project_readiness_id)
                            ->where('readiness_section_id',$readiness_section_id)
                            ->get();
        if( count( Request::input('authority') ) > 0 ){
            foreach( Request::input('authority') as $key => $item ){
                if(count( @$allofficer[$key]) > 0){
                    ProjectReadinessOfficer::where('project_readiness_id',$project_readiness_id)
                                        ->where('readiness_section_id',$readiness_section_id)
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
                        $new->project_readiness_id = $project_readiness_id;
                        $new->readiness_section_id = $readiness_section_id; 
                        $new->officer_name = $authority;
                        $new->officer_position = $authorityposition;
                        $new->officer_company = $authoritycompany;
                        $new->project_type = 2;
                        $new->save();
                    }
                }
            }
        }

        $allcompany = Company::where('project_readiness_id', $project_readiness_id)
                            ->where('readiness_section_id',$readiness_section_id)
                            ->get();
        if( count( Request::input('company') ) > 0 ){
            foreach( Request::input('company') as $key => $item ){
                if(count( @$allcompany[$key]) > 0){
                    Company::where('project_readiness_id',$project_readiness_id)
                            ->where('company_id', $allcompany[$key]->company_id)
                            ->where('readiness_section_id',$readiness_section_id)
                            ->update([ 
                                'company_name' => Request::input('company')[$key], 
                            ]);
                }else{
                    if(  Request::input('company')[$key] != ""){
                        $company = Request::input('company')[$key]; 
                        echo $company . " <br>";
                        $new = new Company;
                        $new->project_readiness_id = $project_readiness_id;
                        $new->readiness_section_id = $readiness_section_id; 
                        $new->company_name = $company;
                        $new->project_type = 2;
                        $new->save();
                    }
                }

            }
        }
        
        $extension_doc = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png','doc','docx','xls','xlsx','pdf','txt','csv','zip','rar');
        if(Request::file('document')){   
            $files = request::file('document');
            foreach($files as $file){
                if( $file != null ){
                    if( in_array($file->getClientOriginalExtension(), $extension_doc) ){
                        $new_name = str_random(10).".".$file->getClientOriginalExtension();
                        $file->move('storage/uploads/readiness/document' , $new_name);
                        $new = new ReadinessSectionDocument;
                        $new->project_id = $project->project_id;
                        $new->readiness_section_id = $readiness_section_id;
                        $new->document_name = $file->getClientOriginalName();
                        $new->document_file = "storage/uploads/readiness/document/".$new_name;
                        $new->save();
                    }
                }
            }
        }
        return redirect('occupation/project/section/list')->withSuccess("บันทึกข้อมูลโครงการสำเร็จ");
    }

    public function DeleteFile($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $document = ReadinessSectionDocument::where('readiness_section_document_id' , $id)->first();
        if( count($document) == 0 ){
            return redirect()->back();
        }

        @unlink( $document->document_file );

        ReadinessSectionDocument::where('readiness_section_document_id' , $id)->delete();

        return redirect('occupation/project/section/list' )->withSuccess("บันทึกข้อมูลโครงการสำเร็จ"); redirect()->back()->withSuccess("ลบไฟล์เอกสารเรียบร้อยแล้ว");
    }

    public function Refund($id){
        if( $this->authsection() ){
            return redirect('logout');
        }        
        $auth = Auth::user();  

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $budget = ReadinessSection::where('readiness_section_id',$id)
                    ->first()
                    ->budget;

        $actualexpense = ReadinessSection::where('readiness_section_id',$id)
                    ->first()
                    ->actualexpense;            
                 

        ReadinessSection::where('readiness_section_id',$id)
                    ->update([ 
                        'refund' => $budget - $actualexpense, 
            ]);

            
            $section = Section::where('section_id', $auth->section_id)->first();
            $users = Users::where('department_id' , $auth->department_id)->where('permission',2)->get();
            
            if( $users->count() > 0 ){
                foreach( $users as $user ){
                    $new = new NotifyMessage;
                    $new->system_id = 1;
                    $new->project_id = $project->project_id;
                    $new->message_key = 1;
                    $new->message_title = "คืนเงินฝึกอบรม";
                    $new->message_content = "คืนเงินฝึกอบรม ".$section->section_name ;
                    $new->message_date = date('Y-m-d H:i:s');
                    $new->user_id = $user->user_id;
                    $new->save();
    
                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                    if(!Empty($linenotify)){
                        if ($linenotify->linetoken != ""){
                            $message = "คืนเงินฝึกอบรม ". $section->section_name  ." ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                            $linenotify->notifyme($message);
                        }
                    }
                }
            }

        $new = new LogFile;
        $new->loglist_id = 1;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('occupation/project/section/refundlist')->withSuccess("คืนเงินสำเร็จ");

    }

    public function RefundList(){
        if( $this->authsection() ){
            return redirect('logout');
        }         

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                ->where('department_id',$auth->department_id)
                                ->where('section_id',$auth->section_id)
                                ->where('project_type',2)
                                ->get();
        
        $readinesssection = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('department_id',$auth->department_id)
                                ->where('section_id',$auth->section_id)
                                ->where('completed',1)
                                ->where('project_type',2)
                                ->get();

       
        return view('occupation.project.section.refund')->withProject($project)
                                                    ->withReadinesssection($readinesssection)
                                                    ->withReadiness($readiness);

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

