<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;
use Excel;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\AllocationWaiting;
use App\Model\Quater;
use App\Model\Month;
use App\Model\Department;

class ReportRefundMainController extends Controller
{
    public function Index(){
        if( $this->authsuperadmin() ){
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
                return redirect('report/refund/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }

        if($month == 0 && $quater == 0){
            $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                            ->get();
        }else{
            if($month != 0 ){
                $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                            ->whereMonth('created_at' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }

        }
        return view('report.refund.main.index')->withAllrefund($allrefund)
                                                ->withQuater($quater)
                                                ->withMonth($month)
                                                ->withSetyear($setyear)
                                                ->withSettingyear($settingyear)
                                                ->withProject($project);
    }

    public function ExportPDF($month,$quater,$setyear){
        if( $this->authsuperadmin() ){
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
                return redirect('report/refund/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        if($month == 0 && $quater == 0){                  
           $header = "" ;   
           $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
           ->get();               

        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name ;
                $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                            ->whereMonth('created_at' , $month)
                            ->get();

            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;
                if ($quater == 1){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
    
            }
        }

        $pdf->loadView("report.refund.main.pdfrefund" , [
                'allrefund' => $allrefund ,
                'project' => $project , 
                'quater' => $quater , 
                'month' => $month , 
                'settingyear' => $settingyear, 
                'setyear' => $setyear, 
                'header' =>  $header 
            ]);
        return $pdf->download('refundreport.pdf');   
    } 
    
    public function ExportExcel($month,$quater,$setyear){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/refund/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        if($month == 0 && $quater == 0){
            $allrefund = AllocationWaiting::where('project_id' , $project->project_id)->get();
        }else{
            if($month != 0 ){
                $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                            ->whereMonth('created_at' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }



        $summary_array[] = array('วันที่คืน','หน่วยงาน','รายการค่าใช้จ่าย','จำนวนเงินที่คืน','สถานะ'); 

        if( count($allrefund) > 0 ){
            foreach( $allrefund as $key => $item ){
                $refundstatus = 'ยืนยันแล้ว';
                if( $item->waiting_status != 1){
                    $refundstatus = 'รอการยืนยัน';
                }

                $summary_array[] = array(
                    'datecreate' => $item->refunddate ,
                    'dept' => $item->departmentname,
                    'budgetname' =>  $item->budgetname,
                    'numrefund' => number_format( $item->waiting_price_view , 2 ),
                    'status' => $refundstatus,
                );                         
            }
        }

        $excelfile = Excel::create("refundreport", function($excel) use ($summary_array){
            $excel->setTitle("รายการคืนเงิน");
            $excel->sheet('รายการคืนเงิน', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');  

    }  

    public function ExportWord($month,$quater,$setyear){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/refund/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานการคืนเงิน','headerStyle', 'pStyle');

        $styleTable = array('borderSize' => 1, 'borderColor' => '000000',  'width' =>100 , 'cellMargin' => 0);
        $styleFirstRow = array('borderBottomSize' => 15, 'borderBottomColor' => '000000' );
        $styleCell = array('valign' => 'center');
        $styleCell2 = array('valign' => 'bottom');
        $styleCell3 = array('gridSpan' => 2);
        $rowstyle = array('exactHeight' => '100', 'gridSpan' => 500);
        $fontStyle = array('bold' => true, 'align' => 'center');
        $phpWord->addTableStyle('Allocation', $styleTable, $styleFirstRow);        
        
        if($month == 0 && $quater == 0){ 
            $header = "";
            $allrefund = AllocationWaiting::where('project_id' , $project->project_id)->get();
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name ;    
                $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                            ->whereMonth('created_at' , $month)
                            ->get();
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ; 
                if ($quater == 1){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }  
        }

        $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
        $section->addText($header,'headerStyle', 'pStyle');
        $table = $section->addTable('Allocation');
        $table->addRow(50);
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('วันที่คืน'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('รายการค่าใช้จ่าย'), 'headerStyle','pStyle');
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('จำนวนเงินที่คืน'), 'headerStyle','pStyle');           
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('สถานะ'), 'headerStyle','pStyle');           

        if( count($allrefund) > 0 ){
            foreach( $allrefund as $key => $item ){
                $refundstatus = 'ยืนยันแล้ว';
                if( $item->waiting_status != 1){
                    $refundstatus = 'รอการยืนยัน';
                }  
                
                $table->addRow(10);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->refunddate  ),'bodyStyle','pStyle2');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->departmentname ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->budgetname ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( $item->waiting_price_view , 2 )  ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $refundstatus ),'bodyStyle','pStyle');
               
            }
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('refundreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('refundreport.docx'));
    } 
    public function authsuperadmin(){
        $auth = Auth::user();
        if( $auth->permission != 1 ){
             return true;
        }
        else{
            return false;
        }
    }
}
