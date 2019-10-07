<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use PDF;
use Request;
use DB;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\FollowupSection;
use App\Model\ParticipateGroup;
use App\Model\Province;
use App\Model\PersonalAssessment;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\ProjectParticipate;
use App\Model\Department;
use App\Model\ProjectFollowup;
use App\Model\Generate;
use App\Model\FollowupInterview;
use App\Model\FollowupRegister;


class ReportFollowupOnsiteDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
    
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)->get();

        return view('report.followup.department.onsite.index')->withProject($project)
                                ->withProjectfollowup($projectfollowup);
    }


    public function View($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();
        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
        $generate = Generate::where('project_id',$project->project_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->get();
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

       $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();   
       $projectreadiness =ProjectReadiness::where('project_id',$project->project_id)->get();  
       $followupinterview = FollowupInterview::where('project_id',$project->project_id)
                            ->where('project_followup_id',$id)
                            ->get();
        $followupregister = FollowupRegister::get();

        return view('report.followup.department.onsite.view')->withProject($project)
                                ->withSelectedprovince($selectedprovince)
                                ->withFollowupsection($followupsection)
                                ->withGenerate($generate)
                                ->withGenerate($generate)
                                ->withMapcode($mapcode)                                
                                ->withFollowupregister($followupregister)         
                                ->withFollowupinterview($followupinterview)
                                ->withProjectreadiness($projectreadiness)
                                ->withProjectfollowup($projectfollowup);
    }


    public function ExportPDF($id){

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $auth = Auth::user();   
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();
        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
        $generate = Generate::where('project_id',$project->project_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->get();
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

        
        $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();   
        $projectreadiness =ProjectReadiness::where('project_id',$project->project_id)->get();  
        $header = "";  
        if($auth->permission == 2){
            $department = Department::where('department_id',$auth->department_id)->first();
            $header = "สำนักงาน" . $department->department_name;  
        }
        $followupinterview = FollowupInterview::where('project_id',$project->project_id)
        ->where('project_followup_id',$id)
        ->get();
        $followupregister = FollowupRegister::get();

        $pdf->loadView("report.followup.department.onsite.pdfonsite" , [ 
                            'project' => $project , 
                            'selectedprovince' => $selectedprovince, 
                            'followupsection' => $followupsection,
                            'generate' => $generate,
                            'projectreadiness' => $projectreadiness,
                            'projectfollowup' => $projectfollowup,
                            'mapcode' => $mapcode,
                            'followupregister' => $followupregister,
                            'followupinterview' => $followupinterview,
                            'setting' => $setting, 
                            'header' =>  $header 
            ])->setPaper('a4', 'landscape');
        return $pdf->download('readinessreport.pdf');   
    }  

    public function ExportExcel($id){
        // if( $this->authdepartment() ){
        //     return redirect('logout');
        // }

        $auth = Auth::user();   
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $followupsection = FollowupSection::where('project_followup_id',$id)->get();
        $projectfollowup = ProjectFollowup::where('project_id',$project->project_id)
                                    ->where('project_followup_id',$id)
                                    ->first();
        $mapcode = FollowupSection::where('project_followup_id',$id)->groupBy('map_code')->get();
        $generate = Generate::where('project_id',$project->project_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->get();
        foreach($mapcode as $val){
            $mapcode_arr[] = $val->map_code;
        }

       $selectedprovince = Province::whereIn('map_code',$mapcode_arr)->get();   
       $projectreadiness =ProjectReadiness::where('project_id',$project->project_id)->get();  
       $followupinterview = FollowupInterview::where('project_id',$project->project_id)
                            ->where('project_followup_id',$id)
                            ->get();
        $followupregister = FollowupRegister::get();

        $summary_arrayx[] = array();
        $summary_array_1[] = array('ชื่อกิจกรรม','จังหวัดที่ติดตาม','หน่วยงาน','จำนวนผู้ได้รับจ้างงาน','ผู้สอนงาน','ผู้บริหาร'); 
        $summary_array_2[] = array('จังหวัด','หน่วยงาน','ชื่อ-สกุล','เลขบัตรประชาชน','พึงพอใจในโครงการ','สถานที่ต้องการทำงาน','ปัญหาและข้อเสนอแนะ'); 

// ข้อมูล1
            $province="";
            foreach ($selectedprovince as $p){
                $province = $province . $p->province_name . " ,";
            }
            $section="";
            $_employ="";
            $_readiness="";
            foreach ($followupsection as $p){
                $section = $section . $p->section_name . " ,";
                $_employ = $_employ .  $p->section_name ." (". $generate->where('section_id',$p->section_id )->count('register_id') . "คน),";                                    
            }


            $summary_array_1[] = array(
                'projectname' => $projectfollowup->project_followup_name,
                'province' => substr_replace($province, "", -1),
                'section' =>  substr_replace($section, "", -1) ,
                'numhire' => substr_replace($_employ, "", -1) ,
                'teacher' =>  $followupinterview->where('interviewee_type',1)->count() ,
                'manager' => $followupinterview->where('interviewee_type',2)->count() ,
            );


            // ข้อมูล2

            foreach ($selectedprovince as $key => $item){
                $sec = $followupsection->where('map_code', $item->map_code)->pluck('section_id')->toArray();   
                $num = count($followupregister->whereIn('sectionid',$sec)->all());
                foreach ($followupsection as $t => $v){
                    if ($v->map_code == $item->map_code){
                        $check = $followupregister->where('sectionid',$v->section_id)->all();
                    foreach ($check as $k => $c){
                            $summary_array_2[] = array(
                                'province' => $item->province_name,
                                'section' => $v->sectionname,
                                'register' => $c->registerprefixname . $c->registername . " " . $c->registerlastname ,
                                'personid' => $c->registerpersonid ,
                                'test1' =>  $c->registersatisfaction ,
                                'test2' => $c->workon ,
                                'test3' => $c->problem ,
                            );
                        }
                    }
                }
            }


                $summary_array_2[] = array(
                    'province' => "",
                    'section' => "",
                    'register' => "",
                    'personid' =>  "",
                    'test1' =>  "",
                    'test2' => "" ,
                    'test3' => "" ,
                );

                foreach ($selectedprovince as $key => $item){
                    $sec = $followupsection->where('map_code', $item->map_code)->pluck('section_id')->toArray();   
                    $num = count($followupregister->whereIn('sectionid',$sec)->all());
                    foreach ($followupsection as $t => $v){
                        if ($v->map_code == $item->map_code){
                            $check = $followupregister->where('sectionid',$v->section_id)->all();
                            $teacher = $followupinterview->where('interviewee_section',$v->section_id)->where('interviewee_type',1);
                            $manager = $followupinterview->where('interviewee_section',$v->section_id)->where('interviewee_type',2); 

                                $summary_array_2[] = array(
                                    'province' => $item->province_name,
                                    'section' => $v->sectionname,
                                    'register' => "จำนวนผู้สอนงาน " . count($teacher) . " คน",
                                    'personid' =>  "จำนวนผู้บริหาร " . count($manager) . " คน",
                                    'test1' =>  "",
                                    'test2' => "" ,
                                    'test3' => "" ,
                                );
                        }
                    }
                }



        $summary_arrayx= array($summary_array_1,$summary_array_2);
        $excelfile = Excel::create("occupationreport", function($excel) use ($summary_arrayx){
            $excel->setTitle("การติดตามความก้าวหน้า");
            $excel->sheet('การติดตามความก้าวหน้า', function($sheet) use ($summary_arrayx){
                $sheet->fromArray($summary_arrayx[0],null,'A1',true,false);
            });
            $excel->sheet('การติดตามความก้าวหน้า2', function($sheet) use ($summary_arrayx){
                $sheet->fromArray($summary_arrayx[1],null,'A1',true,false);
            });
        })->download('xlsx');  
          
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
