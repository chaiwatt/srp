<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\ProjectFollowup;
use App\Model\FollowupSection;
use App\Model\FollowupInterview;
use App\Model\Interviewee;
use App\Model\Interviewer;
use App\Model\Province;
use App\Model\Transfer;
use App\Model\FollowupRegister;
use App\Model\Register;
use App\Model\Generate;
use App\Model\Satisfaction;
use App\Model\IntervieweeGroup;
use App\Model\ProjectFollowupDocument;
use App\Model\LogFile;

class FollowupController extends Controller
{

    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)->get();

        return view('followup.index')->withProject($project)
                                ->withProjectfollowup($projectfollowup);
    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();   
        $province = Province::get();    
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
  
        return view('followup.create')->withProject($project)->withProvince($province);
    }


    public function CreateSave(){

        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $date = explode("/", Request::input('startdate'));
        $date_start = ($date[2]-543)."-".$date[1]."-".$date[0];
        $date = explode("/", Request::input('enddate'));
        $date_end = ($date[2]-543)."-".$date[1]."-".$date[0];

        $new = new ProjectFollowup;
        $new->project_id = $project->project_id;
        $new->year_budget = $setting->setting_year;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 3;
        $new->start_date = $date_start;
        $new->end_date = $date_end;
        $new->project_followup_name = Request::input('name');
        $new->project_budget = Request::input('budget');
        $new->details = Request::input('description');
        $new->save();

        $currentproject = ProjectFollowup::orderBy('project_followup_id', 'DESC')->first();
        $selectedsection = Request::input('section');  

        foreach ($selectedsection as $value){
                $section = Section::where('section_id', $value)->first();
                $new = new FollowupSection;
                $new->project_followup_id = $currentproject->project_followup_id;
                $new->project_id = $project->project_id;
                $new->year_budget = $setting->setting_year;
                $new->department_id = $auth->department_id;
                $new->section_id = $section->section_id;
                $new->map_code = $section->map_code;
                $new->save();
        }

        $new = new LogFile;
        $new->loglist_id = 17;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('followup')->withSuccess("เพิ่มโครงการติดตามความก้าวหน้าสำเร็จ");
        
    }
    
    public function Delete($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $setting = SettingYear::where('setting_status' , 1)->first();
        return ($id);
    }

    public function Manage($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $mapcode_arr = array();
        $auth = Auth::user();       
        $province = Province::get();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();

        $projectfollowupdocument = ProjectFollowupDocument::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->get();

        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
        $intervieweegroup = IntervieweeGroup::get();
       
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

        $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();   
        $teacher  = FollowupInterview::where('project_followup_id', $id)
                                    ->orderBy('interviewee_section')
                                    ->get();

        $manager  = FollowupInterview::where('project_followup_id', $id)
                                ->where('interviewee_type',2)
                                ->get();                        
        $officer = Interviewer::where('project_followup_id', $id)->get();

        $r1 = FollowupSection::where('project_followup_id',$id)
            ->pluck('section_id')->toArray();

        $r2 = Generate::whereIn('section_id',$r1)
                                ->where('generate_category',1)
                                ->where('generate_status',1)
                                ->pluck('register_id')->toArray();

        $employ = Register::whereIn('register_id',$r2)->orderBy('section_id')->get();
        $satisfaction = Satisfaction::get();
        $followupregister = FollowupRegister::where('project_followup_id', $id)->get();

        return view('followup.manage')->withProject($project)
                                ->withProvince($province)
                                ->withFollowupsection($followupsection)
                                ->withSelectedprovince($selectedprovince)
                                ->withOfficer($officer)
                                ->withEmploy($employ)
                                ->withIntervieweegroup($intervieweegroup)
                                ->withTeacher($teacher)
                                ->withProjectfollowupdocument($projectfollowupdocument)
                                ->withManager($manager)
                                ->withSatisfaction($satisfaction)
                                ->withFollowupregister($followupregister)
                                ->withProjectfollowup($projectfollowup);
    }

    public function ManageSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $projectfollowup_id =  Request::input('id'); 
        $selectedprovince = Request::input('province');  
        $selectedsection = Request::input('section');  

        $workon =  Request::input('workon'); 

        if(count(Request::input('sastify', [])) > 0){
            foreach( Request::input('sastify', []) as $regid => $item ){
                if($item  != 0 ){                  
                    $exist = FollowupRegister::where('register_id',$regid)->first();
                    if(!empty($exist)){
                        FollowupRegister::where('project_followup_id',$projectfollowup_id)
                        ->where('register_id',$regid)
                        ->update([ 
                            'satisfaction_id' =>  $item, 
                            'workon' =>  Request::input('workon')[$regid], 
                            'problem' => Request::input('problem')[$regid],
                            ]);
                    }else{                       
                        $new = new FollowupRegister;
                        $new->project_followup_id = $projectfollowup_id;
                        $new->register_id = $regid;  
                        $new->satisfaction_id = $item; 
                        $new->workon = Request::input('workon')[$regid]; 
                        $new->problem = Request::input('problem')[$regid]; 
                        $new->save();
                    }
                }else{
                    if(!empty($exist)){
                        FollowupRegister::where('project_followup_id',$projectfollowup_id)
                        ->where('register_id',$regid)->delete();
                    }
                }
            }
        }


    	$transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 3)
                        ->where('transfer_status' , 1)
                        ->sum('transfer_price');

        if( $transfer == 0 ){
            return redirect('followup')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่มีเงินรับโอน");
        }                

        $allfollowupexpense = ProjectFollowup::where('project_id' , $project->project_id)->sum('payment');
        $followupexpense = ProjectFollowup::where('project_followup_id' , $projectfollowup_id)->first();

        $diff = Request::input('actualpayment') - $followupexpense->payment ;
        if( ($allfollowupexpense +  $diff ) > $transfer ){
            return redirect('followup')->withError("ไม่สามารถบันทึกข้อมูลได้ เนื่องจากเงินรับโอนไม่เพียงพอกับเงินเบิกจ่ายจริง (คงเหลือ " . number_format( ($allfollowupexpense - $transfer) , 2 ) . " บาท เกิน " . number_format( ($diff) , 2 ) . " บาท )" );
        }
      
        $date = explode("/", Request::input('startdate') );
        $datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
       
        $date = explode("/", Request::input('enddate') );
        $dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
       
        ProjectFollowup::where('project_followup_id',$projectfollowup_id)
                    ->update([ 
                        'payment' =>  Request::input('actualpayment'), 
                        'project_followup_name' => Request::input('name'),
                        'start_date' => $datestart,
                        'end_date' => $dateend,
                        'details' => Request::input('description'),
                        ]);

        $followupinterview = FollowupInterview::where('project_followup_id', $projectfollowup_id)->get();
        if( count( Request::input('interviewee') ) > 0 ){
            
            foreach( Request::input('interviewee') as $key => $item ){
                echo Request::input('intervieweesection')[$key] . "<br>";
                if(count( @$followupinterview[$key]) > 0){
                    FollowupInterview::where('project_followup_id',$projectfollowup_id)
                                        ->where('followup_interview_id', $followupinterview[$key]->followup_interview_id)
                                        ->update([ 
                                            'interviewee_name' => Request::input('interviewee')[$key], 
                                            'interviewee_group_id' => Request::input('intervieweeposition')[$key], 
                                            'interviewee_type' => Request::input('intervieweeposition')[$key],
                                            'interviewee_section' => Request::input('intervieweesection')[$key],
                                            'interviewcontent' => Request::input('interviewcontent')[$key],
                                        ]);
            
                }else{
                    if( Request::input('interviewee')[$key] != "" ){  
                        $new = new FollowupInterview;
                        $new->project_followup_id = $projectfollowup_id;
                        $new->project_id = $project->project_id;
                        $new->year_budget = $project->year_budget;
                        $new->interviewee_type = Request::input('intervieweeposition')[$key];
                        $new->interviewee_name = Request::input('interviewee')[$key];  
                        $new->interviewee_group_id = Request::input('intervieweeposition')[$key]; 
                        $new->interviewee_section = Request::input('intervieweesection')[$key]; 
                        $new->interviewcontent = Request::input('interviewcontent')[$key]; 
                        $new->save();
                    }
                }
            }
        }

        $allofficer = InterViewer::where('project_followup_id', $projectfollowup_id)->get();
        if( count( Request::input('officer') ) > 0 ){
            foreach( Request::input('officer') as $key => $item ){
                if(count( @$allofficer[$key]) > 0){
                    InterViewer::where('project_followup_id',$projectfollowup_id)
                                        ->where('interviewer_id', $allofficer[$key]->interviewer_id)
                                        ->update([ 
                                            'name' => Request::input('officer')[$key], 
                                            'position' => Request::input('officer_position')[$key], 
                                            'company' => Request::input('officer_company')[$key],
                                        ]);
            
                }else{
                    if( Request::input('officer')[$key] != "" ){  
                        $new = new InterViewer;
                        $new->project_followup_id = $projectfollowup_id;
                        $new->project_id = $project->project_id;
                        $new->year_budget = $project->year_budget;
                        $new->name = Request::input('officer')[$key];  
                        $new->position = Request::input('officer_position')[$key]; 
                        $new->company = Request::input('officer_company')[$key]; 
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
                        $file->move('storage/uploads/projctfollowup/document' , $new_name);
                        $new = new ProjectFollowupDocument;
                        $new->project_id = $project->project_id;
                        $new->project_followup_id = $projectfollowup_id;
                        $new->document_name = $file->getClientOriginalName();
                        $new->document_file = "storage/uploads/projctfollowup/document/".$new_name;
                        $new->save();
                    }
                }
            }
        }

    
     return redirect('followup')->withSuccess("แก้ไขสำเร็จ");
    }

    public function DeleteFile($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $document = ProjectFollowupDocument::where('project_followup_document_id' , $id)->first();
        if( count($document) == 0 ){
            return redirect()->back();
        }

        @unlink( $document->document_file );

        ProjectFollowupDocument::where('project_followup_document_id' , $id)->delete();

        return redirect()->back()->withSuccess("ลบไฟล์เอกสารเรียบร้อยแล้ว");
    }

    public function TestCommand(){
       FollowupSection::where('project_followup_id',2)->where('project_id',24)->whereNotIn('section_id',[20,123])->delete();

        return "";
    }

    public function EditReg($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        return "ok";
    }
    public function Edit($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $mapcode_arr = array();
        $auth = Auth::user();       
        $province = Province::get();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();

        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
       
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

        $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();    

        return view('followup.edit')->withProject($project)
                                ->withProvince($province)
                                ->withFollowupsection($followupsection)
                                ->withSelectedprovince($selectedprovince)
                                ->withProjectfollowup($projectfollowup);
    }

    public function EditSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
       

        $projectfollowup_id =  Request::input('id'); 
        $selectedprovince = Request::input('province');  
        $selectedsection = Request::input('section');  

        FollowupSection::where('project_followup_id',$projectfollowup_id)
                        ->where('project_id',$project->project_id)
                        ->whereNotIn('section_id',$selectedsection)
                        ->delete();

        foreach ($selectedsection as $value){
            $followupsection = FollowupSection::where('project_followup_id',$projectfollowup_id)
                                        ->where('section_id', $value)
                                        ->first();
            $section = Section::where('section_id', $value)->first();
            if(count($followupsection) ==0 ){
                $new = new FollowupSection;
                $new->project_followup_id = $projectfollowup_id;
                $new->project_id = $project->project_id;
                $new->year_budget = $setting->setting_year;
                $new->department_id = $auth->department_id;
                $new->section_id = $section->section_id;
                $new->map_code = $section->map_code;
                $new->save();
            } 

            $date = explode("/", Request::input('startdate') );
            $datestart = ($date[2]-543)."-".$date[1]."-".$date[0];
           
            $date = explode("/", Request::input('enddate') );
            $dateend = ($date[2]-543)."-".$date[1]."-".$date[0];
           
            ProjectFollowup::where('project_followup_id',Request::input('id'))
                        ->update([ 
                            'project_followup_name' => Request::input('name'),
                            'start_date' => $datestart,
                            'end_date' => $dateend,
                            'details' => Request::input('description'),
                        ]);

        }
        $new = new LogFile;
        $new->loglist_id = 18;
        $new->user_id = $auth->user_id;
        $new->save();

     return redirect('followup')->withSuccess("แก้ไขสำเร็จ");
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

