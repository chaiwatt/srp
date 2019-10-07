<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Resign;
use App\Model\Reason;
use App\Model\Position;
use App\Model\Department;
use App\Model\Quater;
use App\Model\Month;

class RecuritReportDepartmentCancelController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = Position::where('department_id' , $auth->department_id)->get();
        $month = Request::input('month')==""?"":Request::input('month');
        $monthname = Month::where('month_id',$month)->first();

        if($month == 0){
            $numsection = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->where('department_id',$auth->department_id)
                    ->groupBy('section_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_status',1)
                    ->where('resign_category',1)
                    ->where('department_id',$auth->department_id)
                    ->get();  
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->get();          
        }else{
            $numsection = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->whereMonth('resign_date' , $month)
                    ->where('department_id',$auth->department_id)
                    ->groupBy('section_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_status',1)
                    ->where('resign_category',1)
                    ->where('department_id',$auth->department_id)
                    ->whereMonth('resign_date' , $month)
                    ->get();  
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('reason_id')
                    ->get();
        }

    return view('recurit.report.department.cancel.index')->withSetting($setting)
                            ->withProject($project)
                            ->withNumsection($numsection)
                            ->withMonth($month)
                            ->withPosition($position)
                            ->withReason($reason)
                            ->withMonthname($monthname)
                            ->withResign($resign);

    }

    public function ExportPDF(){
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
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = Position::where('department_id' , $auth->department_id)->get();
        $month = Request::input('month')==""?"":Request::input('month');
        $monthname = Month::where('month_id',$month)->first();
        $department = Department::where('department_id',$auth->department_id)->first();

        if($month == 0 ){      
            $numsection = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_category',1)
                    ->groupBy('section_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_status',1)
                    ->where('resign_category',1)
                    ->get(); 

            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->get();                       

           $header = "สำนักงาน" . $department->department_name;                      
        }else{
            $numsection = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_category',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('section_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_status',1)
                    ->where('resign_category',1)
                    ->whereMonth('resign_date' , $month)
                    ->get(); 

            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('department_id',$auth->department_id)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('reason_id')
                    ->get();                    
 
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name . " " . $setting->setting_year ;            
        }
        $pdf->loadView("recurit.report.department.cancel.pdfcancel" , ['reason' => $reason , 'position' => $position , 'resign' => $resign, 'numsection' => $numsection, 'setting' => $setting, 'header' =>  $header ]);
        return $pdf->download('cancelreport.pdf');   
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
