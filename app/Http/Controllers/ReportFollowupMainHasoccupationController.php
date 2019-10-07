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
use App\Model\Province;
use App\Model\Section;
use App\Model\ReadinessSection;
use App\Model\ProjectParticipate;


class ReportFollowupMainHasoccupationController extends Controller
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
        $province = Province::all();

        $occupationarray = array();
        $sectionarray = array();
        $department = Department::get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();

        if($month == 0 && $quater == 0){            
           
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                        ->where('status',1)
                        ->where('project_type',2)
                        ->get();

            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();  

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();

        }else{
            if($month != 0 ){
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                            ->where('status',1)
                            ->where('project_type',2)
                            ->whereMonth('helddate' , $month)
                            ->get();

                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();  

                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                }
                if ($quater == 2){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                }
                if ($quater == 3){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                }
                if ($quater == 4){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
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


        return view('report.followup.main.hasoccupation.index')->withSetting($setting)
                                                ->withQuatername($quatername)
                                                ->withMonthname($monthname)
                                                ->withSettingyear($settingyear)
                                                ->withSetyear($setyear)
                                                ->withQuater($quater)
                                                ->withDepartment($department)
                                                ->withParticipate($participate)
                                                ->withParticipategroup($participategroup)
                                                ->withPersonalassessment($personalassessment)
                                                ->withReadinesssection($readinesssection)                                                
                                                ->withMonth($month);
    }
    public function ExportExcel($month,$quater,$setyear){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();
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
        $province = Province::all();

        $occupationarray = array();
        $sectionarray = array();
        $department = Department::get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();
 

        $summary_array[] = array('สังกัดกรม','จำนวนโครงการ','จำนวนหน่วยงานที่จัด','จำนวนผู้เข้าร่วม','จำนวนผู้มีอาชีพ','ร้อยละการมีอาชีพ');  
  
        if($month == 0 && $quater == 0){          
           
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                        ->where('status',1)
                        ->where('project_type',2)
                        ->get();

            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();  

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();
        }else{
            if($month != 0 ){
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                            ->where('status',1)
                            ->where('project_type',2)
                            ->whereMonth('helddate' , $month)
                            ->get();

                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();  

                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                }
                if ($quater == 2){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                }
                if ($quater == 3){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                }
                if ($quater == 4){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
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

            $total_actualparticipate=0;
            $total_sum=0;
            $totalhasoccupation = 0;

            foreach( $department as $item ){
                $num = $readinesssection->where('department_id', $item->department_id)->count();
                $numsection = count($readinesssection->where('department_id', $item->department_id)->groupBy('section_id')->all());
                $actualparticipate = 0;
                $sum=0;
                $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            

                foreach($_readinesssection as $sec){
                    $actualparticipate = $participategroup->where('department_id' , $sec->department_id)->count();           
                    // $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                    $total_actualparticipate = $total_actualparticipate + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                    $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                    $total_sum = $total_sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                }
                $registers = $participategroup->where('department_id', $item->department_id)->all();
                $hasoccupation=0;
                if (count($registers) !=0 ){
                foreach($registers as $_item){                   
                    $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                            ->where('occupation_id','!=',1)
                                                            ->first();
                    if(count($registerhasoccupation) != 0 ){
                        $hasoccupation = $hasoccupation + 1;
                        $totalhasoccupation++;
                    }
                }
            }
               if($actualparticipate!=0){
                   $percent = number_format( ($hasoccupation/ $actualparticipate) * 100 , 2);
               }else{
                   $percent=0;
               }   

                $summary_array[] = array(
                    'departmentname' =>  $item->department_name  ,
                    'num' => $num,
                    'section' => $numsection   ,
                    'participate' =>  $actualparticipate,
                    'hasoccupation' =>  $hasoccupation,
                    'percent' =>  $percent ,
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
        $setting = SettingYear::where('setting_status' , 1)->first();
        $settingyear = SettingYear::get();
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
        $province = Province::all();

        $occupationarray = array();
        $sectionarray = array();
        $department = Department::get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();       

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
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                        ->where('status',1)
                        ->where('project_type',2)
                        ->get();

            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();  

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();              
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header = "เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                  
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                            ->where('status',1)
                            ->where('project_type',2)
                            ->whereMonth('helddate' , $month)
                            ->get();

                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();  

                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();
            }

            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                            
                $header =  $quatername->quater_name ;
                if ($quater == 1){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                }
                if ($quater == 2){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                }
                if ($quater == 3){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                }
                if ($quater == 4){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
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
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สังกัดกรม'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จำนวนโครงการ'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จำนวนหน่วยงานที่จัด'), 'headerStyle','pStyle');
        $table->addCell(4000, $styleCell)->addText(htmlspecialchars('จำนวนผู้เข้าร่วม'), 'headerStyle','pStyle');           
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนผู้มีอาชีพ'), 'headerStyle','pStyle');  
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('ร้อยละการมีอาชีพ'), 'headerStyle','pStyle');  
               
        $total_actualparticipate=0;
        $total_sum=0;
        $totalhasoccupation = 0;

        foreach( $department as $item ){
            $num = $readinesssection->where('department_id', $item->department_id)->count();
            $numsection = count($readinesssection->where('department_id', $item->department_id)->groupBy('section_id')->all());
            $actualparticipate = 0;
            $sum=0;
            $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            

            foreach($_readinesssection as $sec){
                $actualparticipate = $participategroup->where('department_id' , $sec->department_id)->count();           
                // $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                $total_actualparticipate = $total_actualparticipate + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                $total_sum = $total_sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
            }
            $registers = $participategroup->where('department_id', $item->department_id)->all();
            $hasoccupation=0;
            if (count($registers) !=0 ){
            foreach($registers as $_item){                   
                $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                        ->where('occupation_id','!=',1)
                                                        ->first();
                if(count($registerhasoccupation) != 0 ){
                    $hasoccupation = $hasoccupation + 1;
                    $totalhasoccupation++;
                }
            }
        }
           if($actualparticipate!=0){
               $percent = number_format( ($hasoccupation/ $actualparticipate) * 100 , 2);
           }else{
               $percent=0;
           }   

            $table->addRow(10);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name  ),'bodyStyle','pStyle2');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $num ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numsection ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $actualparticipate ),'bodyStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $hasoccupation ),'bodyStyle','pStyle');           
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $percent  ),'bodyStyle','pStyle');           
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
        $province = Province::all();

        $occupationarray = array();
        $sectionarray = array();
        $department = Department::get();
        $personalassessment = PersonalAssessment::where('project_id',$project->project_id)->get();  

        if($month == 0 && $quater == 0){      
            $header =  "" ;
            $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                        ->where('status',1)
                        ->where('project_type',2)
                        ->get();

            $participate = ProjectParticipate::where('project_id' , $project->project_id)
                        ->where('project_type',2)
                        ->get();  

            $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                        ->where('project_type',2)
                        ->get();  

        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                            ->where('status',1)
                            ->where('project_type',2)
                            ->whereMonth('helddate' , $month)
                            ->get();

                $participate = ProjectParticipate::where('project_id' , $project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();  

                $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                            ->where('project_type',2)
                            ->whereMonth('projectdate' , $month)
                            ->get();

            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;
                if ($quater == 1){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',10); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',11); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',12); });
                                })
                                ->get();
                }
                if ($quater == 2){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',1); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',2); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',3); });
                                })
                                ->get();
                }
                if ($quater == 3){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
                                ->where('project_type',2)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('projectdate',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('projectdate',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('projectdate',6); });
                                })
                                ->get();
                }
                if ($quater == 4){
                    $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                                ->where('status',1)
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

                    $participategroup = ParticipateGroup::where('project_id',$project->project_id)
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

        $pdf->loadView("report.followup.main.hasoccupation.pdfhasoccupation" , [ 
                            'participategroup' => $participategroup , 
                            'readinesssection' => $readinesssection, 
                            'participategroup' => $participategroup, 
                            'setyear' => $setyear, 
                            'setting' => $setting, 
                            'participate' => $participate, 
                            'personalassessment' => $personalassessment, 
                            'department' => $department, 
                            'header' =>  $header 
                            ]);
        return $pdf->download('occupation.pdf');    
    }


    public function HasOccupationChart(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        return view('report.followup.main.hasoccupation.hasoccupationchart')->withSetting($setting);
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
