<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use Excel;
use PDF;
use DB;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Generate;
use App\Model\Resign;
use App\Model\Quater;
use App\Model\Month;
use App\Model\SettingDepartment;
use App\Model\Payment;
use App\Model\ParticipateGroup;
use App\Model\ProjectReadiness;
use App\Model\PersonalAssessment;
use App\Model\ReadinessSection;
use App\Model\ProjectParticipate;
use App\Model\Province;

class PublicReportController extends Controller
{
    public function Report(){
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();

         return view('publicreport.index')->withSetting($setting)
                    ->withQuatername($quatername)
                    ->withMonthname($monthname)
                    ->withQuater($quater)
                    ->withMonth($month)
                    ->withAuth($auth);
 
    }

    public function Allocation(){
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('publicreport/report');
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        if($month == 0 && $quater == 0){
            $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)
                        ->get();
            
            $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->get();
        }else{
            if($month != 0 ){
                $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)                       
                        ->whereMonth('created_at' , $month)
                        ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->whereMonth('created_at' , $month)
                        ->get();   
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();          

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){                    
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 
                }
                if ($quater == 3){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 
                }
                if ($quater == 4){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();           
                }
            }
        }

        return view('publicreport.allocation')->withSetting($setting)
                                    ->withQuatername($quatername)
                                    ->withMonthname($monthname)
                                    ->withQuater($quater)
                                    ->withMonth($month)
                                    ->withAuth($auth)
                                    ->withDepartment($department)
                                    ->withResign($resign)
                                    ->withAuth($auth)
                                    ->withEmploy($employ);
        
    }
    public function Expense(){

        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('publicreport/report');
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();
        
        if($month == 0 && $quater == 0){
            $payment = Payment::where('project_id' , $project->project_id)
                ->where('budget_id' , 1)
                ->where('payment_category' , 1)
                ->where('payment_status' , 1)
                ->get();
        }else{
            if($month != 0 ){
                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){           
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();                   
                }
                if ($quater == 2){                    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();    
                }
                if ($quater == 3){                   
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();    
                }
                if ($quater == 4){                   
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();     
                }
            }
 
        }

        return view('publicreport.expense')->withSetting($setting)
                                        ->withQuatername($quatername)
                                        ->withMonthname($monthname)
                                        ->withAuth($auth)
                                        ->withQuater($quater)
                                        ->withMonth($month)
                                        ->withDepartment($department)
                                        ->withPayment($payment);
        
    }

    public function Readiness(){
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('publicreport/report');
        }
        $setyear = $setting->setting_year;

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->get();   

        if($month == 0 && $quater == 0){
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',1)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',1)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->get(); 
            $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->get();                                      
        }else{
            if($month != 0 ){
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',1)
                                ->where('status',1)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',1)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',1)
                                ->whereMonth('projectdate' , $month)
                                ->get();  
                $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                ->where('project_type',1)
                                ->whereMonth('projectdate' , $month)
                                ->get();                                 
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',1)
                                    ->where('status',1)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',1)
                                    ->where('status',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get();                                      
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',1)
                                    ->where('status',1)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get();
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get();                                      
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',1)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get();                                 
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',1)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('status',1)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get(); 
                    $participategroup = ParticipateGroup::where('project_id' , $project->project_id)
                                    ->where('project_type',1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();                                                
                }
            }
        }

        return view('publicreport.readiness')->withSetting($setting)
                        ->withQuatername($quatername)
                        ->withMonthname($monthname)
                        ->withQuater($quater)
                        ->withMonth($month)
                        ->withReadiness($readiness)
                        ->withReadinesssection($readinesssection)
                        ->withSettingyear($settingyear)  
                        ->withParticipategroup($participategroup)                           
                        ->withParticipate($participate)
                        ->withDepartment($department)
                        ->withAuth($auth);
    }


    public function Occupation(){
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        $project = Project::where('year_budget' , $setting->setting_year)->first();

        if(Empty($project)){
            return redirect('publicreport/report');
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();   

        if($month == 0 && $quater == 0){
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();  
        }else{
            if($month != 0 ){
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('projectdate' , $month)
                                ->get();  
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
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
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
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
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
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
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();             
                }
            }
        }

        return view('publicreport.occupation')->withSetting($setting)
                        ->withQuatername($quatername)
                        ->withMonthname($monthname)
                        ->withQuater($quater)
                        ->withMonth($month)
                        ->withReadiness($readiness)
                        ->withReadinesssection($readinesssection)
                        ->withSettingyear($settingyear)                           
                        ->withParticipate($participate)
                        ->withDepartment($department)
                        ->withAuth($auth);
    }


    public function HasIncome(){

        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setyear = Request::input('settingyear')==""?"":Request::input('settingyear');

        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        $project = Project::where('year_budget' , $setting->setting_year)->first();

        if(Empty($project)){
            return redirect('publicreport/report');
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $province = Province::all();

        $occupationarray = array();
        $sectionarray = array();
        $department = Department::get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        if($month == 0 && $quater == 0){            
           
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                        ->where('status',1)
                        ->where('project_type',2)
                        ->get();

            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();  

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();

        }else{
            if($month != 0 ){
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                            ->where('status',1)
                            ->where('project_type',2)
                            ->whereMonth('helddate' , $month)
                            ->get();

                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();  

                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                })
                                ->get();

                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();  

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                }
                if ($quater == 2){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                })
                                ->get();

                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();  

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                }
                if ($quater == 3){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                })
                                ->get();

                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();  

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                }
                if ($quater == 4){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                })
                                ->get();

                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();  

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();
                }

            }
        }


        return view('publicreport.hasincome')->withSetting($setting)
                                                ->withQuatername($quatername)
                                                ->withMonthname($monthname)
                                                ->withSettingyear($settingyear)
                                                ->withQuater($quater)
                                                ->withDepartment($department)
                                                ->withParticipate($participate)
                                                ->withParticipategroup($participategroup)
                                                ->withPersonalassessment($personalassessment)
                                                ->withReadinesssection($readinesssection)                                                
                                                ->withMonth($month)
                                                ->withAuth($auth);
    }

    public function EnoughIncome(){

        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('publicreport/report');
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = Department::get();
        
        if($month == 0 && $quater == 0){
            $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();   
            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        }else{
            if($month != 0 ){
                $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();   
                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
                $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 2){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 3){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 4){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
            }
        }

        return view('publicreport.enoughincome')->withSetting($setting)
                                ->withQuatername($quatername)
                                ->withMonthname($monthname)
                                ->withQuater($quater)
                                ->withMonth($month)
                                ->withReadiness($readiness)
                                ->withParticipategroup($participategroup)
                                ->withPersonalassessment($personalassessment)
                                ->withDepartment($department)
                                ->withAuth($auth);

    }
}
