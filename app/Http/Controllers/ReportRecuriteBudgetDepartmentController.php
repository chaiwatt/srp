<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use PDF;
use Request;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Generate;
use App\Model\Resign;
use App\Model\Quater;
use App\Model\Month;
use App\Model\Payment;


class ReportRecuriteBudgetDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $section = collect();
        $quatername = collect();
        $monthname = collect();
        $payment = collect();
   
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setyear = Request::input('settingyear')==""?"":Request::input('settingyear');
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/recurit/department/budget')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }
        
        if($month == 0 && $quater == 0){
            $section = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->groupBy('section_id')
                            ->get();      

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->get();               
        }{
            if($month != 0 ){
                $section = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->whereMonth('created_at' , $month)
                                ->groupBy('section_id')
                                ->get();      

                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();    
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                $section = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                })
                                ->groupBy('section_id')                
                                ->get();      

                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                })
                                ->get();
                }
                if ($quater == 2){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();
                }
                if ($quater == 3){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();

                }
                if ($quater == 4){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();                       
                }
            }
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        return view('report.recurit.department.budget.index')->withSection($section)
                                                ->withSetting($setting)
                                                ->withQuatername($quatername)
                                                ->withMonthname($monthname)
                                                ->withSettingyear($settingyear)
                                                ->withSetyear($setyear)
                                                ->withQuater($quater)
                                                ->withMonth($month)
                                                ->withPayment($payment);
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

        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/recurit/department/budget')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id', $auth->department_id)->first();

        if($month == 0 && $quater == 0){      
            $section = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->groupBy('section_id')
                            ->get();      

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->get();  

           $header = "สำนักงาน" . $department->department_name;
           $pdf->loadView("report.recurit.department.budget.pdfbudget" , [ 'payment' => $payment , 'section' => $section, 'setting' => $setting, 'header' =>  $header ]);
           return $pdf->download('budgetreport.pdf');                         

        }else{
            if($month != 0 ){
                $section = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->whereMonth('created_at' , $month)
                                ->groupBy('section_id')
                                ->get();      

                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();  
 
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $pdf->loadView("report.recurit.department.budget.pdfbudget" , [ 'payment' => $payment , 'section' => $section, 'setting' => $setting, 'header' =>  $header ]);
                return $pdf->download('budgetreport.pdf');                             

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $pdf->loadView("report.recurit.department.budget.pdfbudget" , [ 'payment' => $payment , 'section' => $section, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('budgetreport.pdf');                     

                }
                if ($quater == 2){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $quatername = Quater::where('quater_id',$quater)->first();                            
                    $header =  $department->department_name . " " . $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.department.budget.pdfbudget" , [ 'payment' => $payment , 'section' => $section, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('budgetreport.pdf');                   

                }
                if ($quater == 3){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();

                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.department.budget.pdfbudget" , [ 'payment' => $payment , 'section' => $section, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('budgetreport.pdf');                    

                }
                if ($quater == 4){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();  

                    $quatername = Quater::where('quater_id',$quater)->first();                         
                    $header =  $department->department_name . " " . $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.department.budget.pdfbudget" , [ 'payment' => $payment , 'section' => $section, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('budgetreport.pdf');                                            
                }
            }
        }


    }

    public function ExportExcel($month,$quater,$setyear){
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

        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/recurit/department/budget')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $department = Department::where('department_id', $auth->department_id)->first();

        if($month == 0 && $quater == 0){      
            $section = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->groupBy('section_id')
                            ->get();      

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->get();  

                            $summary_array[] = array('หน่วยงาน','เบิกจ่ายเงินเดือน','หักขาดงาน','หักอื่นๆ');

                            foreach( $section as $item ){
                                $paid = $payment->where('section_id' , $item->section_id)
                                                ->sum('payment_salary') ;
                                $absence = $payment->where('section_id' , $item->section_id)
                                                ->sum('payment_absence') ;             
                                $fine = $payment->where('section_id' , $item->section_id)
                                ->sum('payment_fine') ; 

                                $summary_array[] = array(
                                    'section_name' => $item->section_name,
                                    'paid' => $paid,
                                    'absence' => $absence ,
                                    'fine' => $fine
                                );
                            }
                    
                            $excelfile = Excel::create("budgetreport", function($excel) use ($summary_array){
                                $excel->setTitle("การเบิกจ่าย");
                                $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
                                    $sheet->fromArray($summary_array,null,'A1',true,false);
                                });
                            })->download('xlsx');                       

        }else{
            if($month != 0 ){
                $section = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->whereMonth('created_at' , $month)
                                ->groupBy('section_id')
                                ->get();      

                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();  
 
                $summary_array[] = array('หน่วยงาน','เบิกจ่ายเงินเดือน','หักขาดงาน','หักอื่นๆ');

                foreach( $section as $item ){
                    $paid = $payment->where('section_id' , $item->section_id)
                                    ->sum('payment_salary') ;
                    $absence = $payment->where('section_id' , $item->section_id)
                                    ->sum('payment_absence') ;             
                    $fine = $payment->where('section_id' , $item->section_id)
                    ->sum('payment_fine') ; 

                    $summary_array[] = array(
                        'section_name' => $item->section_name,
                        'paid' => $paid,
                        'absence' => $absence ,
                        'fine' => $fine
                    );
                }
        
                $excelfile = Excel::create("budgetreport", function($excel) use ($summary_array){
                    $excel->setTitle("การเบิกจ่าย");
                    $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
                        $sheet->fromArray($summary_array,null,'A1',true,false);
                    });
                })->download('xlsx');                              

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $summary_array[] = array('หน่วยงาน','เบิกจ่ายเงินเดือน','หักขาดงาน','หักอื่นๆ');

                    foreach( $section as $item ){
                        $paid = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_salary') ;
                        $absence = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_absence') ;             
                        $fine = $payment->where('section_id' , $item->section_id)
                        ->sum('payment_fine') ; 

                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'paid' => $paid,
                            'absence' => $absence ,
                            'fine' => $fine
                        );
                    }
            
                    $excelfile = Excel::create("budgetreport", function($excel) use ($summary_array){
                        $excel->setTitle("การเบิกจ่าย");
                        $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                    })->download('xlsx');                   

                }
                if ($quater == 2){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $summary_array[] = array('หน่วยงาน','เบิกจ่ายเงินเดือน','หักขาดงาน','หักอื่นๆ');

                    foreach( $section as $item ){
                        $paid = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_salary') ;
                        $absence = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_absence') ;             
                        $fine = $payment->where('section_id' , $item->section_id)
                        ->sum('payment_fine') ; 
    
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'paid' => $paid,
                            'absence' => $absence ,
                            'fine' => $fine
                        );
                    }
            
                    $excelfile = Excel::create("budgetreport", function($excel) use ($summary_array){
                        $excel->setTitle("การเบิกจ่าย");
                        $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                    })->download('xlsx');                   

                }
                if ($quater == 3){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();

                    $summary_array[] = array('หน่วยงาน','เบิกจ่ายเงินเดือน','หักขาดงาน','หักอื่นๆ');

                    foreach( $section as $item ){
                        $paid = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_salary') ;
                        $absence = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_absence') ;             
                        $fine = $payment->where('section_id' , $item->section_id)
                        ->sum('payment_fine') ; 
    
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'paid' => $paid,
                            'absence' => $absence ,
                            'fine' => $fine
                        );
                    }
            
                    $excelfile = Excel::create("budgetreport", function($excel) use ($summary_array){
                        $excel->setTitle("การเบิกจ่าย");
                        $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                    })->download('xlsx');                     

                }
                if ($quater == 4){
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();  

                    $summary_array[] = array('หน่วยงาน','เบิกจ่ายเงินเดือน','หักขาดงาน','หักอื่นๆ');

                    foreach( $section as $item ){
                        $paid = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_salary') ;
                        $absence = $payment->where('section_id' , $item->section_id)
                                        ->sum('payment_absence') ;             
                        $fine = $payment->where('section_id' , $item->section_id)
                        ->sum('payment_fine') ; 
    
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'paid' => $paid,
                            'absence' => $absence ,
                            'fine' => $fine
                        );
                    }
            
                    $excelfile = Excel::create("budgetreport", function($excel) use ($summary_array){
                        $excel->setTitle("การเบิกจ่าย");
                        $excel->sheet('การเบิกจ่าย', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                    })->download('xlsx');                                             
                }
            }
        }
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
                return redirect('report/recurit/department/budget')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }
        $department = Department::where('department_id', $auth->department_id)->first();
 
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานผลการเบิกจ่ายโครงการคืนคนดีสู่สังคม','headerStyle', 'pStyle');

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
            $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
            $section->addText($header,'headerStyle', 'pStyle');
            $table = $section->addTable('Allocation');
            $table->addRow(50);
            $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายเงินเดือน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักขาดงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักอื่นๆ'), 'headerStyle','pStyle');           
            
            $section = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->groupBy('section_id')
                            ->get();      

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('budget_id' , 1)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->get();  

            foreach( $section as $key => $item ){

                $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary');
                $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence');
                $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') ;
        
                $table->addRow(10);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $paid ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $absence ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $fine ),'bodyStyle','pStyle');
            }   
            
            $table->addRow(15);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_salary') ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_absence') ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_fine') ),'headerStyle','pStyle');

        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายเงินเดือน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักขาดงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักอื่นๆ'), 'headerStyle','pStyle');           
         
                $section = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->whereMonth('created_at' , $month)
                                ->groupBy('section_id')
                                ->get();      

                $payment = Payment::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('budget_id' , 1)
                                ->where('payment_category' , 1)
                                ->where('payment_status' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();  

                foreach( $section as $key => $item ){
                    $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary');
                    $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence');
                    $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') ;
            
                    $table->addRow(10);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $paid ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $absence ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $fine ),'bodyStyle','pStyle');
                }   
                
                $table->addRow(15);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_salary') ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_absence') ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_fine') ),'headerStyle','pStyle');
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายเงินเดือน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักขาดงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักอื่นๆ'), 'headerStyle','pStyle');           
                                 
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get(); 
                    foreach( $section as $key => $item ){
                        $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary');
                        $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence');
                        $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') ;
                
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $paid ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $absence ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $fine ),'bodyStyle','pStyle');
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_salary') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_absence') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_fine') ),'headerStyle','pStyle');                                                             
                }
                if ($quater == 2){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายเงินเดือน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักขาดงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักอื่นๆ'), 'headerStyle','pStyle');           
                                        
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      

                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();                
                    foreach( $section as $key => $item ){
                        $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary');
                        $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence');
                        $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') ;
                
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $paid ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $absence ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $fine ),'bodyStyle','pStyle');
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_salary') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_absence') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_fine') ),'headerStyle','pStyle');            
                
                }
                if ($quater == 3){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายเงินเดือน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักขาดงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักอื่นๆ'), 'headerStyle','pStyle');           
                                        
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();   
                                                   
                    foreach( $section as $key => $item ){
                        $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary');
                        $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence');
                        $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') ;
                
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $paid ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $absence ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $fine ),'bodyStyle','pStyle');
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_salary') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_absence') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_fine') ),'headerStyle','pStyle');            
              
                }
                if ($quater == 4){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เบิกจ่ายเงินเดือน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักขาดงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('หักอื่นๆ'), 'headerStyle','pStyle');           
                                        
                    $section = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->groupBy('section_id')                
                                    ->get();      
    
                    $payment = Payment::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('budget_id' , 1)
                                    ->where('payment_category' , 1)
                                    ->where('payment_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get(); 
                    foreach( $section as $key => $item ){
                        $paid = $payment->where('section_id' , $item->section_id)->sum('payment_salary');
                        $absence = $payment->where('section_id' , $item->section_id)->sum('payment_absence');
                        $fine = $payment->where('section_id' , $item->section_id)->sum('payment_fine') ;
                
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $paid ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $absence ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $fine ),'bodyStyle','pStyle');
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_salary') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_absence') ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $payment->sum('payment_fine') ),'headerStyle','pStyle');                                                                                  
                }
            }
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('allocationreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('allocationreport.docx'));
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
