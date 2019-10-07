<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use Excel;
use PDF;
use DB;

use App\Model\Quater;
use App\Model\Month;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\SettingDepartment;
use App\Model\ProjectReadiness;
use App\Model\ParticipateGroup;
use App\Model\Department;
use App\Model\ReadinessSection;
use App\Model\ProjectParticipate;

class ReportOccupationMainController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
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
                return redirect('report/occupation/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
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
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();   

        if($month == 0 && $quater == 0){
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();  
        }else{
            if($month != 0 ){
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('projectdate' , $month)
                                ->get();  
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();             
                }
            }
        }

        return view('report.occupation.main.index')->withSetting($setting)
                        ->withQuatername($quatername)
                        ->withMonthname($monthname)
                        ->withQuater($quater)
                        ->withMonth($month)
                        ->withReadiness($readiness)
                        ->withReadinesssection($readinesssection)
                        ->withSettingyear($settingyear)                        
                        ->withSetyear($setyear)      
                        ->withParticipate($participate)
                        ->withDepartment($department);
    }

    public function ExportExcel($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/occupation/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();   

        $summary_array[] = array('หน่วยงาน','จำนวนโครงการ','เป้าหมายเข้าร่วม','เข้าร่วมจริง','ร้อยละเข้าร่วม','งบประมาณใช้จริง');  
  
        if($month == 0 && $quater == 0){      
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();       

        }else{
            if($month != 0 ){
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('projectdate' , $month)
                                ->get();  
            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();             
                }
            }
         
        }

            foreach( $department as $item ){
                $_target = 0;
                $actualparticipate = 0;
                $sum  = 0;
                $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            
                   foreach($_readinesssection as $sec){
                       $_target = $_target + $readiness->where('project_id', $sec->project_id)->first()->targetparticipate;                       
                       $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                       $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                   }
               if($_target!=0){
                   $percent = number_format( ($actualparticipate/ $_target) * 100 , 2);
               }else{
                   $percent=0;
               }   

                $summary_array[] = array(
                    'departmentname' =>  $item->departmentname  ,
                    'num' => $_readinesssection->count(),
                    'target' => $_target  ,
                    'participate' =>  $actualparticipate,
                    'percent' =>  $percent ,
                    'actualexpense' =>  $sum ,
                );
            }    

        $excelfile = Excel::create("occupationreport", function($excel) use ($summary_array){
            $excel->setTitle("การฝึกอบรมวิชาชีพ");
            $excel->sheet('การฝึกอบรมวิชาชีพ', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');    
    }

    public function ExportWord($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        if($setyear != ""){
            if(Project::where('year_budget' , $setyear)->get()->count() == 0){
                return redirect('report/occupation/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();          

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานฝึกอบรมเตรียมความพร้อมโครงการคืนคนดีสู่สังคม','headerStyle', 'pStyle');

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
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();                
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header = "เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                  
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('projectdate' , $month)
                                ->get(); 
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                            
                $header =  $quatername->quater_name ;
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
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
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('โครงการ'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จำนวนหน่วยงาน'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('เป้าหมายเข้าร่วม'), 'headerStyle','pStyle');           
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('เข้าร่วมจริง'), 'headerStyle','pStyle');  
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('งบประมาณใช้จริง'), 'headerStyle','pStyle');  
        

        foreach( $department as $key => $item ){
            $_target = 0;
            $actualparticipate = 0;
            $sum  = 0;
            $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            
               foreach($_readinesssection as $sec){
                   $_target = $_target + $readiness->where('project_id', $sec->project_id)->first()->targetparticipate;                   
                   $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num');                   
                   $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                }
           if($_target!=0){
               $percent = number_format( ($actualparticipate/ $_target) * 100 , 2);
           }else{
               $percent=0;
           }

            $table->addRow(10);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->departmentname ),'bodyStyle','pStyle2');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $_readinesssection->count()),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $_target ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $actualparticipate ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $percent ),'bodyStyle','pStyle');           
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $sum  ),'bodyStyle','pStyle');           
        }         

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('readinessreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('readinessreport.docx'));
    }    

    public function ExportPDF($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
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
                return redirect('report/occupation/main')->withError("ไม่พบข้อมูลจากปีงบประมาณ " .  $setyear);
            }
            $project = Project::where('year_budget' , $setyear)->first();
        }else{
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $setyear = $setting->setting_year;
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get();  

        if($month == 0 && $quater == 0){      
            $header =  "" ;
            $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->get();  
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->get();                          
            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->get(); 
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->groupBy('project_readiness_id')
                                ->whereMonth('helddate' , $month)
                                ->get();  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('helddate' , $month)
                                ->get();                          
                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->whereMonth('projectdate' , $month)
                                ->get(); 
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;
                if ($quater == 1){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',12); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',3); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                    })
                                    ->get(); 
                }
                if ($quater == 3){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',6); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                    })
                                    ->get(); 
                }
                if ($quater == 4){
                    $projectreadiness = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->groupBy('project_readiness_id')
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();  
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('helddate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('helddate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('helddate',9); });
                                    })
                                    ->get();                          
                    $participate = ProjectParticipate::where('project_id' , $project->project_id)
                                    ->where('project_type',2)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                    })
                                    ->get();             
                }
            }
         
        }

        $pdf->loadView("report.occupation.main.pdfoccupation" , [ 
                            'readiness' => $readiness , 
                            'readinesssection' => $readinesssection, 
                            'projectreadiness' => $projectreadiness, 
                            'setyear' => $setyear, 
                            'setting' => $setting, 
                            'participate' => $participate, 
                            'department' => $department, 
                            'header' =>  $header 
                            ]);
        return $pdf->download('occupation.pdf');    
    }
    public function OccupationChart(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();

        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $setyear = $setting->setting_year;

       return view('report.occupation.main.occupationchart')->withSetyear($setyear);

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
