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


class ReportAssessmentDepartmentController extends Controller
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

        if($month == 0 && $quater == 0){
            $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where('department_id', $auth->department_id)
                        ->get();
        }else{
            if($month != 0 ){
                $assessee = PersonalAssessment::where('project_id',$project->project_id)
                ->where('department_id', $auth->department_id)
                ->whereMonth('created_at' , $month)
                ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }

        return view('report.assessment.department.index')
        ->withProject($project)
        ->withSetyear($setyear)
        ->withSettingyear($settingyear)
        ->withMonth($month)
        ->withMonthname($monthname)
        ->withQuater($quater)
        ->withQuatername($quatername)
        ->withAssessee($assessee);
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


        $department = Department::where('department_id', $auth->department_id)->first();

        if($month == 0 && $quater == 0){   
            $header = "สำนักงาน" . $department->department_name;   
            $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where('department_id', $auth->department_id)
                        ->get();
        }else{
            if($month != 0 ){                          
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;
 
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ;


            }
        }


        $pdf->loadView("report.assessment.department.pdfassessment" , [ 
                        'assessee' => $assessee , 
                        'setting' => $setting, 
                        'setyear' => $setyear, 
                        'header' =>  $header 
            ])->setPaper('a4', 'landscape');
        return $pdf->download('pdffassessment.pdf'); 

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

        if($month == 0 && $quater == 0){
            $assessee = PersonalAssessment::where('project_id',$project->project_id)
                        ->where('department_id', $auth->department_id)
                        ->get();
        }else{
            if($month != 0 ){
                $assessee = PersonalAssessment::where('project_id',$project->project_id)
                ->where('department_id', $auth->department_id)
                ->whereMonth('created_at' , $month)
                ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $assessee = PersonalAssessment::where('project_id',$project->project_id)
                    ->where('department_id', $auth->department_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }

            $summary_array[] = array('หน่วยงาน','หัวข้อการประเมิน','ชื่อ-สกุล','เลขที่บัตรประชาชน','ผลการประเมิน','การติดตาม','ต้องการสนับสนุน','ความสัมพันธ์ในครอบครัว','การมีรายได้','การมีอาชีพ');
            foreach( $assessee as $item ){
                $summary_array[] = array(
                    'section' =>  $item->registersectionname ,
                    'projectname' => $item->projectassessmentname ,
                    'register' => $item->registername ,
                    'registerpersonid' => $item->registerpersonid ,
                    'scorename' => $item->scorename ,
                    'followerstatusname' => $item->followerstatusname ,
                    'needsupportname' =>  $item->needsupportname ,
                    'familyrelationname' =>  $item->familyrelationname  ,
                    'enoughincomename' =>  $item->enoughincomename ,
                    'occupationname' =>  $item->occupationname ,
                );
            }

            $excelfile = Excel::create("assessmentreport", function($excel) use ($summary_array){
                $excel->setTitle("การประเมินผล");
                $excel->sheet('การประเมินผล', function($sheet) use ($summary_array){
                    $sheet->fromArray($summary_array,null,'A1',true,false);
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
