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
use App\Model\ProjectReadiness;
use App\Model\ReadinessExpense;
use App\Model\ProjectParticipate;
use App\Model\Department;
use App\Model\ProjectReadinessOfficer;
use App\Model\Trainer;
use App\Model\Company;
use App\Model\ReadinessSection;
use App\Model\ParticipateGroup;


class ReportOccupationDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setyear = Request::input('settingyear')==""?"":Request::input('settingyear');
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

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

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();   

        if($month == 0 && $quater == 0){
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();  
            $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();   
                      
        }else{
            if($month != 0 ){
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get(); 
                $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();   
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get();                                     
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get();                                    
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();             
                }
            }
        }
        return view('report.occupation.department.index')->withSetting($setting)
                                                ->withQuatername($quatername)
                                                ->withMonthname($monthname)
                                                ->withQuater($quater)
                                                ->withMonth($month)
                                                ->withProjectreadiness($projectreadiness)
                                                ->withParticipategroup($participategroup)
                                                ->withReadinesssection($readinesssection)
                                                ->withReadiness($readiness)
                                                ->withSettingyear($settingyear)
                                                ->withSetyear($setyear)
                                                ->withParticipate($participate);                                
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

        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();
        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id', $auth->department_id)->first();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                    ->where('project_type',2)
                    ->where('department_id', $auth->department_id)
                    ->get();  

        if($month == 0 && $quater == 0){      
           $header = "สำนักงาน" . $department->department_name;
           $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->where('department_id', $auth->department_id)
                        ->groupBy('project_readiness_id')
                        ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                        ->where('status',1)
                        ->where('project_type',2)
                        ->where('department_id', $auth->department_id)
                        ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->where('department_id', $auth->department_id)
                        ->get();  
            $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->where('department_id', $auth->department_id)
                        ->get();                                  
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;

                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();    
                $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();                            
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;

                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get();    
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get();                                                    
                }
                if ($quater == 2){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;

                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                })
                                ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get();                    
                }
                if ($quater == 3){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;

                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get();                   
                }
                if ($quater == 4){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                                       
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();  
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();                                         
                }
            }
        }
        
        $pdf->loadView("report.occupation.department.pdfoccupation" , [ 
                        'projectreadiness' => $projectreadiness , 
                        'readiness' => $readiness , 
                        'readinesssection' => $readinesssection , 
                        'participategroup' => $participategroup ,
                        'setyear' => $setyear , 
                        'participate' => $participate, 
                        'setting' => $setting, 
                        'header' =>  $header 
            ]);
        return $pdf->download('occupationreport.pdf');   

    }    
    public function ExportExcel($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();
        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id', $auth->department_id)->first();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();   

        if($month == 0 && $quater == 0){
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();  
            $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();                                    
                        
        }else{
            if($month != 0 ){
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();  
                $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();                                  
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get();                                     
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get();                                    
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();                                               
                }
            }
        }

        $summary_array[] = array('วันที่','โครงการ','จำนวนหน่วยงาน','เป้าหมายเข้าร่วม','เข้าร่วม','งบประมาณใช้จริง');
       
        foreach( $projectreadiness as $item ){
            // $actualparticipate = $participate->where('readiness_section_id' , $item->readiness_section_id)->sum('participate_num');                                            
            $actualparticipate = $participategroup->where('project_readiness_id' , $item->project_readiness_id)->count();                                            
            $num = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->groupBy('section_id')->count();
            $_target = $readiness->where('project_readiness_id',$item->project_readiness_id)->first()->targetparticipate * $num ;
            $sum = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->sum('actualexpense');
            $summary_array[] = array(
                'projectdate' => $item->adddate,
                'projectname' => $item->project_readiness_name,
                'numsection' =>  $num,
                'targetparticipate' => $_target,
                'participate' => $actualparticipate,
                'actualeapense' => $sum
            );
        }

        $excelfile = Excel::create("occupationreport", function($excel) use ($summary_array){
            $excel->setTitle("การฝึกอบรมวิชาชีพ");
            $excel->sheet('การฝึกอบรมวิชาชีพ', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  

    }

    public function ExportWord($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();
        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id', $auth->department_id)->first();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                    ->where('project_type',2)
                    ->where('department_id', $auth->department_id)
                    ->get(); 
 
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานผลการจัดโครงการฝึกอบรมและเตรียมความพร้อม','headerStyle', 'pStyle');

        $styleTable = array('borderSize' => 1, 'borderColor' => '000000',  'width' =>100 , 'cellMargin' => 0);
        $styleFirstRow = array('borderBottomSize' => 15, 'borderBottomColor' => '000000' );
        $styleCell = array('valign' => 'center');
        $styleCell2 = array('valign' => 'bottom');
        $styleCell3 = array('gridSpan' => 2);
        $rowstyle = array('exactHeight' => '100', 'gridSpan' => 500);
        $fontStyle = array('bold' => true, 'align' => 'center');
        $row3span = array('gridSpan' => 3);
        $phpWord->addTableStyle('Allocation', $styleTable, $styleFirstRow);   
        $header="";
        if($month == 0 && $quater == 0){   
            $header = "สำนักงาน" . $department->department_name;

            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();  
            $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();  
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name  ;
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();              
                $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->whereMonth('projectdate' , $month)
                                ->get();  
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
 
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get();  
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get();                                                                     
                }
                if ($quater == 2){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get();                                       
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get();                           
                }
                if ($quater == 4){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();  
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();                                       
                }
            }
        }


        $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
        $section->addText($header,'headerStyle', 'pStyle');
        $table = $section->addTable('Allocation');
        $table->addRow(50);
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('วันที่'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('โครงการ'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จำนวนหน่วยงาน'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('เป้าหมายเข้าร่วม'), 'headerStyle','pStyle');           
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เข้าร่วมจริง'), 'headerStyle','pStyle');  
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('งบประมาณใช้จริง'), 'headerStyle','pStyle');  
        

        foreach( $projectreadiness as $key => $item ){
            // $actualparticipate = $participate->where('readiness_section_id' , $item->readiness_section_id)->sum('participate_num');                                            
            $actualparticipate = $participategroup->where('project_readiness_id' , $item->project_readiness_id)->count();                                            
            $num = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->groupBy('section_id')->count();
            $_target = $readiness->where('project_readiness_id',$item->project_readiness_id)->first()->targetparticipate * $num ;
            $sum = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->sum('actualexpense');
            $table->addRow(10);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->adddate ),'bodyStyle','pStyle2');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->project_readiness_name),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $num  ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $_target),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $actualparticipate),'bodyStyle','pStyle');           
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $sum  ),'bodyStyle','pStyle');           
        }  
        // $table->addRow(15);
        // $table->addCell(8000, $row3span)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $readiness->sum('targetparticipate') ),'headerStyle','pStyle');
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $participate->sum('participate_num') ),'headerStyle','pStyle');        


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('occupationreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('occupationreport.docx'));
    }

    public function ExportSinglePDF($id){
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

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id', $auth->department_id)->first();
 
        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->where('project_readiness_id', $id)
                                ->first();  
        $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->where('project_readiness_id', $id)
                                ->get();  
        $trainer = Trainer::where('project_readiness_id' , $id)
                                ->where('project_type',2)
                                ->get();                        
        $company = Company::where('project_readiness_id' , $id)
                                ->where('project_type',2)
                                ->get();     
        $numofficer = ProjectReadinessOfficer::where('project_readiness_id' , $id)
                                ->where('project_type',2)
                                ->count(); 
        $cost = ReadinessExpense::where('project_readiness_id' , $id)
                                ->where('project_type',2)
                                ->first(); 
        $header = "สำนักงาน" . $department->department_name;
        $pdf->loadView("report.occupation.department.singlepdf" , [ 'readiness' => $readiness , 'participate' => $participate, 'setting' => $setting, 'header' =>  $header , 'trainer' => $trainer , 'company' => $company ,'numofficer' => $numofficer, 'cost' => $cost]);
        return $pdf->download('occupationreport.pdf');     
        

    }      

    public function OccupationChart(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where('department_id', $auth->department_id)
                                    ->get();   

        $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->groupBy('project_readiness_id')
                                ->get();  
        $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->get();                          
        $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->get();  
        $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where('department_id', $auth->department_id)
                                ->get(); 

        return view('report.occupation.department.occupationchart')->withSetting($setting)
                                ->withReadiness($readiness)
                                ->withProjectreadiness($projectreadiness)
                                ->withReadinesssection($readinesssection)
                                ->withParticipategroup($participategroup)
                                ->withParticipate($participate);

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

