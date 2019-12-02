<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;
use Excel;

use App\Controllers\ApiController;
use App\Model\Department;
use App\Model\Budget;
use App\Model\Project;
use App\Model\Allocation;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\Section;
use App\Model\InformationExpense;
use App\Model\Survey;
use App\Model\TransferTransaction;
use App\Model\Payment;
use App\Model\Quater;
use App\Model\Month;

class ProjectReportDepartmentController extends Controller
{

    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setyear = Request::input('settingyear')==""?"":Request::input('settingyear');

        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('project/report/department')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $allocation = Allocation::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('allocation_type' , 2)
                    ->get();
        $section = Allocation::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('allocation_type' , 2)
                    ->groupBy('section_id')
                    ->get();  
        

        if($month == 0 && $quater == 0){
            $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('budget_id' , 1)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 2)
                    ->get();       

            $payment = Payment::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('budget_id' , 1)
                    ->where('payment_category' , 1)
                    ->where('payment_status' , 1)
                    ->get();  
        }else{
            if($month != 0 ){
                $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->whereMonth('transfer_date' , $month)
                        ->get();       

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
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
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                        })
                        ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                        })
                        ->get();  
                }
                if ($quater == 2){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                            $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                            $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                        })
                        ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                        })
                        ->get();  
                }  
                if ($quater == 3){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                        })
                        ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                        })
                        ->get();  
                }   
                if ($quater == 4){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                        })
                        ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                        })
                        ->get();  
                }                             
            }

        }

        return view('project.report.department.index')->withProject($project)
                            ->withSection($section)
                            ->withQuater($quater)
                            ->withMonth($month)
                            ->withSettingyear($settingyear)
                            ->withSetyear($setyear)
                            ->withTransfer($transfer)
                            ->withPayment($payment)
                            ->withAllocation($allocation);
    
    }

    public function ExportPDF($month,$quater,$setyear){
        if( $this->authdepartment() ){
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
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('project/report/department')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id',$auth->department_id)->first();

        $allocation = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('allocation_type' , 2)
                ->get();
        $section = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('allocation_type' , 2)
                ->groupBy('section_id')
                ->get();  

        if($month == 0 && $quater == 0){      

            $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('budget_id' , 1)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 2)
                    ->get();       

            $payment = Payment::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('budget_id' , 1)
                    ->where('payment_category' , 1)
                    ->where('payment_status' , 1)
                    ->get();  
            
           $header = "สำนักงาน" . $department->department_name;                   

        }else{
            if($month != 0 ){

                $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->whereMonth('transfer_date' , $month)
                        ->get();       

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->whereMonth('payment_date' , $month)
                        ->get(); 
                
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;                           
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ;
                if ($quater == 1){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                            })
                            ->get();  
                }
                if ($quater == 2){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                            })
                            ->get();                 
                }
                if ($quater == 3){                     
                        $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                            })
                            ->get();                   
                }
                if ($quater == 4){
                        $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                        })
                        ->get();       

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                        })
                        ->get();                                           
                }
            }
        }

        $pdf->loadView("project.report.department.pdfpayment" , [
            'transfer' => $transfer ,
            'payment' => $payment , 
            'allocation' => $allocation , 
            'section' => $section, 
            'setting' => $setting, 
            'setyear' => $setyear, 
            'header' =>  $header 
            ])->setPaper('a4', 'landscape');
        return $pdf->download('paymentreport.pdf');   
    }  

    public function ExportExcel($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('project/report/department')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id',$auth->department_id)->first();

        $allocation = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('allocation_type' , 2)
                ->get();
        $section = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('allocation_type' , 2)
                ->groupBy('section_id')
                ->get(); 
                   
        if($month == 0 && $quater == 0){      
                $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->get();       

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->get();  
        }else{
            if($month != 0 ){
                $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->whereMonth('transfer_date' , $month)
                        ->get();       

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
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
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                            })
                            ->get();  
                }
                if ($quater == 2){  
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                            })
                            ->get();  
                }
                if ($quater == 3){  
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                            })
                            ->get();  
                }
                if ($quater == 4){  
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                            })
                            ->get();       

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                            })
                            ->get();   
                }
            }
         
        }

        $summary_array[] = array('สำนักงาน','รับโอน(ครั้ง)','งบประมาณจัดสรร','โอนไปแล้ว','เบิกจ่ายจริง','คงเหลือ','ร้อยละเบิกจ่าย'); 
        if(count($allocation) > 0){
            foreach( $allocation as $item ){
                $numtransfer = $transfer->where('section_id',$item->section_id)->count();
                $totaltransfer = $transfer->where('section_id',$item->section_id)->count();
                $sumpayment = $payment->where('section_id',$item->section_id)->sum('payment_salary');
                if($item->transferallocation != 0 ){
                    $percent=number_format( ( $sumpayment / $item->transferallocation )* 100 , 2 );
                }else{
                    $percent=0;
                }

                $summary_array[] = array(
                    'section' => $item->section_name ,
                    'numtransfer' => $numtransfer,
                    'allocation' => number_format( $item->allocation_price , 2 )  ,
                    'transferred' =>  number_format( $totaltransfer, 2 ) ,
                    'payment' =>  number_format( $sumpayment , 2 )  ,
                    'remain' => number_format( ($item->transferallocation - $sumpayment) , 2 )  ,
                    'percent' => $percent ,
                );
            }    
        }
        $excelfile = Excel::create("paymentreport", function($excel) use ($summary_array){
            $excel->setTitle("รายการผลการเบิกจ่าย");
            $excel->sheet('รายการผลการเบิกจ่าย', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  

    }


    public function ExportWord($month,$quater,$setyear){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('project/report/department')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id',$auth->department_id)->first();

        $allocation = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('allocation_type' , 2)
                ->get();
        $section = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('allocation_type' , 2)
                ->groupBy('section_id')
                ->get();    

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานรายงานผลการเบิกจ่าย','headerStyle', 'pStyle');

        $styleTable = array('borderSize' => 1, 'borderColor' => '000000',  'width' =>100 , 'cellMargin' => 0);
        $styleFirstRow = array('borderBottomSize' => 15, 'borderBottomColor' => '000000' );
        $styleCell = array('valign' => 'center');
        $styleCell2 = array('valign' => 'bottom');
        $styleCell3 = array('gridSpan' => 2);
        $rowstyle = array('exactHeight' => '100', 'gridSpan' => 500);
        $fontStyle = array('bold' => true, 'align' => 'center');
        $phpWord->addTableStyle('Allocation', $styleTable, $styleFirstRow);        
        
        if($month == 0 && $quater == 0){ 
            $header = "สำนักงาน" . $department->department_name;
            $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('budget_id' , 1)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 2)
                    ->get();       

            $payment = Payment::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('budget_id' , 1)
                    ->where('payment_category' , 1)
                    ->where('payment_status' , 1)
                    ->get();  
             
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;    
                $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->whereMonth('transfer_date' , $month)
                        ->get();       

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->whereMonth('payment_date' , $month)
                        ->get(); 
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ; 
                if ($quater == 1){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',12); });
                            })
                            ->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                            })
                            ->get();
                } 
                if ($quater == 2){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',3); });
                            })
                            ->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                            })
                            ->get();
                } 
                if ($quater == 3){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',6); });
                            })
                            ->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                            })
                            ->get();
                } 
                if ($quater == 4){
                    $transfer = Transfer::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('transfer_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('transfer_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('transfer_date',9); });
                            })
                            ->get();

                    $payment = Payment::where('project_id' , $project->project_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                            })
                            ->get();
                } 
       
 
            }
        
        }

        $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
        $section->addText($header,'headerStyle', 'pStyle');
        $table = $section->addTable('Allocation');
        $table->addRow(50);
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สังกัดกรม'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('รับโอน(ครั้ง)'), 'headerStyle','pStyle');
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('งบประมาณจัดสรร'), 'headerStyle','pStyle');
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('โอนไปแล้ว'), 'headerStyle','pStyle');           
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายจริง'), 'headerStyle','pStyle');  
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('คงเหลือ'), 'headerStyle','pStyle');  
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละเบิกจ่าย'), 'headerStyle','pStyle');  
               
        if(count($allocation) > 0){
            foreach( $allocation as $item ){
                $numtransfer = $transfer->where('section_id',$item->section_id)->count();
                $totaltransfer = $transfer->where('section_id',$item->section_id)->count();
                $sumpayment = $payment->where('section_id',$item->section_id)->sum('payment_salary');
                if($item->transferallocation != 0 ){
                    $percent=number_format( ( $sumpayment / $item->transferallocation )* 100 , 2 );
                }else{
                    $percent=0;
                }

                $table->addRow(10);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name  ),'bodyStyle','pStyle2');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numtransfer),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( $item->allocation_price , 2 )),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( $totaltransfer, 2 )  ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( $sumpayment , 2 )  ),'bodyStyle','pStyle');           
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( ($item->transferallocation - $sumpayment) , 2 ) ),'bodyStyle','pStyle');           
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $percent  ),'bodyStyle','pStyle');           
            
            }    
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('expensereport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('expensereport.docx'));
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
