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
use App\Model\PersonalAssessment;

class ReportFollowupMainEnoughIncomeController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = Department::get();
        
        if($month == 0 && $quater == 0){
            $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();   
            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        }else{
            if($month != 0 ){
                $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();   
                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
                $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 2){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 3){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 4){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
            }
        }

        return view('report.followup.main.enoughincome.index')->withSetting($setting)
                                ->withQuatername($quatername)
                                ->withMonthname($monthname)
                                ->withQuater($quater)
                                ->withMonth($month)
                                ->withReadiness($readiness)
                                ->withParticipategroup($participategroup)
                                ->withPersonalassessment($personalassessment)
                                ->withDepartment($department);

    }

    public function ExportExcel($month,$quater){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = Department::get();
  
        $summary_array[] = array('หน่วยงาน','จำนวนโครงการ','จำนวนผู้มีอาชีพ','จำนวนผู้มีรายได้เพียงพอ','ร้อยละการมีรายได้เพียงพอ');                   
        if($month == 0 && $quater == 0){      
            $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();   
            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        }else{
            if($month != 0 ){
                $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();   
                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
                $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
            
            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 2){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 3){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 4){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
            }
         
        }

        if(count($readiness) > 0){
            $totalhasoccupation=0;
            $totalenoughincome =0;
            foreach( $department as $item ){
                $num = $readiness->where('department_id', $item->department_id)->count();
                if( $num !=0 ){

                    $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                    $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                    $registers = $participategroup->where('department_id', $item->department_id)->all();
                    $hasoccupation=0;
                    $hasoccupation_enoughincome=0;
                    if (count($registers) !=0 ){
                        foreach($registers as $_item){
                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                    ->where('occupation_id','!=',1)
                                                                    ->first();
                            if(count($registerhasoccupation) != 0 ){
                                $hasoccupation = $hasoccupation + 1;
                                $totalhasoccupation++;
                            }

                            $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                            ->where('occupation_id','!=',1)
                                                                            ->where('enoughincome_id',2)
                                                                            ->first();
                            if(count($registerhasoccupationenoughincome) != 0 ){
                                $hasoccupation_enoughincome++;
                                $totalenoughincome++;
                            }

                        }
                    }
    
                    if($hasoccupation !=0 ){
                        $percent =  number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
                    }else{
                        $percent = 0;
                    }
                   
                    $summary_array[] = array(
                        'departmentname' => $item->department_name ,
                        'num' => $num,
                        'hasoccupation' => $hasoccupation,
                        'enoughincome' => $hasoccupation_enoughincome ,
                        'percent' =>  $percent ,
                    );
                }
            }    
        }

        $excelfile = Excel::create("followupreport", function($excel) use ($summary_array){
            $excel->setTitle("ติดตามการฝึกอบรมวิชาชีพ");
            $excel->sheet('ติดตามการฝึกอบรมวิชาชีพ', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',true,false);
            });
        })->download('xlsx');    
    }

    public function ExportWord($month,$quater){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = Department::get();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานฝึกอบรมวิชาชีพโครงการคืนคนดีสู่สังคม','headerStyle', 'pStyle');

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
            $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
            $section->addText($header,'headerStyle', 'pStyle');
            $table = $section->addTable('Allocation');
            $table->addRow(50);
            $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');        
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('มีรายได้เพียงพอ'), 'headerStyle','pStyle');  
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละมีรายได้เพียงพอ'), 'headerStyle','pStyle');  
      
            $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();   
            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

               
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header = "เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                  
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');        
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('มีรายได้เพียงพอ'), 'headerStyle','pStyle');  
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละมีรายได้เพียงพอ'), 'headerStyle','pStyle');  
                
                $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();   
                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
                $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

 
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                            
                $header =  $quatername->quater_name ;
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('หน่วยงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');        
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('มีรายได้เพียงพอ'), 'headerStyle','pStyle');  
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละมีรายได้เพียงพอ'), 'headerStyle','pStyle');  
 
                if ($quater == 1){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 2){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 3){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 4){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }

            }
        
        }


        if(count($readiness) > 0){
            $totalhasoccupation=0;
            $totalenoughincome =0;
            foreach( $department as $item ){
                $num = $readiness->where('department_id', $item->department_id)->count();
                if( $num !=0 ){

                    $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                    $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                    $registers = $participategroup->where('department_id', $item->department_id)->all();
                    $hasoccupation=0;
                    $hasoccupation_enoughincome=0;
                    if (count($registers) !=0 ){
                        foreach($registers as $_item){
                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                    ->where('occupation_id','!=',1)
                                                                    ->first();
                            if(count($registerhasoccupation) != 0 ){
                                $hasoccupation = $hasoccupation + 1;
                                $totalhasoccupation++;
                            }

                            $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                            ->where('occupation_id','!=',1)
                                                                            ->where('enoughincome_id',2)
                                                                            ->first();
                            if(count($registerhasoccupationenoughincome) != 0 ){
                                $hasoccupation_enoughincome++;
                                $totalenoughincome++;
                            }

                        }
                    }
    
                    if($hasoccupation !=0 ){
                        $percent =  number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2);
                    }else{
                        $percent = 0;
                    }
                   
                    $table->addRow(10);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $num ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $hasoccupation ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $hasoccupation_enoughincome ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $percent ),'bodyStyle','pStyle');

                }
            }    
        }

        if( count($readiness) > 0 ){
            $num = $readiness->count();
            $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
            $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      

            if ($totalenoughincome !=0 ){
                $percent = number_format( ($totalenoughincome / $totalhasoccupation) * 100 , 2);
            }else{
                $percent=0;
            }   

            $table->addRow(15);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $readiness->count() ),'headerStyle','pStyle');            
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $totalhasoccupation ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $totalenoughincome ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $percent ),'headerStyle','pStyle');
            
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('occupationreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('occupationreport.docx'));
    }

    public function ExportPDF($month,$quater){
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
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $department = Department::get();
        

        $header = "";
        if($month == 0 && $quater == 0){      

            $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();   
            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();
            $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                     
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name . " " . $setting->setting_year ;

                $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();   
                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
                $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;
                if ($quater == 1){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 2){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 3){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }
                if ($quater == 4){ 
                    $readiness = ProjectReadiness::where('project_id' , $project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();   
                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',7); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',8); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',9); });
                                })
                                ->get();
                    $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
                }

            }
         
        }

        $pdf->loadView("report.followup.main.enoughincome.pdfenoughincome" , [ 'readiness' => $readiness , 'participategroup' => $participategroup, 'personalassessment' => $personalassessment,'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
        return $pdf->download('occupation.pdf');    
    }

    public function EnoughIncomeChart(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        return view('report.followup.main.enoughincome.enoughincomechart')->withSetting($setting);
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
