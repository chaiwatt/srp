<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;
use Excel;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Resign;
use App\Model\Reason;
use App\Model\Position;
use App\Model\Department;
use App\Model\Quater;
use App\Model\Month;
use App\Model\Generate;
use App\Model\Assessment;
use App\Model\FitStatus;
use App\Model\RegisterAssesmentFit;
use App\Model\Assessor;
use App\Model\RegisterAssessment;

class RecuritReportMainAssessmentController extends Controller
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
    $registerassesmentfit = RegisterAssesmentFit::where('project_id' , $project->project_id)->get();
    $register= Generate::where('project_id' , $project->project_id)
                ->where('generate_category' , 1)
                ->where('generate_status' , 1)
                ->get();
    $department =  RegisterAssesmentFit::where('project_id' , $project->project_id)
                ->groupBy('department_id')
                ->get();   

    $latest  = RegisterAssesmentFit::where('project_id' , $project->project_id)                              
                    ->orderBy('register_assesment_fit_id', 'asc')
                    ->groupBy('register_id')
                    ->get();

    $list = RegisterAssesmentFit::select(DB::raw('MAX(register_assesment_fit_id) AS max'))
            ->groupby('register_id')
            ->get()->toArray();
                            
    $uniquessesmentfit = RegisterAssesmentFit::whereIn('register_assesment_fit_id', $list)
            ->get();   

    $uniquessesment = RegisterAssessment::whereIn('register_assesment_fit_id', $list)
            ->get();  

   return view('recurit.report.main.assessment.index')->withProject($project)
                                    ->withDepartment($department)
                                    ->withUniquessesmentfit($uniquessesmentfit)
                                    ->withUniquessesment($uniquessesment)
                                    ->withRegisterassesmentfit($registerassesmentfit)
                                    ->withRegister($register);


}
   
public function ExportPDF(){
    if( $this->authsuperadmint() ){
        return redirect('logout');
    }
    $pdf = PDF::setOptions([
        'isHtml5ParserEnabled' => true, 
        'isRemoteEnabled' => true , 
        'logOutputFile' => storage_path('logs/log.htm'),
        'tempDir' => storage_path('logs/')
    ]);
    $auth = Auth::user();
    $setting = SettingYear::where('setting_status' , 1)->first();
    $project = Project::where('year_budget' , $setting->setting_year)->first();
    $registerassesmentfit = RegisterAssesmentFit::where('project_id' , $project->project_id)
    ->get();

    $register= Generate::where('project_id' , $project->project_id)
                ->where('generate_category' , 1)
                ->where('generate_status' , 1)
                ->get();
                
    $department =  RegisterAssesmentFit::where('project_id' , $project->project_id)
                ->groupBy('department_id')
                ->get();   
 

    $latest  = RegisterAssesmentFit::where('project_id' , $project->project_id)                              
                    ->orderBy('register_assesment_fit_id', 'asc')
                    ->groupBy('register_id')
                    ->get();

    $list = RegisterAssesmentFit::select(DB::raw('MAX(register_assesment_fit_id) AS max'))
            ->groupby('register_id')
            ->get()->toArray();
                            
    $uniquessesmentfit = RegisterAssesmentFit::whereIn('register_assesment_fit_id', $list)
            ->get();   

    $uniquessesment = RegisterAssessment::whereIn('register_assesment_fit_id', $list)
            ->get();            
    $header = $auth->department_name;
    $pdf->loadView("recurit.report.main.assessment.pdfassessment" , [ 
                        'department' => $department , 
                        'project' => $project ,
                        'uniquessesmentfit' => $uniquessesmentfit, 
                        'uniquessesment' => $uniquessesment, 
                        'registerassesmentfit' => $registerassesmentfit, 
                        'register' => $register, 
                        'header' =>  $header 
        ])->setPaper('a4', 'landscape');

    return $pdf->download('pdfassessment.pdf');   
}  

public function ExportExcel(){
    if( $this->authsuperadmint() ){
        return redirect('logout');
    }
    $auth = Auth::user();
    $setting = SettingYear::where('setting_status' , 1)->first();
    $project = Project::where('year_budget' , $setting->setting_year)->first();
    $registerassesmentfit = RegisterAssesmentFit::where('project_id' , $project->project_id)
    ->get();

    $register= Generate::where('project_id' , $project->project_id)
                ->where('generate_category' , 1)
                ->where('generate_status' , 1)
                ->get();
                
    $department =  RegisterAssesmentFit::where('project_id' , $project->project_id)
                ->groupBy('department_id')
                ->get();   
 

    $latest  = RegisterAssesmentFit::where('project_id' , $project->project_id)                              
                    ->orderBy('register_assesment_fit_id', 'asc')
                    ->groupBy('register_id')
                    ->get();

    $list = RegisterAssesmentFit::select(DB::raw('MAX(register_assesment_fit_id) AS max'))
            ->groupby('register_id')
            ->get()->toArray();
                            
    $uniquessesmentfit = RegisterAssesmentFit::whereIn('register_assesment_fit_id', $list)
            ->get();   

    $uniquessesment = RegisterAssessment::whereIn('register_assesment_fit_id', $list)
            ->get();  


    $summary_array[] = array('หน่วยงาน','จำนวนผู้ทดสอบ','คะแนนเฉลี่ย','ความต้องการอาชีพ','ความต้องการการศึกษา','การให้การอบรมอาชีพ','การให้การอบรมการศึกษา','การมอบหมายงาน'); 
    if(count($department) > 0){
        foreach( $department as $item ){
            $num = $uniquessesmentfit->where('department_id',$item->department_id)
            ->count();
            $allscore = $uniquessesment->where('department_id',$item->department_id)
            ->sum('register_assessment_point');
            $total = $uniquessesment->where('department_id',$item->department_id)->count();
            $scoreavg = number_format( ($allscore / $total) , 2);
            $occupationneedfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registeroccupationneedfit',1)
            ->count();
            $educationneedfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registereducationneedfit',1)
            ->count();

            $occupationtrainfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registeroccupationtrainfit',1)
            ->count();
            $educationtrainfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registereducationtrainfit',1)
            ->count();
            $jobassignmentfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('jobassignmentfit',1)
            ->count();

            $summary_array[] = array(
                'sectionname' => $item->departmentname,
                'num' => $num ,
                'scoreavg' => $scoreavg ,
                'occupationneedfit' => $occupationneedfit  ,
                'educationneedfit' => $educationneedfit,
                'occupationtrainfit' => $occupationtrainfit,
                'educationtrainfit' =>  $educationtrainfit ,
                'jobassignmentfit' =>  $jobassignmentfit ,
            );
        }    
    }

    $excelfile = Excel::create("assessmentreport", function($excel) use ($summary_array){
        $excel->setTitle("การประเมินบุคลิกภาพ");
        $excel->sheet('การประเมินบุคลิกภาพ', function($sheet) use ($summary_array){
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


