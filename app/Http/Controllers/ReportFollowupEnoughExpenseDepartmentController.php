<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use PDF;
use Request;
use DB;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Quater;
use App\Model\Month;
use App\Model\ParticipateGroup;
use App\Model\Province;
use App\Model\PersonalAssessment;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\ProjectParticipate;
use App\Model\Department;
use App\Model\ReadinessSection;
use App\Model\Register;

class ReportFollowupEnoughExpenseDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setyear = Request::input('settingyear')==""?"":Request::input('settingyear');
        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $province = Province::all();
        $occupationarray = array();
        $sectionarray = array();
        $builder = "";
        
        $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        if($month == 0 && $quater == 0){
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
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );
        }else{
            if($month != 0 ){
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
                                    ->whereMonth('helddate' , $month)
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );
            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }
                if ($quater == 2){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }

                if ($quater == 3){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',3); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',4); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',5); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }

                if ($quater == 4){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',6); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',7); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',8); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }

            }
        }
        
        return view('report.followup.department.enoughexpense.index')->withSetting($setting)
                                                ->withQuatername($quatername)
                                                ->withMonthname($monthname)
                                                ->withQuater($quater)
                                                ->withSetyear($setyear)
                                                ->withSettingyear($settingyear)
                                                ->withOccupationdatabysection($occupationdatabysection)
                                                ->withMonth($month);
    }

    public function ExportExcel($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $province = Province::all();
        $occupationarray = array();
        $sectionarray = array();
        $builder = "";
        
        $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        if($month == 0 && $quater == 0){

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
                                ->whereIn('section_id',$section_arr)
                                ->get();   

                    // return $readiness;
    
                    if(count($readiness) > 0){
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
                                $section = Section::where('section_id',$_item)->first();
                                $_readiness = $readiness->where('section_id',$_item)->all();
                                $readiness_arr = array();
                                foreach($_readiness as $r){
                                    $readiness_arr[] = $r->readiness_section_id;
                                    $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                    $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                    $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                $numproject++;
                                $provincename = $item->province_name;
                            } 
                          }

                          if($totalhasoccupation !=0 ){
                            $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                          }else{
                            $_percent =0;
                          }
                          $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                    }
                }
            }   

           //สร้าง collection 
            $occupationdatabysection = collect( $sectionarray );
    }else{
        if($month != 0 ){
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
                                ->whereMonth('helddate' , $month)
                                ->whereIn('section_id',$section_arr)
                                ->get();   
    
                    if(count($readiness) > 0){
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
                                $section = Section::where('section_id',$_item)->first();
                                $_readiness = $readiness->where('section_id',$_item)->all();
                                $readiness_arr = array();
                                foreach($_readiness as $r){
                                    $readiness_arr[] = $r->readiness_section_id;
                                    $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                    $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                    $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                $numproject++;
                                $provincename = $item->province_name;
                            } 
                          }

                          if($totalhasoccupation !=0 ){
                            $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                          }else{
                            $_percent =0;
                          }
                          $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                    }
                }
            }   

           //สร้าง collection 
            $occupationdatabysection = collect( $sectionarray );
        }

        if($quater !=0 && $quater != ""){
            if ($quater == 1){
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
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );                   
            }
            if ($quater == 2){
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
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );                   
            }

            if ($quater == 3){
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
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',3); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',4); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',5); });
                                    })
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );                   
            }

            if ($quater == 4){
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
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',6); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',7); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',8); });
                                    })
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );                   
            }

        }
    }

            $summary_array[] = array('จังหวัด','จำนวนโครงการ','จำนวนผู้มีอาชีพ','จำนวนผู้มีรายได้เพียงพอ','ร้อยละการมีรายได้เพียงพอ');
            $numproject=0;
            $totalhasoccupationenoughincome=0;  
            $hasoccupation=0;
            $percent=0;
            foreach( $occupationdatabysection as $item ){
                $totalhasoccupationenoughincome = $totalhasoccupationenoughincome + $item['totalhasoccupationenoughincome'];
                $hasoccupation = $hasoccupation + $item['hasoccupation'];
                $numproject = $numproject + $item['numproject'];
                $percent = $percent + $item['percent'];

                $summary_array[] = array(
                    'province' =>  $item['province'] ,
                    'numproject' =>  $item['numproject'] ,
                    'hasoccupation' => $item['hasoccupation']  ,
                    'enoughexpense' => $item['totalhasoccupationenoughincome']  ,
                    'percent' =>  $item['percent'] 
                );
            }

            $excelfile = Excel::create("followreport", function($excel) use ($summary_array){
                $excel->setTitle("ติดตามการฝึกอบรมวิชาชีพ");
                $excel->sheet('ติดตามการฝึกอบรมวิชาชีพ', function($sheet) use ($summary_array){
                    $sheet->fromArray($summary_array,null,'A1',true,false);
                });
            })->download('xlsx'); 
    }

    public function ExportWord($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $province = Province::all();
        $occupationarray = array();
        $sectionarray = array();
        $builder = "";
        
        $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        $builder = "";
        $department = Department::where('department_id', $auth->department_id)->first();
 
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานผลการจติดตามโครงการฝึกอบรมและวิชาชีพ','headerStyle', 'pStyle');

        $styleTable = array('borderSize' => 1, 'borderColor' => '000000',  'width' =>100 , 'cellMargin' => 0);
        $styleFirstRow = array('borderBottomSize' => 15, 'borderBottomColor' => '000000' );
        $styleCell = array('valign' => 'center');
        $styleCell2 = array('valign' => 'bottom');
        $styleCell3 = array('gridSpan' => 2);
        $rowstyle = array('exactHeight' => '100', 'gridSpan' => 500);
        $fontStyle = array('bold' => true, 'align' => 'center');
        $row3span = array('gridSpan' => 3);
        $phpWord->addTableStyle('Allocation', $styleTable, $styleFirstRow);       

        if($month == 0 && $quater == 0){   
            $header = "สำนักงาน" . $department->department_name;
            $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
            $section->addText($header,'headerStyle', 'pStyle');
            $table = $section->addTable('Allocation');
            $table->addRow(50);
            $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จังหวัด'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีรายได้เพียงพอ'), 'headerStyle','pStyle');        
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละการมีรายได้เพียงพอ'), 'headerStyle','pStyle');  
            
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
                                ->whereIn('section_id',$section_arr)
                                ->get();   

                    // return $readiness;
    
                    if(count($readiness) > 0){
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
                                $section = Section::where('section_id',$_item)->first();
                                $_readiness = $readiness->where('section_id',$_item)->all();
                                $readiness_arr = array();
                                foreach($_readiness as $r){
                                    $readiness_arr[] = $r->readiness_section_id;
                                    $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                    $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                    $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                $numproject++;
                                $provincename = $item->province_name;
                            } 
                          }

                          if($totalhasoccupation !=0 ){
                            $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                          }else{
                            $_percent =0;
                          }
                          $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                    }
                }
            }   

           //สร้าง collection 
            $occupationdatabysection = collect( $sectionarray );
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;                
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จังหวัด'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีรายได้เพียงพอ'), 'headerStyle','pStyle');        
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละการมีรายได้เพียงพอ'), 'headerStyle','pStyle');  
               
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
                                    ->whereMonth('helddate' , $month)
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }
    
                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   
    
               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );

            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ; 
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จังหวัด'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีรายได้เพียงพอ'), 'headerStyle','pStyle');        
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละการมีรายได้เพียงพอ'), 'headerStyle','pStyle');  
               
                if ($quater == 1){
                    
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray ); 

                }
                if ($quater == 2){
                    
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray ); 

                }
                if ($quater == 3){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray ); 
                }
                if ($quater == 4){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray ); 
                } 
          
            
            }

        }

        $summary_array[] = array('จังหวัด','จำนวนโครงการ','จำนวนผู้มีอาชีพ','จำนวนผู้มีรายได้เพียงพอ','ร้อยละการมีรายได้เพียงพอ');
        $numproject=0;
        $totalhasoccupationenoughincome=0;  
        $hasoccupation=0;
        $percent=0;
        foreach( $occupationdatabysection as $item ){
            $totalhasoccupationenoughincome = $totalhasoccupationenoughincome + $item['totalhasoccupationenoughincome'];
            $hasoccupation = $hasoccupation + $item['hasoccupation'];
            $numproject = $numproject + $item['numproject'];
            $percent = $percent + $item['percent'];

            $table->addRow(10);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item['province'] ),'bodyStyle','pStyle2');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item['numproject']),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item['hasoccupation'] ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item['totalhasoccupationenoughincome'] ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item['percent'] ),'bodyStyle','pStyle');           
        }

        if($hasoccupation !=0 ){
            $percent  = number_format( ( $totalhasoccupationenoughincome  / $hasoccupation)*100 , 2) ;
        }else{
            $percent =0;
        }

        $table->addRow(15);
        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numproject ),'headerStyle','pStyle');
        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $hasoccupation ),'headerStyle','pStyle');        
        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $totalhasoccupationenoughincome ),'headerStyle','pStyle');        
        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $percent  ),'headerStyle','pStyle');            


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('followupreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('followupreport.docx'));
    }

    public function ExportPDF($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $auth = Auth::user();
        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $province = Province::all();
        $occupationarray = array();
        $sectionarray = array();
        $builder = "";
        
        $participategroup = ParticipateGroup::where('project_id',$project->project_id)->get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
        
        $department = Department::where('department_id', $auth->department_id)->first();

        if($month == 0 && $quater == 0){      
           $header = "สำนักงาน" . $department->department_name;
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
                            ->whereIn('section_id',$section_arr)
                            ->get();   

                if(count($readiness) > 0){
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
                            $section = Section::where('section_id',$_item)->first();
                            $_readiness = $readiness->where('section_id',$_item)->all();
                            $readiness_arr = array();
                            foreach($_readiness as $r){
                                $readiness_arr[] = $r->readiness_section_id;
                                $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                            $numproject++;
                            $provincename = $item->province_name;
                        } 
                      }

                      if($totalhasoccupation !=0 ){
                        $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                      }else{
                        $_percent =0;
                      }
                      $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                }
            }
        }   

       //สร้าง collection 
        $occupationdatabysection = collect( $sectionarray );                    

        }else{
            if($month != 0 ){                          
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;
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
                                    ->whereMonth('helddate' , $month)
                                    ->whereIn('section_id',$section_arr)
                                    ->get();   
        
                        if(count($readiness) > 0){
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
                                    $section = Section::where('section_id',$_item)->first();
                                    $_readiness = $readiness->where('section_id',$_item)->all();
                                    $readiness_arr = array();
                                    foreach($_readiness as $r){
                                        $readiness_arr[] = $r->readiness_section_id;
                                        $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                        $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                        $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                    $numproject++;
                                    $provincename = $item->province_name;
                                } 
                              }

                              if($totalhasoccupation !=0 ){
                                $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                              }else{
                                $_percent =0;
                              }
                              $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                        }
                    }
                }   

               //สร้าง collection 
                $occupationdatabysection = collect( $sectionarray );
 
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ;
                if ($quater == 1){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }
                if ($quater == 2){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }

                if ($quater == 3){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',3); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',4); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',5); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }

                if ($quater == 4){
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
                                        ->where(function($query){
                                            $query->orWhere(function($query1){$query1->whereMonth('helddate',6); });
                                            $query->orWhere(function($query2){$query2->whereMonth('helddate',7); });
                                            $query->orWhere(function($query3){$query3->whereMonth('helddate',8); });
                                        })
                                        ->whereIn('section_id',$section_arr)
                                        ->get();   
            
                            if(count($readiness) > 0){
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
                                        $section = Section::where('section_id',$_item)->first();
                                        $_readiness = $readiness->where('section_id',$_item)->all();
                                        $readiness_arr = array();
                                        foreach($_readiness as $r){
                                            $readiness_arr[] = $r->readiness_section_id;
                                            $totaltargetparticipate = $totaltargetparticipate +  $r->projectreadinesstarget ;                                        
                                            $actualparticipate = ProjectParticipate::where('readiness_section_id',$r->readiness_section_id)->sum('participate_num');
                                            $totalactualparticipate = $totalactualparticipate + $actualparticipate ;
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
                                        $numproject++;
                                        $provincename = $item->province_name;
                                    } 
                                  }
    
                                  if($totalhasoccupation !=0 ){
                                    $_percent = number_format( ($totalhasoccupation_enoughincome / $totalhasoccupation) * 100 , 2);
                                  }else{
                                    $_percent =0;
                                  }
                                  $sectionarray[] = array('numproject' => $numproject,'hasoccupation' => $totalhasoccupation ,'totalhasoccupationenoughincome' => $totalhasoccupation_enoughincome ,'percent' =>  $_percent , 'province' => $provincename );        
                            }
                        }
                    }   
    
                   //สร้าง collection 
                    $occupationdatabysection = collect( $sectionarray );                   
                }

            }
        }

        $pdf->loadView("report.followup.department.enoughexpense.pdffollowupenoughincome" , [ 
                        'occupationdatabysection' => $occupationdatabysection , 
                        'setting' => $setting, 
                        'setyear' => $setyear, 
                        'header' =>  $header 
            ]);
        return $pdf->download('followupreport.pdf'); 

    }  
    public function OccupationChart(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        return view('report.followup.department.enoughexpense.enoughexpensechart')->withSetting($setting);//

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
