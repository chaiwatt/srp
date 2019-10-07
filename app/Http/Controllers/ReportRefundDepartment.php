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
use App\Model\Refund;
use App\Model\Survey;
use App\Model\TransferTransaction;
use App\Model\Payment;
use App\Model\Quater;
use App\Model\Month;

class ReportRefundDepartment extends Controller
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
        
        if($month == 0 && $quater == 0){
            $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->get();

        }else{
            if($month != 0 ){
                $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->whereMonth('created_at' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }

        return view('report.refund.department.index')->withSectionrefund($sectionrefund)
                                    ->withProject($project)
                                    ->withQuater($quater)
                                    ->withMonth($month)
                                    ->withSetyear($setyear)
                                    ->withSettingyear($settingyear);
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
        if($month == 0 && $quater == 0){                  
           $header = "สำนักงาน" . $department->department_name;   
           $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->get();                

        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;
                $sectionrefund = Refund::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('refund_type' , 2)
                ->whereMonth('created_at' , $month)
                ->get();                           
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ;
                if ($quater == 1){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
    
            }
        }

        $pdf->loadView("report.refund.department.pdfrefund" , [
                'sectionrefund' => $sectionrefund ,
                'project' => $project , 
                'setyear' => $setyear , 
                'settingyear' => $settingyear, 
                'setyear' => $setyear, 
                'header' =>  $header 
            ]);
        return $pdf->download('refundreport.pdf');   
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
        
        if($month == 0 && $quater == 0){
            $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->get();

        }else{
            if($month != 0 ){
                $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->whereMonth('created_at' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }

        $summary_array[] = array('วันที่','สำนักงาน','รายการค่าใช้จ่าย','จำนวนเงินที่คืน'); 

        if( count($sectionrefund) > 0 ){
            foreach( $sectionrefund as $key => $item ){
                $summary_array[] = array(
                    'datecreate' => $item->refunddate ,
                    'section' => $item->sectionname,
                    'budgetname' =>  $item->budgetname,
                    'numrefund' => number_format( $item->refund_price , 2 ),
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
            $header = "สำนักงาน" . $department->department_name;
            $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->get();
             
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name ;    
                $sectionrefund = Refund::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('refund_type' , 2)
                            ->whereMonth('created_at' , $month)
                            ->get();
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ; 
                if ($quater == 1){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $sectionrefund = Refund::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('refund_type' , 2)
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
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('วันที่'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('รายการค่าใช้จ่าย'), 'headerStyle','pStyle');
        $table->addCell(3000, $styleCell)->addText(htmlspecialchars('จำนวนเงินที่คืน'), 'headerStyle','pStyle');           
  

        if( count($sectionrefund) > 0 ){
            foreach( $sectionrefund as $key => $item ){       
                $table->addRow(10);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->refunddate  ),'bodyStyle','pStyle2');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->sectionname ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->budgetname ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( $item->refund_price , 2 )  ),'bodyStyle','pStyle');
                           
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
