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
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Resign;
use App\Model\Transfer;
use App\Model\Allocation;
use App\Model\Refund;
use App\Model\Position;
use App\Model\Quater;
use App\Model\Month;
use App\Model\Department;
use App\Model\Section;

class RecuritReportSectionPersonalController extends Controller
{
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $employ = Generate::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('generate_category',1)
                        ->where('generate_status',1)
                        ->get();
                        
        $payment = Payment::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('budget_id',1)
                        ->where('payment_category',1)
                        ->where('payment_status',1)
                        ->get();

        return view('recurit.report.section.personal.index')
                        ->withSetting($setting)
                        ->withPayment($payment)
                        ->withEmploy($employ);
    }

    public function ExportPDF($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $payment = Payment::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('budget_id',1)
                        ->where('payment_category',1)
                        ->where('payment_status',1)
                        ->where('register_id',$id)
                        ->get();

        $register = Register::where('register_id',$id )->first(); 
        $header = $register->prefixname . $register->name . " " . $register->lastname . " บัตรประชาชนเลขที่ " . $register->person_id ;
                        
        $pdf->loadView("recurit.report.section.personal.pdfpersonal" , [  'payment' => $payment , 'setting' => $setting, 'header' =>  $header ]);
        return $pdf->download('paymentreport.pdf');  
    }


    public function ExportExcel($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
  
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $payment = Payment::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('budget_id',1)
                        ->where('payment_category',1)
                        ->where('payment_status',1)
                        ->where('register_id',$id)
                        ->get();

        $summary_array[] = array('วันที่จ่าย','หักขาดเงิน','หักค่าปรับ','ค่าจ้างที่ได้รับ');
        foreach( $payment as $item ){
            $summary_array[] = array(
                'paymentdaate' => $item->paymentdateth,
                'absence' => $item->payment_absence,
                'fee' => $item->payment_fine,
                'remain' => $item->payment_salary
            );
        }

        $register = Register::where('register_id',$id )->first(); 

        $excelfile = Excel::create("paymentreport", function($excel) use ($summary_array){
            $excel->setTitle("สรุปการจ่ายเงินเดือนรายบุคคล");
            $excel->sheet("สรุปการจ่ายเงินเดือนรายบุคคล", function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  
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
