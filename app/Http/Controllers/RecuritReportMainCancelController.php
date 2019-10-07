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

class RecuritReportMainCancelController extends Controller
{

    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $position = Position::get();
        $month = Request::input('month')==""?"":Request::input('month');
        $monthname = Month::where('month_id',$month)->first();
        
        if($month == 0){
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->groupBy('department_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_status',1)
                    ->where('resign_category',1)
                    ->get();    
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->get(); 
        }else{
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('department_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->where('resign_category',1)
                    ->get(); 
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('reason_id')
                    ->get();         
        }

        return view('recurit.report.main.cancel.index')->withSetting($setting)
                    ->withProject($project)
                    ->withNumdepartment($numdepartment)
                    ->withMonth($month)
                    ->withPosition($position)
                    ->withMonthname($monthname)
                    ->withReason($reason)
                    ->withResign($resign);

    }

    public function ExportPDF(){
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

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = Position::get();
        $month = Request::input('month')==""?"":Request::input('month');
        $monthname = Month::where('month_id',$month)->first();
        
        if($month == 0){
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->groupBy('department_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_status',1)
                    ->where('resign_category',1)
                    ->get();    
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->get(); 
                    
            $header = "";
        }else{
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('department_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->where('resign_category',1)
                    ->get(); 
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',2)
                    ->where('resign_category',1)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('reason_id')
                    ->get();   
                    
            $monthname = Month::where('month',$month)->first();                            
            $header =  "เดือน " . $monthname->month_name . " " . $setting->setting_year ;            
        }
                    



        $pdf->loadView("recurit.report.main.cancel.pdfcancel" , [ 
                            'numdepartment' => $numdepartment , 
                            'resign' => $resign, 
                            'position' => $position, 
                            'reason' => $reason, 
                            'setting' => $setting, 
                            'header' =>  $header 
                ]);
        return $pdf->download('cancelreport.pdf');                           

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
