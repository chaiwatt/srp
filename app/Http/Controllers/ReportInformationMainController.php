<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use PDF;
use Excel;
use Word;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\InformationExpense;
use App\Model\Department;
use App\Model\Transfer;
use App\Model\DepartmentAllocation;
use App\Model\Refund;
use App\Model\Quater;
use App\Model\Month;

class ReportInformationMainController extends Controller
{
    public function Index(){
    	if( $this->authsuperadmint() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setyear = Request::input('settingyear')==""?"":Request::input('settingyear');

        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();        
        $department = Department::get();
        
        if($month == 0 && $quater == 0){
            $expense = InformationExpense::where('project_id' , $project->project_id)
                        ->get();
        }else{
            if($month != 0 ){
                $expense = InformationExpense::where('project_id' , $project->project_id)
                ->whereMonth('created_at' , $month)
                ->get();
            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }

        return view('report.information.main.index')
                            ->withDepartment($department)
                            ->withSettingyear($settingyear)
                            ->withExpense($expense)
                            ->withSetyear($setyear)
                            ->withQuater($quater)
                            ->withMonth($month)
                            ->withProject($project);
    }

    public function ExportPDF($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true , 
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ]);

        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();        
        $department = Department::get(); 

        if($month == 0 && $quater == 0){      
           $header = "";
           $expense = InformationExpense::where('project_id' , $project->project_id)
           ->get();
                                
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header = " เดือน " . $monthname->month_name ;
                
                $expense = InformationExpense::where('project_id' , $project->project_id)
                ->whereMonth('created_at' , $month)
                ->get();
                                                        
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;

                if ($quater == 1){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }

            }
        }
        
        $pdf->loadView("report.information.main.pdfinformation" , [ 
                        'settingyear' => $settingyear , 
                        'expense' => $expense , 
                        'setyear' => $setyear , 
                        'project' => $project, 
                        'setting' => $setting, 
                        'header' =>  $header 
            ]);
        return $pdf->download('pdfinformation.pdf');   

    } 

    
    public function ExportExcel($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();        
        $department = Department::where('department_id' , $auth->department_id)->first();
        
        if($month == 0 && $quater == 0){
            $expense = InformationExpense::where('project_id' , $project->project_id)
                        ->get();
        }else{
            if($month != 0 ){
                $expense = InformationExpense::where('project_id' , $project->project_id)
                ->whereMonth('created_at' , $month)
                ->get();
            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }
            }
        }

            $summary_array[] = array('หน่วยงาน','ประเภทสื่อ','จำนวนที่จัดทำ','จำนวนที่ใช้เงิน','ผู้รับจ้าง');
            foreach( $expense as $item ){
                $summary_array[] = array(    
                    'dept' =>  $item->departmentname ,                
                    'doctype' =>  $item->expense_type ,
                    'quantity' => $item->expense_amount ,
                    'expense' => number_format($item->expense_price,2) ,
                    'vendor' =>  $item->expense_outsource 
                );
            }

            $excelfile = Excel::create("information", function($excel) use ($summary_array){
                $excel->setTitle("การประชาสัมพันธ์");
                $excel->sheet('การประชาสัมพันธ์', function($sheet) use ($summary_array){
                    $sheet->fromArray($summary_array,null,'A1',true,false);
                });
            })->download('xlsx'); 
    }

    public function ExportWord($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $settingyear = SettingYear::get();
        $setting = SettingYear::where('setting_status' , 1)->first();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect()->back()->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();        

        $builder = "";
        $department = Department::get();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานผลการจัดทำการประชาสัมพันธ์','headerStyle', 'pStyle');

        $styleTable = array('borderSize' => 1, 'borderColor' => '000000',  'width' =>100 , 'cellMargin' => 0);
        $styleFirstRow = array('borderBottomSize' => 15, 'borderBottomColor' => '000000' );
        $styleCell = array('valign' => 'center');
        $styleCell2 = array('valign' => 'bottom');
        $styleCell3 = array('gridSpan' => 2);
        $rowstyle = array('exactHeight' => '100', 'gridSpan' => 500);
        $fontStyle = array('bold' => true, 'align' => 'center');
        $row3span = array('gridSpan' => 3);
        $phpWord->addTableStyle('Allocation', $styleTable, $styleFirstRow);       

        if($month == 0 && $quater == 0){   
            $header = "";
            $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
            $section->addText($header,'headerStyle', 'pStyle');
            $table = $section->addTable('Allocation');
            $table->addRow(50);
            $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ประเภทสื่อ'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนที่จัดทำ'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนที่ใช้เงิน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ผู้รับจ้าง'), 'headerStyle','pStyle');        
             
            $expense = InformationExpense::where('project_id' , $project->project_id)->get();

        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name ;                
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ประเภทสื่อ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนที่จัดทำ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนที่ใช้เงิน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ผู้รับจ้าง'), 'headerStyle','pStyle');        
                
                $expense = InformationExpense::where('project_id' , $project->project_id)
                ->whereMonth('created_at' , $month)
                ->get();
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ; 
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setyear ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ประเภทสื่อ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนที่จัดทำ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนที่ใช้เงิน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ผู้รับจ้าง'), 'headerStyle','pStyle');        
                
                if ($quater == 1){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                    })
                    ->get();
                }
                if ($quater == 2){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                    })
                    ->get();
                }
                if ($quater == 3){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                    })
                    ->get();
                }
                if ($quater == 4){
                    $expense = InformationExpense::where('project_id' , $project->project_id)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                    })
                    ->get();
                }                       
        }

        }

        foreach( $expense as $item ){
            $table->addRow(10);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->departmentname ),'bodyStyle','pStyle2');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->expense_type ),'bodyStyle','pStyle2');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->expense_amount ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format($item->expense_price,2) ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $item->expense_outsource  ),'bodyStyle','pStyle');
        }

        // $percent  =$percent  / ($key+1);
        // $table->addRow(15);
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numproject ),'headerStyle','pStyle');
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $actualparticipate ),'headerStyle','pStyle');        
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $hasoccupation ),'headerStyle','pStyle');        
        // $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( number_format( ($percent) , 2) ),'headerStyle','pStyle');            


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('information.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('information.docx'));
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
