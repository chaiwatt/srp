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

class RecuritReportSectionCancelController extends Controller
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
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();

        if($month == 0 && $quater == 0){  
            $resign = Resign::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('resign_category' , 1)
                    ->where('resign_status' , 1)
                    ->where('resign_type' , 2)
                    ->get();

            $reason = Resign::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('resign_category' , 1)
                    ->where('resign_status' , 1)
                    ->where('resign_type' , 2)
                    ->select('*', DB::raw('count(*) as total'))
                    ->groupBy('reason_id')
                    ->get();
        }else{
            if($month != 0 ){
                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('resign_category' , 1)
                        ->where('resign_status' , 1)
                        ->where('resign_type' , 2)
                        ->whereMonth('resign_date' , $month)
                        ->get();

                $reason = Resign::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('resign_category' , 1)
                        ->where('resign_status' , 1)
                        ->where('resign_type' , 2)
                        ->whereMonth('resign_date' , $month)
                        ->select('*', DB::raw('count(*) as total'))
                        ->groupBy('reason_id')
                        ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',12); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',12); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
                if ($quater == 2){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',3); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',3); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
                if ($quater == 3){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',6); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',6); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
                if ($quater == 4){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',9); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',9); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
            }
        }

        return view('recurit.report.section.cancel.index')->withProject($project)
                    ->withQuatername($quatername)
                    ->withMonthname($monthname)
                    ->withQuater($quater)
                    ->withMonth($month)
                    ->withReason($reason)
                    ->withResign($resign);
    }

    public function ExportPDF($month,$quater){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $section = Section::where('section_id',$auth->section_id)->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        if($month == 0 && $quater == 0){      
            $resign = Resign::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('resign_category' , 1)
                    ->where('resign_status' , 1)
                    ->where('resign_type' , 2)
                    ->get();

            $reason = Resign::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('resign_category' , 1)
                    ->where('resign_status' , 1)
                    ->where('resign_type' , 2)
                    ->select('*', DB::raw('count(*) as total'))
                    ->groupBy('reason_id')
                    ->get();
            
           $header = $section->section_name;             

        }else{
            if($month != 0 ){

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('resign_category' , 1)
                        ->where('resign_status' , 1)
                        ->where('resign_type' , 2)
                        ->whereMonth('resign_date' , $month)
                        ->get();

                $reason = Resign::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('resign_category' , 1)
                        ->where('resign_status' , 1)
                        ->where('resign_type' , 2)
                        ->whereMonth('resign_date' , $month)
                        ->select('*', DB::raw('count(*) as total'))
                        ->groupBy('reason_id')
                        ->get();
                
                $monthname = Month::where('month',$month)->first();                            
                $header =  $section->section_name . " เดือน " . $monthname->month_name ;                           
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $section->section_name . " " . $quatername->quater_name ;
                if ($quater == 1){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',12); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',12); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
                if ($quater == 2){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',3); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',3); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
                if ($quater == 3){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',6); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',6); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }
                if ($quater == 4){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',9); });
                            })
                            ->get();

                    $reason = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',9); });
                            })
                            ->select('*', DB::raw('count(*) as total'))
                            ->groupBy('reason_id')
                            ->get();
                }

            }
        }

        $pdf->loadView("recurit.report.section.cancel.pdfcancel" , [ 'resign' => $resign , 'reason' => $reason, 'setting' => $setting, 'header' =>  $header ]);
        return $pdf->download('cancelreport.pdf');   
    }  

    public function ExportExcel($month,$quater){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $section = Section::where('section_id',$auth->section_id)->first();
                   
        if($month == 0 && $quater == 0){      

            $resign = Resign::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('resign_category' , 1)
                    ->where('resign_status' , 1)
                    ->where('resign_type' , 2)
                    ->get();

        }else{
            if($month != 0 ){

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , $auth->section_id)
                        ->where('resign_category' , 1)
                        ->where('resign_status' , 1)
                        ->where('resign_type' , 2)
                        ->whereMonth('resign_date' , $month)
                        ->get();

            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',12); });
                            })
                            ->get();
                }
                if ($quater == 2){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',3); });
                            })
                            ->get();
                }
                if ($quater == 3){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',6); });
                            })
                            ->get();
                }
                if ($quater == 4){
                    $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , $auth->section_id)
                            ->where('resign_category' , 1)
                            ->where('resign_status' , 1)
                            ->where('resign_type' , 2)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('resign_date',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('resign_date',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('resign_date',9); });
                            })
                            ->get();
                }
            }
         
        }

        $summary_array[] = array('รหัสตำแหน่ง','คำนำหน้า','ชื่อ','นามสกุล','ตำแหน่งที่สมัคร','วันที่ยกเลิกจ้างงาน','เหตุผล'); 
        if(count($resign) > 0){
            foreach( $resign as $item ){
                $summary_array[] = array(
                    'generatecode' => $item->generate_code  ,
                    'prefix' => $item->registerprefixname ,
                    'name' => $item->registername ,
                    'lastname' => $item->registerlastname ,
                    'position' =>  $item->positionname ,
                    'dateresign' =>  $item->resigndateth  ,
                    'reason' =>  $item->reasonname  ,
                );
            }    
        }

        $excelfile = Excel::create("cancelreport", function($excel) use ($summary_array){
            $excel->setTitle("รายการยกเลิกจ้างงาน");
            $excel->sheet('รายการยกเลิกจ้างงาน', function($sheet) use ($summary_array){
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