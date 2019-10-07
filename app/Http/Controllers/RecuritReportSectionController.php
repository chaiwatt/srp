<?php namespace App\Http\Controllers;

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

class RecuritReportSectionController extends Controller{

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_category' , 1);
        $q = $q->groupBy('position_id');
        $position = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_category' , 1);
        $employ = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_category' , 1);
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->sum('allocation_price');

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $transfer = $q->sum('transfer_price');

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('payment_category' , 1);
        $q = $q->where('payment_status' , 1);
        $payment = $q->sum('payment_salary');

        $q = Refund::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('refund_type' , 2);
        $refund = $q->sum('refund_price');

        $q = Resign::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('resign_status' , 1);
        $resign = $q->get();

        $positions = Position::where('department_id' , $auth->department_id)->get();

        return view('recurit.report.section.index')->withProject($project)
        ->withEmploy($employ)
        ->withPosition($position)
        ->withGenerate($generate)
        ->withTransfer($transfer)
        ->withPayment($payment)
        ->withAllocation($allocation)
        ->withPositions($positions)
        ->withRefund($refund)
        ->withResign($resign);
    }

    public function Payment(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        if($month == 0 && $quater == 0){
            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where('budget_id' , 1)
                            ->paginate(10);
        }else{
            if($month != 0 ){
                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->whereMonth('payment_date' , $month)
                        ->paginate(10);
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                        })
                        ->paginate(10);
                }
                if ($quater == 2){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                        })
                        ->paginate(10);
                }
                if ($quater == 3){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                        })
                        ->paginate(10);
                }
                if ($quater == 4){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                        })
                        ->paginate(10);
                }
            }
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();

        return view('recurit.report.section.payment')->withProject($project)
                                            ->withMonth($month)
                                            ->withQuater($quater)
                                            ->withQuatername($quatername)
                                            ->withMonthname($monthname)
                                            ->withPayment($payment);
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

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id', $auth->department_id)->first();
        $section = Section::where('section_id', $auth->section_id)->first();

        if($month == 0 && $quater == 0){      

            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where('budget_id' , 1)
                            ->get();

           $header = $section ->section_name ;          

        }else{
            if($month != 0 ){

                $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->whereMonth('payment_date' , $month)
                        ->get();

                $monthname = Month::where('month',$month)->first();                            
                $header =  $section ->section_name . " เดือน " . $monthname->month_name ;
                           
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $section ->section_name . " " . $quatername->quater_name ;
                if ($quater == 1){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                        })
                        ->get();
                }
                if ($quater == 2){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                        })
                        ->get();
                }
                if ($quater == 3){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                        })
                        ->get();
                }
                if ($quater == 4){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                        })
                        ->get();
                }
            }
        }

        $pdf->loadView("recurit.report.section.pdfexpense" , [ 'payment' => $payment , 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
        return $pdf->download('expensereport.pdf');  
    }   

    public function ExportExcel($month,$quater){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id', $auth->department_id)->first();
        $section = Section::where('section_id', $auth->section_id)->first();

        if($month == 0 && $quater == 0){      
            $payment = Payment::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('payment_category' , 1)
                            ->where('payment_status' , 1)
                            ->where('budget_id' , 1)
                            ->get();
                       
        }else{
            if($month != 0 ){
                $payment = Payment::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('section_id' , $auth->section_id)
                ->where('payment_category' , 1)
                ->where('payment_status' , 1)
                ->where('budget_id' , 1)
                ->where(function($query){
                    $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                    $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                    $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                })
                ->get();         

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',10); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',11); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',12); });
                        })
                        ->get();
                }
                if ($quater == 2){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',1); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',2); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',3); });
                        })
                        ->get();
                }
                if ($quater == 3){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',4); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',5); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',6); });
                        })
                        ->get();
                }
                if ($quater == 4){
                    $payment = Payment::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('payment_category' , 1)
                        ->where('payment_status' , 1)
                        ->where('budget_id' , 1)
                        ->where(function($query){
                            $query->orWhere(function($query1){$query1->whereMonth('payment_date',7); });
                            $query->orWhere(function($query2){$query2->whereMonth('payment_date',8); });
                            $query->orWhere(function($query3){$query3->whereMonth('payment_date',9); });
                        })
                        ->get();
                }

            }
        }

        $summary_array[] = array('เดือน','วันที่จ่าย','คำขึ้นต้น','ชื่อ','นามสกุล','ตำแหน่ง','เลขที่บัตรประชาชน','หักขาดเงิน','หักค่าปรับ','ค่าจ้างที่ได้รับ');
        foreach( $payment as $item ){
            $summary_array[] = array(
                'no' => str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT),
                'paymentdate' => $item->paymentdateth ,
                'prefix' => $item->registerprefixname  ,
                'name' => $item->registername,
                'surname' =>  $item->registerlastname  ,
                'position' =>  $item->positionname  ,
                'hid' => $item->registerpersonid,
                'fee' => number_format($item->payment_absence , 2),
                'fine' => number_format($item->payment_fine , 2) ,
                'gross' => number_format($item->payment_salary , 2)
            );
        }

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


