<?php

namespace App\Http\Controllers;


use Request;
use Session;
use Auth;
use Excel;
use PDF;

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
use App\Model\Section;
use App\Model\Quater;
use App\Model\Month;
use App\Model\Department;


class ReportAssessmentMainController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
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
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();

        $department = PersonalAssessment::where('project_id',$project->project_id)
                                    ->groupBy('department_id')
                                    ->orderBy('created_at')
                                    ->get();

        if($month == 0 && $quater == 0){
            $assessee = PersonalAssessment::where('project_id',$project->project_id)
                                    ->groupBy('register_id')
                                    ->orderBy('created_at')
                                    ->get();
        }else{
            if($month != 0 ){
                $assessee = PersonalAssessment::where('project_id',$project->project_id)
                                    ->whereMonth('created_at' , $month)
                                    ->groupBy('register_id')
                                    ->orderBy('created_at')
                                    ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                        $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                        })
                        ->groupBy('register_id')
                        ->orderBy('created_at')
                        ->get();
                }
                if ($quater ==2){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->groupBy('register_id')
                    ->orderBy('created_at')
                    ->get();
                    }
                if ($quater == 3){
                        $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                        })
                        ->groupBy('register_id')
                        ->orderBy('created_at')
                        ->get();
                }
                if ($quater == 4){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->groupBy('register_id')
                    ->orderBy('created_at')
                    ->get();
                }
            }
        }
                                    
        return view('report.assessment.main.index')->withSetting($setting)
                    ->withQuatername($quatername)
                    ->withMonthname($monthname)
                    ->withQuater($quater)
                    ->withSettingyear($settingyear)
                    ->withSetyear($setyear)
                    ->withMonth($month)
                    ->withDepartment($department)
                    ->withAssessee($assessee);
    }

    public function ExportPDF($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

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

        $department = PersonalAssessment::where('project_id',$project->project_id)
                                    ->groupBy('department_id')
                                    ->orderBy('created_at')
                                    ->get();
                    
        if($month == 0 && $quater == 0){      
           $header = "";
           $assessee = PersonalAssessment::where('project_id',$project->project_id)
                                        ->groupBy('register_id')
                                        ->orderBy('created_at')
                                        ->get();
                                
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header = "เดือน " . $monthname->month_name ;
                $assessee = PersonalAssessment::where('project_id',$project->project_id)
                                        ->whereMonth('created_at' , $month)
                                        ->groupBy('register_id')
                                        ->orderBy('created_at')
                                        ->get();
                                                        
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;
                if ($quater == 1){
                        $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                        })
                        ->groupBy('register_id')
                        ->orderBy('created_at')
                        ->get();
                }
                if ($quater ==2){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->groupBy('register_id')
                    ->orderBy('created_at')
                    ->get();
                    }
                if ($quater == 3){
                        $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                        })
                        ->groupBy('register_id')
                        ->orderBy('created_at')
                        ->get();
                }
                if ($quater == 4){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->groupBy('register_id')
                    ->orderBy('created_at')
                    ->get();
                }
            }
        }

        $pdf->loadView("report.assessment.main.pdfassessment" , [ 
                        'settingyear' => $settingyear , 
                        'assessee' => $assessee , 
                        'setyear' => $setyear , 
                        'project' => $project, 
                        'department' => $department, 
                        'setting' => $setting, 
                        'header' =>  $header 
            ])->setPaper('a4', 'landscape');
        return $pdf->download('pdfassessment.pdf');   

    } 


    public function ExportExcel($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
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

        $department = PersonalAssessment::where('project_id',$project->project_id)
                                    ->groupBy('department_id')
                                    ->orderBy('created_at')
                                    ->get();

        if($month == 0 && $quater == 0){
            $assessee = PersonalAssessment::where('project_id',$project->project_id)
                                    ->groupBy('register_id')
                                    ->orderBy('created_at')
                                    ->get();
        }else{
            if($month != 0 ){
                $assessee = PersonalAssessment::where('project_id',$project->project_id)
                                    ->whereMonth('created_at' , $month)
                                    ->groupBy('register_id')
                                    ->orderBy('created_at')
                                    ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                        $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                        })
                        ->groupBy('register_id')
                        ->orderBy('created_at')
                        ->get();
                }
                if ($quater ==2){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->groupBy('register_id')
                    ->orderBy('created_at')
                    ->get();
                    }
                if ($quater == 3){
                        $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                        })
                        ->groupBy('register_id')
                        ->orderBy('created_at')
                        ->get();
                }
                if ($quater == 4){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->groupBy('register_id')
                    ->orderBy('created_at')
                    ->get();
                }
            }
        }
    

            $summary_array[] = array('สังกัด','จำนวนผู้ประเมิน','การประเมิน/ดีเด่น','การประเมิน/ดี','การประเมิน/ปรับปรุง','จำนวนผู้ติดตาม','มีงาน','ไม่มีงาน','ศึกษาต่อ','ตาย','ถูกจับ','ติดตามไม่ได้','ต้องการสนับสนุน','ไม่ต้องการสนับสนุน','สัมพันธ์ในครอบครัวดี','สัมพันธ์ในครอบครัวมีปัญหา');
            foreach( $department as $item ){
                $summary_array[] = array(    
                    'dept' =>  $item->departmentname ,                
                    'total' =>  $assessee->count() ,
                    'best' => $assessee->where('score_id',1)->count(),
                    'good' => $assessee->where('score_id',2)->count() ,
                    'fair' => $assessee->where('score_id',3)->count() ,
                    'numfollow' => $assessee->where('follower_status_id','!=',0)->count() ,
                    'hasjob' => $assessee->where('follower_status_id',2)->count() ,
                    'nojob' => $assessee->where('follower_status_id',3)->count() ,
                    'educate' => $assessee->where('follower_status_id',4)->count() ,
                    'dead' => $assessee->where('follower_status_id',5)->count() ,
                    'arrest' => $assessee->where('follower_status_id',6)->count() ,
                    'notcontact' => $assessee->where('follower_status_id',7)->count(),
                    'neesupport' => $assessee->where('needsupport_id',2)->count() ,
                    'noneesupport' => $assessee->where('needsupport_id',3)->count() ,
                    'goodrelation' =>  $assessee->where('familyrelation_id',2)->count(),
                    'badrelation' =>  $assessee->where('familyrelation_id',3)->count()
                );
            }

            $excelfile = Excel::create("assessment", function($excel) use ($summary_array){
                $excel->setTitle("รายการประเมินผล");
                $excel->sheet('รายการประเมินผล', function($sheet) use ($summary_array){
                    $sheet->fromArray($summary_array,null,'A1',true,false);
                });
            })->download('xlsx'); 
    }

    public function authsuperadmint(){
        $auth = Auth::user();
        if( $auth->permission != 1 ){
            return true;
        }
        else{
            return false;
        }
    }
}
