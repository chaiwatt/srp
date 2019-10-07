<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use PDF;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Assessment;
use App\Model\FitStatus;
use App\Model\RegisterAssesmentFit;
use App\Model\Assessor;
use App\Model\RegisterAssessment;
class RecuritAssesmentReport extends Controller
{
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $registerassesmentfit = RegisterAssesmentFit::get();
        $register= Generate::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('generate_category' , 1)
                    ->where('generate_status' , 1)
                    ->get();

       return view('recurit.assesment.report.index')->withProject($project)
                                        ->withRegisterassesmentfit($registerassesmentfit)
                                        ->withRegister($register);
    }

    public function Download($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $registerassesmentfit = RegisterAssesmentFit::where('register_id',$id)->get();
        $register = Register::where('register_id',$id)->first();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $registerassessment = RegisterAssessment::get();
        $assessor = Assessor::get();   

        $pdf->loadView("recurit.assesment.report.pdfpersonalassessment" , [ 'registerassesmentfit' => $registerassesmentfit , 'registerassessment' => $registerassessment ,'project' => $project, 'register' => $register ,'assessor' => $assessor])->setPaper('a4', 'landscape');
        return $pdf->download('personalassessment.pdf');   
    }

    public function authsection(){
        $auth = Auth::user();
        if( $auth->permission != 3 ){
            return true;
        }
        else{
            return false;
        }
    }
}
