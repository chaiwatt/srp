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
use App\Model\Position;


class ReportRecuriteDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
   
        $employ = collect();
        $resign = collect();
        $section = collect();
        $quatername = collect();
        $monthname = collect();

        $auth = Auth::user();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = Position::where('department_id',$auth->department_id)->get();

        if($month == 0 && $quater == 0){
            $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->get();

            $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->get();

            $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , "!=",0)
                            ->groupBy('section_id')
                            ->get();
                        
        }else{
            if($month != 0 ){
                $employ = Generate::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('generate_category' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('resign_status' , 1)
                                ->whereMonth('created_at' , $month)
                                ->get();

                $section = Generate::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->whereMonth('created_at' , $month)
                                ->where('section_id' , "!=",0)
                                ->groupBy('section_id')
                                ->get();    
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get();     

                }
                if ($quater == 2){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                }
                if ($quater == 3){
                    $employ = Generate::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('generate_category' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                })
                                ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('resign_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                })
                                ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 
                }
                if ($quater == 4){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get();                        
                }
            }
        }

        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        return view('report.recurit.department.allocation.index')->withEmploy($employ)
                                                ->withSection($section)
                                                ->withResign($resign)
                                                ->withSetting($setting)
                                                ->withPosition($position)
                                                ->withQuatername($quatername)
                                                ->withMonthname($monthname)
                                                ->withQuater($quater)
                                                ->withMonth($month);
    }

    public function ExportExcel($month,$quater){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $position = Position::where('department_id',$auth->department_id)->get();

        if($month == 0 && $quater == 0){      
            $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->get();

            $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->get();

            $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->groupBy('section_id')
                            ->where('section_id' , "!=",0)
                            ->get();  
                            
            $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');

            foreach( $section as $item ){
                $numhired = $employ->where('section_id' , $item->section_id)
                                ->where('generate_status',1)
                                ->count() ;
                $numresign = $resign->where('section_id' , $item->section_id)
                                ->where('resign_status',1)->where('resign_type',1)
                                ->count() ;              
                $numfire = $resign->where('section_id' , $item->section_id)
                                ->where('resign_status',1)->where('resign_type',2)
                                ->count() ;  
                $summary_array[] = array(
                    'section_name' => $item->section_name,
                    'hired' => $numhired,
                    'resign' => $numresign ,
                    'fire' => $numfire
                );
            }
    
            $excelfile = Excel::create("allocationreport", function($excel) use ($summary_array){
                $excel->setTitle("การจ้างงาน");
                $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                    $sheet->fromArray($summary_array,null,'A1',true,false);
                });
            })->download('xlsx');
        
        }else{
            if($month != 0 ){
                //Query by month
                $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->whereMonth('created_at' , $month)
                            ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->whereMonth('created_at' , $month)
                            ->get();

                $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->whereMonth('created_at' , $month)
                            ->where('section_id' , "!=",0)
                            ->groupBy('section_id')
                            ->get(); 
  
                $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');

                foreach( $section as $item ){
                    $numhired = $employ->where('section_id' , $item->section_id)
                                    ->where('generate_status',1)
                                    ->count() ;
                    $numresign = $resign->where('section_id' , $item->section_id)
                                    ->where('resign_status',1)->where('resign_type',1)
                                    ->count() ;              
                    $numfire = $resign->where('section_id' , $item->section_id)
                                    ->where('resign_status',1)->where('resign_type',2)
                                    ->count() ;  
                    $summary_array[] = array(
                        'section_name' => $item->section_name,
                        'hired' => $numhired,
                        'resign' => $numresign ,
                        'fire' => $numfire
                    );
                }
        
                $excelfile = Excel::create("allocationreport", function($excel) use ($summary_array){
                    $excel->setTitle("การจ้างงาน");
                    $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                        $sheet->fromArray($summary_array,null,'A1',true,false);
                    });
                        // })->string('xlsx');
                    })->download('xlsx');                         

            }
            if($quater !=0 && $quater != ""){
                //Query by quater
                if ($quater == 1){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get();  
                    
                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');

                    foreach( $section as $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)
                                        ->where('generate_status',1)
                                        ->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',1)
                                        ->count() ;              
                        $numfire = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',2)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'hired' => $numhired,
                            'resign' => $numresign ,
                            'fire' => $numfire
                        );
                    }
            
                    $excelfile = Excel::create("allocationreport", function($excel) use ($summary_array){
                        $excel->setTitle("การจ้างงาน");
                        $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                        // })->string('xlsx');
                    })->download('xlsx');
                        
                }
                if ($quater == 2){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');

                    foreach( $section as $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)
                                        ->where('generate_status',1)
                                        ->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',1)
                                        ->count() ;              
                        $numfire = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',2)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'hired' => $numhired,
                            'resign' => $numresign ,
                            'fire' => $numfire
                        );
                    }
            
                    $excelfile = Excel::create("allocationreport", function($excel) use ($summary_array){
                        $excel->setTitle("การจ้างงาน");
                        $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                        // })->string('xlsx');
                    })->download('xlsx');              

                }
                if ($quater == 3){
                    $employ = Generate::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('generate_category' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                })->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('resign_status' , 1)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                })->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where(function($query){
                                    $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                    $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                    $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                })
                                ->where('section_id' , "!=",0)
                                ->groupBy('section_id')
                                ->get(); 
 
                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');

                    foreach( $section as $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)
                                        ->where('generate_status',1)
                                        ->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',1)
                                        ->count() ;              
                        $numfire = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',2)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'hired' => $numhired,
                            'resign' => $numresign ,
                            'fire' => $numfire
                        );
                    }
            
                    $excelfile = Excel::create("allocationreport", function($excel) use ($summary_array){
                        $excel->setTitle("การจ้างงาน");
                        $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                            // })->string('xlsx');
                        })->download('xlsx');
                                          

                }
                if ($quater == 4){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 
                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');

                    foreach( $section as $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)
                                        ->where('generate_status',1)
                                        ->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',1)
                                        ->count() ;              
                        $numfire = $resign->where('section_id' , $item->section_id)
                                        ->where('resign_status',1)->where('resign_type',2)
                                        ->count() ; 
                           
                                        
                                        
                        $summary_array[] = array(
                            'section_name' => $item->section_name,
                            'hired' => $numhired,
                            'resign' => $numresign ,
                            'fire' => $numfire
                        );
                    }
            
                    $excelfile = Excel::create("allocationreport", function($excel) use ($summary_array){
                        $excel->setTitle("การจ้างงาน");
                        $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                            $sheet->fromArray($summary_array,null,'A1',true,false);
                        });
                        // })->string('xlsx');
                    })->download('xlsx');
                                                              
                }
            }
        }
    }
    public function ExportPDF($month,$quater){
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
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id', $auth->department_id)->first();
        $position = Position::where('department_id',$auth->department_id)->get();
        if($month == 0 && $quater == 0){      
            $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->get();

            $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->get();

            $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('section_id' , "!=",0)
                            ->groupBy('section_id')
                            ->get();  
           $header = "สำนักงาน" . $department->department_name;
           $pdf->loadView("report.recurit.department.allocation.pdfallocate" , [ 'position' => $position ,'employ' => $employ , 'resign' => $resign, 'section' => $section, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
           return $pdf->download('allocationreport.pdf');                         

        }else{
            if($month != 0 ){
                $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->whereMonth('created_at' , $month)
                            ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->whereMonth('created_at' , $month)
                            ->get();

                $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->whereMonth('created_at' , $month)
                            ->where('section_id' , "!=",0)
                            ->groupBy('section_id')
                            ->get(); 
 
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $pdf->loadView("report.recurit.department.allocation.pdfallocate" , [ 'position' => $position ,'employ' => $employ , 'resign' => $resign, 'section' => $section, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
                return $pdf->download('allocationreport.pdf');                             

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get();  

                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $pdf->loadView("report.recurit.department.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'section' => $section, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
                    return $pdf->download('allocationreport.pdf');                     

                }
                if ($quater == 2){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                    $quatername = Quater::where('quater_id',$quater)->first();                            
                    $header =  $department->department_name . " " . $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.department.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'section' => $section, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
                    return $pdf->download('allocationreport.pdf');                   

                }
                if ($quater == 3){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->groupBy('section_id')
                                    ->get(); 

                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.department.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'section' => $section, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
                    return $pdf->download('allocationreport.pdf');                    

                }
                if ($quater == 4){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                    $quatername = Quater::where('quater_id',$quater)->first();                         
                    $header =  $department->department_name . " " . $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.department.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'section' => $section, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
                    return $pdf->download('allocationreport.pdf');                                            
                }
            }
        }


    }

    public function ExportWORD($month,$quater){
        
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id', $auth->department_id)->first();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
        $phpWord->addFontStyle('headerStyle', array('name' => 'TH Sarabun New','bold' => true,  'size' => 16));
        $phpWord->addFontStyle('bodyStyle', array('name' => 'TH Sarabun New','bold' => false, 'size' => 16));
        $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 0));
        $phpWord->addParagraphStyle('pStyle2', array('align' => 'left', 'spaceAfter' => 0));
        $section = $phpWord->addSection();
        $section->addText('รายงานผลการจ้างงานโครงการคืนคนดีสู่สังคม','headerStyle', 'pStyle');

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
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
    
            $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->get();

            $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->get();

            $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->groupBy('section_id')
                            ->where('section_id' , "!=",0)
                            ->get();  
                foreach( $section as $key => $item ){
                    $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() ;
                    $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() ;
                    $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() ;
        
                    $table->addRow(10);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                
                }   
                
                $table->addRow(15);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->where('generate_status',1)->count() ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',1)->count() ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',2)->count() ),'headerStyle','pStyle');
            
          
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $department->department_name . " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
        
                $employ = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('generate_category' , 1)
                            ->whereMonth('created_at' , $month)
                            ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->where('resign_status' , 1)
                            ->whereMonth('created_at' , $month)
                            ->get();

                $section = Generate::where('project_id' , $project->project_id)
                            ->where('department_id' , $auth->department_id)
                            ->whereMonth('created_at' , $month)
                            ->groupBy('section_id')
                            ->where('section_id' , "!=",0)
                            ->get(); 
              
                foreach( $section as $key => $item ){
                    $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() ;
                    $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() ;
                    $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() ;
        
                    $table->addRow(10);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                
                }   
                
                $table->addRow(15);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->where('generate_status',1)->count() ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',1)->count() ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',2)->count() ),'headerStyle','pStyle');
                            
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $department->department_name . " " . $quatername->quater_name ;
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
                       
                if ($quater == 1){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get();  

                    foreach( $section as $key => $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() ;
                        $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() ;
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                    
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->where('generate_status',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',2)->count() ),'headerStyle','pStyle');
                   
                }
                if ($quater == 2){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
                       
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                    foreach( $section as $key => $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() ;
                        $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() ;
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                    
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->where('generate_status',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',2)->count() ),'headerStyle','pStyle');
                                  

                }
                if ($quater == 3){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
    
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                    foreach( $section as $key => $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() ;
                        $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() ;
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                    
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->where('generate_status',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',2)->count() ),'headerStyle','pStyle');
                                     

                }
                if ($quater == 4){
                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $department->department_name . " " . $quatername->quater_name ;
                    $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                    $section->addText($header,'headerStyle', 'pStyle');
                    $table = $section->addTable('Allocation');
                    $table->addRow(50);
                    $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
    
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();

                    $section = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->where('section_id' , "!=",0)
                                    ->groupBy('section_id')
                                    ->get(); 

                    foreach( $section as $key => $item ){
                        $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() ;
                        $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() ;
                        $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() ;
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->section_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                    
                    }   
                    
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->where('generate_status',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_status',1)->where('resign_type',2)->count() ),'headerStyle','pStyle');
                                                             
                }
            }
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('allocationreport.docx'));
          } catch (Exception $e) {
      
          }
          return response()->download(storage_path('allocationreport.docx'));

    }

    public function generateExcelFormat( $employ, $resign,$section){
        $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
        foreach( $section as $item ){
            $numhired = $employ->where('section_id' , $item->section_id)
                            ->where('generate_status',1)
                            ->count() ;
            $numresign = $resign->where('section_id' , $item->section_id)
                            ->where('resign_status',1)->where('resign_type',1)
                            ->count() ;
            $numfire = $resign->where('section_id' , $item->section_id)
                            ->where('resign_status',1)->where('resign_type',2)
                            ->count() ;  
            $summary_array[] = array(
                'section_name' => $item->section_name,
                'hired' => $numhired,
                'resign' => $numresign ,
                'fire' => $numfire
            );
        }

        $excelfile=  Excel::create("allocationreport", function($excel) use ($summary_array){
            $excel->setTitle("การจ้างงาน");
            $excel->sheet('การจ้างงาน', function($sheet) use ($summary_array){
                $sheet->fromArray($summary_array,null,'A1',false,false);
            });
        })->string('xlsx');
        
        $response =  array(
            'name' => "allocationreport", 
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excelfile) 
            );
            
        return response()->json($response); 
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
