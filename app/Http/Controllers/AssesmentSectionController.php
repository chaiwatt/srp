<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use Excel;

use App\Model\PersonalAssessment;
use App\Model\ProjectAssesment;
use App\Model\Project;
use App\Model\SettingYear;
use App\Model\Score;
use App\Model\FollowerStatus;
use App\Model\NeedSupport;
use App\Model\FamilyRelation;
use App\Model\EnoughIncome;
use App\Model\Occupation;
use App\Model\Register;
use App\Model\Generate;
use App\Model\ParticipateGroup;
use App\Model\ReadinessSection;
use App\Model\LogFile;

class AssesmentSectionController extends Controller
{
   public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assesment = ProjectAssesment::where('project_id',$project->project_id)
                                    ->where('department_id',$auth->department_id)
                                    ->where('section_id',$auth->section_id)
                                    ->get();
        $personalassesment = PersonalAssessment::where('project_id',$project->project_id)
                                    ->where('department_id',$auth->department_id)
                                    ->where('section_id',$auth->section_id)
                                    ->get();

        return view('assesment.section.index')
        ->withAssesment($assesment)
        ->withProject($project)
        ->withPersonalassesment($personalassesment);

   }

   public function Create(){
    if( $this->authsection() ){
        return redirect('logout');
    }
    $auth = Auth::user();

    $setting = SettingYear::where('setting_status' , 1)->first();
    $project = Project::where('year_budget' , $setting->setting_year)->first();
    return view('assesment.section.create')->withProject($project);
    }

    public function CreateSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $date = explode("/", Request::input('assesmentdate') );
        $datestart = ($date[2]-543)."-".$date[1]."-".$date[0];

		$new = new ProjectAssesment;
		$new->assesment_name = Request::input('assesment');
		$new->assesmentdate = $datestart;
        $new->project_assesment_desc = Request::input('description');
        $new->project_id = $project->project_id;
        $new->year_budget = $setting->setting_year;
        $new->section_id = $auth->section_id;
        $new->department_id = $auth->department_id;
        $new->assesor = Request::input('assesor');   
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 4;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('assesment/section')->withSuccess("บันทึกข้อมูลเรียบร้อยแล้ว");
    }

    public function Edit($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assesment = ProjectAssesment::where('project_assesment_id',$id)->first();

        $register = Generate::where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('generate_status' , 1)
                        ->get();

        $score = Score::get();        
        $followerstatus = FollowerStatus::get();  
        $needsupport = NeedSupport::get();  
        $familyrelation = FamilyRelation::get();  
        $enoughincome = EnoughIncome::get(); 
        $occupation = Occupation::get(); 

        return view('assesment.section.edit')->withProject($project)
                                    ->withFollowerstatus($followerstatus)
                                    ->withScore($score)
                                    ->withNeedsupport($needsupport)
                                    ->withFamilyrelation($familyrelation)
                                    ->withEnoughincome($enoughincome)
                                    ->withOccupation($occupation)
                                    ->withRegister($register)
                                    ->withAssesment($assesment);

    }

    public function AssessmentEdit($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assesment = ProjectAssesment::where('project_assesment_id',$id)->first();

        $register = Generate::where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('generate_status' , 1)
                        ->get();

        $score = Score::get();        


        return view('assesment.section.doassessment')->withProject($project)
                                    ->withScore($score)
                                    ->withRegister($register)
                                    ->withAssesment($assesment);
    }

    public function FollowupEdit($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assesment = ProjectAssesment::where('project_assesment_id',$id)->first();

        $readinesssection = ReadinessSection::where('section_id',$auth->section_id)->get();

        $r0 = array();
        foreach($readinesssection as $item ){
            $_participate = ParticipateGroup::where('readiness_section_id',$item->readiness_section_id)->get();
            foreach($_participate as $_item){
                $r0[] = $_item->register_id;
            }
        }
        $r0_unique = array_unique($r0);

        // $register = Generate::where('department_id' , $auth->department_id)
        //                 ->where('section_id' , $auth->section_id)
        //                 ->where('generate_status' , 1)
        //                 ->get();
        $r1 = array();

        $r1 = Generate::where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('generate_status' , 1)
                        ->pluck('register_id')->toArray();

        $array_register = array_unique(array_merge($r0_unique,$r1));

        // print_r ($array_register);
        $register = Register::whereIn('register_id', $array_register)->get();


        // return $register1->count() ;              
 
        $followerstatus = FollowerStatus::get();  
        $needsupport = NeedSupport::get();  
        $familyrelation = FamilyRelation::get();  
        $enoughincome = EnoughIncome::get(); 
        $occupation = Occupation::get(); 

        return view('assesment.section.dofollowup')->withProject($project)
                                    ->withFollowerstatus($followerstatus)
                                    ->withNeedsupport($needsupport)
                                    ->withFamilyrelation($familyrelation)
                                    ->withEnoughincome($enoughincome)
                                    ->withOccupation($occupation)
                                    ->withRegister($register)
                                    ->withAssesment($assesment);

    }

    public function EditSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $register = Register::where('register_id',Request::input('register'))->first();

        $check= PersonalAssessment::where('project_assesment_id', Request::input('assesment_id'))
                            ->where('register_id',Request::input('register'))
                            ->first();
        if( count($check) != 0 ){
            $errmsg = $register->name . " " . $register->lastname . " ได้รับการประเมินแล้ว";
            return redirect('assesment/section/edit/'.Request::input('assesment_id') )->withError($errmsg);
        }

        $new = new PersonalAssessment;
        $new->project_id = $project->project_id;
        $new->year_budget = $setting->setting_year;
        $new->department_id = $auth->department_id;
        $new->section_id = $auth->section_id;

        $new->project_assesment_id = Request::input('assesment_id');
        $new->register_id = Request::input('register');
		$new->score_id = Request::input('score');
		$new->follower_status_id = Request::input('followerstatus');
        $new->needsupport_id = Request::input('needsupport');
        $new->familyrelation_id = Request::input('familyrelation');
        $new->enoughincome_id = Request::input('enoughincome');
        $new->occupation_id = Request::input('occupation');
        $new->othernote = Request::input('detail');
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 5;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('assesment/section/edit/'.Request::input('assesment_id') )->withSuccess("ประเมินสำเร็จ");
        
    }

    public function FollowupSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
      
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $register = Register::where('register_id',Request::input('register'))->first();
        // return $register ;
        $check= PersonalAssessment::where('project_assesment_id', Request::input('assesment_id'))
                            ->where('register_id',Request::input('register'))
                            ->first();
        if( count($check) != 0 ){
            PersonalAssessment::where('project_assesment_id', Request::input('assesment_id'))
            ->where('register_id',Request::input('register'))
            ->update([ 
                'othernote2' =>  Request::input('detail'), 
                'follower_status_id' => Request::input('followerstatus'),
                'needsupport_id' => Request::input('needsupport'),
                'needsupport_detail' => Request::input('needsupport3'),
                'familyrelation_id' => Request::input('familyrelation'),
                'familyrelation_detail' => Request::input('familyrelation3'),
                'enoughincome_id' => Request::input('enoughincome'),
                'occupation_id' => Request::input('occupation'),
                'occupation_detail' => Request::input('occupation3'),
                'othernote2' => Request::input('detail'),
                ]);

        }else{

            $new = new PersonalAssessment;
            $new->project_id = $project->project_id;
            $new->year_budget = $setting->setting_year;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
    
            $new->project_assesment_id = Request::input('assesment_id');
            $new->register_id = Request::input('register');
            $new->follower_status_id = Request::input('followerstatus');
            $new->needsupport_id = Request::input('needsupport');
            $new->needsupport_detail = Request::input('needsupport3');
            $new->familyrelation_id = Request::input('familyrelation');
            $new->familyrelation_detail = Request::input('familyrelation3');
            $new->enoughincome_id = Request::input('enoughincome');
            $new->occupation_id = Request::input('occupation');
            $new->occupation_detail = Request::input('occupation3');
            $new->othernote2 = Request::input('detail');
            $new->save();
        }



        return redirect('assesment/section/followupedit/'.Request::input('assesment_id') )->withSuccess("บันทึกผลการติดตาม ". $register->name . " " . $register->lastname ." สำเร็จ");
        
    }

    public function FollowupDetail(){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $assessment= PersonalAssessment::where('project_assesment_id', Request::input('assesment_id'))
        ->where('register_id',Request::input('register'))
        ->get();
            return json_encode(array("assessment" => $assessment,"row" => $assessment->count(), 'filter' => Request::input('register') ));    
    }

    public function AssessmentSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $register = Register::where('register_id',Request::input('register'))->first();

        $check= PersonalAssessment::where('project_assesment_id', Request::input('assesment_id'))
                            ->where('register_id',Request::input('register'))
                            ->first();
   
        if( count($check) != 0 ){
            PersonalAssessment::where('project_assesment_id', Request::input('assesment_id'))
            ->where('register_id',Request::input('register'))
            ->update([ 
                'score_id' =>  Request::input('score'), 
                'othernote' => Request::input('detail'),
                ]);

        }else{
            $new = new PersonalAssessment;
            $new->project_id = $project->project_id;
            $new->year_budget = $setting->setting_year;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
            $new->project_assesment_id = Request::input('assesment_id');
            $new->register_id = Request::input('register');
            $new->score_id = Request::input('score');
            $new->othernote = Request::input('detail');
            $new->save();
        }

        return redirect('assesment/section/assessmentedit/'.Request::input('assesment_id') )->withSuccess("บันทึกผลการประเมิน ". $register->name . " " . $register->lastname ." สำเร็จ");
        
    }

    public function EditAssessment($id){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $assesment = ProjectAssesment::where('project_assesment_id',$id)
                                    ->first();

        return view('assesment.section.editassesment')->withAssesment($assesment);
    }

    public function EditAssessmentSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    
        $auth = Auth::user();
        ProjectAssesment::where('project_assesment_id',Request::input('assesment_id'))
                        ->update([ 
                            'assesment_name' =>  Request::input('assesment'), 
                            'project_assesment_desc' => Request::input('description'),
                            'assesor' => Request::input('assesor'),
                            ]);
            return redirect('assesment/section')->withSuccess("แก้ไขสำเร็จ");
    }

    public function View($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $assessee = PersonalAssessment::where('project_assesment_id', $id)
        ->where('section_id',$auth->section_id)
        ->get();
        
        $assessment = ProjectAssesment::where('project_assesment_id', $id)->first();

        return view('assesment.section.view')->withAssessee($assessee)
                ->withProject($project)
                ->withAssessment($assessment);
    }

    public function EditAssessee($id,$assessmentid){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assesment = ProjectAssesment::where('project_assesment_id',$id)->first();

        $assessee = PersonalAssessment::where('project_assesment_id', $assessmentid)
                                    ->where('personal_assessment_id',$id)->first();

        $register = Register::where('register_id',$assessee->register_id)->first();

        $score = Score::get();        
        $followerstatus = FollowerStatus::get();  
        $needsupport = NeedSupport::get();  
        $familyrelation = FamilyRelation::get();  
        $enoughincome = EnoughIncome::get(); 
        $occupation = Occupation::get(); 

        return view('assesment.section.editassee')->withProject($project)
                                ->withFollowerstatus($followerstatus)
                                ->withScore($score)
                                ->withNeedsupport($needsupport)
                                ->withFamilyrelation($familyrelation)
                                ->withEnoughincome($enoughincome)
                                ->withOccupation($occupation)
                                ->withAssessee($assessee)
                                ->withRegister($register)
                                ->withAssesment($assesment);

    }
    public function EditAssesseeSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        PersonalAssessment::where('personal_assessment_id',Request::input('assesment_id'))
                        ->where('register_id',Request::input('register_id'))
                        ->update([ 
                            'score_id' =>  Request::input('score'), 
                            'follower_status_id' => Request::input('followerstatus'),
                            'needsupport_id' => Request::input('needsupport'),
                            'familyrelation_id' => Request::input('familyrelation'),
                            'enoughincome_id' => Request::input('enoughincome'),
                            'occupation_id' => Request::input('occupation'),
                            'othernote' => Request::input('detail'),
                            ]);
            return redirect('assesment/section/view/'.Request::input('project_assessment_id'))->withSuccess("แก้ไขสำเร็จ");
    }

    public function DeleteAssesee($id,$assessmentid){
        if( $this->authsection() ){
            return redirect('logout');
        }
        
        $assessee = PersonalAssessment::where('project_assesment_id', $assessmentid)
                                    ->where('personal_assessment_id',$id)->delete();

        $auth = Auth::user();
        $new = new LogFile;
        $new->loglist_id = 7;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect()->back()->withSuccess("ลบรายการผู้ประเมินสำเร็จ");
      
    }

    public function Delete($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        PersonalAssessment::where('project_assesment_id', $id)
                        ->where('project_assesment_id',$id)->delete();

        ProjectAssesment::where('project_assesment_id',$id)->delete();

        $new = new LogFile;
        $new->loglist_id = 6;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect()->back()->withSuccess("ลบรายการผู้ประเมินสำเร็จ");
    }

    public function AssesmentExcel($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $assessee = PersonalAssessment::where('project_assesment_id', $id)->get();
                     
        $summary_array[] = array('ชื่อ-สกุล','ผลการประเมิน','การติดตาม','ต้องการสนับสนุน','ความสัมพันธ์ในครอบครัว','การมีรายได้','การมีอาชีพ');
        foreach( $assessee as $item ){ 
            $summary_array[] = array(
                'p1' => $item->registername,
                'p2' => $item->scorename ,
                'p3' => $item->followerstatusname ,
                'p4' => $item->needsupportname ,
                'p5' => $item->familyrelationname,
                'p6' => $item->enoughincomename,
                'p7' => $item->occupationname,
            );
        }

        $excelfile = Excel::create("assesment", function($excel) use ($summary_array){
            $excel->setTitle("การประเมิน");
            $excel->sheet('การประเมิน', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');
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
