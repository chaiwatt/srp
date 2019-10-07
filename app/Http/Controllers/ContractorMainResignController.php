<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;
use Excel;
use App\Model\SettingYear;
use App\Model\Contractor;
use App\Model\Project;
use App\Model\Register;
use App\Model\Resign;
use App\Model\Reason;
use App\Model\ContractorPosition;
use App\Model\Department;
use App\Model\Quater;
use App\Model\Month;

class ContractorMainResignController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }


        $department = ContractorPosition::groupBy('department_id')
        ->pluck('department_id')->toArray();

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = ContractorPosition::whereIn('department_id' , $department)->get();
        $month = Request::input('month')==""?"":Request::input('month');
        $monthname = Month::where('month_id',$month)->first();


        if($month == 0){
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->groupBy('department_id')
                    ->get();    
                    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_status',1)
                    ->where('resign_category',2)
                    ->get(); 
                   
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->get();        
        }else{
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('department_id')
                    ->get();    
                    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_status',1)
                    ->where('resign_category',2)
                    ->whereMonth('resign_date' , $month)
                    ->get(); 
                
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->where('resign_status',1)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('reason_id')
                    ->get(); 
        }
    
        return view('contractor.main.resign.index')->withSetting($setting)
                            ->withProject($project)
                            ->withNumdepartment($numdepartment)
                            ->withMonth($month)
                            ->withPosition($position)
                            ->withMonthname($monthname)
                            ->withReason($reason)
                            ->withResign($resign);
    
      }

      public function ExportPDF(){

        $auth = Auth::user();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);
    
        $department = ContractorPosition::groupBy('department_id')
        ->pluck('department_id')->toArray();

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = ContractorPosition::whereIn('department_id' , $department)->get();
        $month = Request::input('month')==""?"":Request::input('month');
        $monthname = Month::where('month_id',$month)->first();
    
        if($month == 0 ){      
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->groupBy('department_id')
                    ->get();    
                    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_status',1)
                    ->where('resign_category',2)
                    ->get(); 
                   
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->get();        
    
           $header = "";                      
        }else{
            $numdepartment = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->whereMonth('resign_date' , $month)
                    ->groupBy('section_id')
                    ->get();    
            $resign= Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_status',1)
                    ->where('resign_category',2)
                    ->whereMonth('resign_date' , $month)
                    ->get(); 
            $reason = Resign::where('project_id',$project->project_id)
                    ->where('resign_type',1)
                    ->where('resign_category',2)
                    ->where('resign_status',1)
                    ->groupBy('reason_id')
                    ->whereMonth('resign_date' , $month)
                    ->get();        
    
                $monthname = Month::where('month',$month)->first();                            
                $header =  "เดือน " . $monthname->month_name . " " . $setting->setting_year ;            
        }
        $pdf->loadView("contractor.main.resign.pdfresign" , [ 'reason' => $reason ,
                        'position' => $position ,
                        'resign' => $resign, 
                        'numdepartment' => $numdepartment, 
                        'setting' => $setting, 
                        'header' =>  $header 
         ]);
        return $pdf->download('resignreport.pdf');   
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
