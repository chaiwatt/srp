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

class RecuritReportSectionAllpaymentController extends Controller
{

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');

        $allocation = Allocation::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('allocation_type' , 2)
                        ->get();
                        
        if($month == 0 && $quater == 0){
            $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->get();

            $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->get();
        }else{
            if($month != 0 ){
                $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->whereMonth('transfer_date' , $month)
                            ->get();

                $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->whereMonth('payment_date' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                                })->get();
                }
                if ($quater == 2){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                                })->get();
                }
                if ($quater == 3){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                                })->get();
                }
                if ($quater == 4){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                                })->get();
                }
            }
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        return view('recurit.report.section.allpayment.index')->withProject($project)
                    ->withTransfer($transfer)
                    ->withPayment($payment)
                    ->withMonth($month)
                    ->withQuater($quater)
                    ->withQuatername($quatername)
                    ->withMonthname($monthname)
                    ->withProject($project)
                    ->withSetting($setting)
                    ->withAllocation($allocation);
    }


    public function ExportPDF($month,$quater){
        if( $this->authsection() ){
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
        $section = Section::where('section_id', $auth->section_id)->first();

        $allocation = Allocation::where('project_id' , $project->project_id)
        ->where('department_id' , $auth->department_id)
        ->where('section_id' , $auth->section_id)
        ->where('budget_id' , 1)
        ->where('allocation_type' , 2)
        ->get();
        
        if($month == 0 && $quater == 0){      
            $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->get();

            $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->get();

           $header = $section ->section_name ;          

        }else{
            if($month != 0 ){
                $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->whereMonth('transfer_date' , $month)
                            ->get();

                $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->whereMonth('payment_date' , $month)
                            ->get();
                $monthname = Month::where('month',$month)->first();                            
                $header =  $section ->section_name . " เดือน " . $monthname->month_name ;
                           
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $section ->section_name . " " . $quatername->quater_name ;
                if ($quater == 1){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                                })->get();
                }
                if ($quater == 2){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                                })->get();
                }
                if ($quater == 3){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                                })->get();
                }
                if ($quater == 4){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                                })->get();
                }

            }
        }

        $pdf->loadView("recurit.report.section.allpayment.pdfallpayment" , [  'transfer' => $transfer , 'allocation' => $allocation ,'payment' => $payment , 'setting' => $setting, 'header' =>  $header ]);
        return $pdf->download('paymentreport.pdf');  
    }  
    public function ExportExcel($month,$quater){
        if( $this->authsection() ){
            return redirect('logout');
        }

    	$auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $section = Section::where('section_id', $auth->section_id)->first();

        $allocation = Allocation::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('allocation_type' , 2)
                            ->get();

        if($month == 0 && $quater == 0){      
            $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->get();

            $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->get();
                       
        }else{
            if($month != 0 ){
                $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->whereMonth('transfer_date' , $month)
                            ->get();

                $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->whereMonth('payment_date' , $month)
                            ->get();       

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                                })->get();
                }
                if ($quater == 2){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                                })->get();
                }
                if ($quater == 3){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                                })->get();
                }
                if ($quater == 4){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('transfer_status' , 1)
                                ->where('transfer_type' , 2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                                })->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                                })->get();
                }


            }
        }

        if(count($allocation) != 0){
            $_allocate = $allocation->sum('allocation_price');
        }else{
            $_allocate = 0;
        }
        if($transfer->count() !=0 ){
            $numtransfer = $transfer->count();
        }else{
            $numtransfer = 0;
        }
        if($payment->count() !=0 ){
            $_payment = $payment->sum('payment_salary');
        }else{
            $_payment = 0;
        }
        if($transfer->count() !=0 ){
            $_transfer = $transfer->sum('transfer_price');
            $percent = ($_payment/$_transfer)*100;
        }else{
            $_transfer =0;
            $percent =0;
        }
        $summary_array[] = array('งบประมาณจัดสรร','จำนวนโอน(ครั้ง)','รับโอน','เบิกจ่ายจริง','งบประมาณคงเหลือ','ร้อยละคงเหลือ');
            $summary_array[] = array(
                'allocate' => number_format($_allocate , 2) ,
                'numtransfer' => $numtransfer ,
                'transfer' => number_format($_transfer , 2)  ,
                'payment' => number_format($_payment , 2) ,
                'remian' =>   number_format(($_transfer-$_payment) , 2) ,
                'percent' => number_format($percent , 2) 
            );
        
        $excelfile = Excel::create("paymentreport", function($excel) use ($summary_array){
            $excel->setTitle("การเบิกจ่าย");
            $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
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
