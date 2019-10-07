<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Generate;
use App\Model\Resign;
use App\Model\Quater;
use App\Model\Month;
use App\Model\SettingDepartment;
use Excel;
use PDF;
use Request;

class ReportRecuriteMainController extends Controller
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
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        if($month == 0 && $quater == 0){
            $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)
                        ->get();
            
            $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->get();
        }else{
            if($month != 0 ){
                $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)                       
                        ->whereMonth('created_at' , $month)
                        ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->whereMonth('created_at' , $month)
                        ->get();   
            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();          

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get(); 
                }
                if ($quater == 2){                    
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 
                }
                if ($quater == 3){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 
                }
                if ($quater == 4){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();           
                }
            }
        }
        return view('report.recurit.main.allocation.index')->withSetting($setting)
                                                        ->withQuatername($quatername)
                                                        ->withMonthname($monthname)
                                                        ->withQuater($quater)
                                                        ->withMonth($month)
                                                        ->withDepartment($department)
                                                        ->withResign($resign)
                                                        ->withEmploy($employ);
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
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        if($month == 0 && $quater == 0){      
            $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)
                        ->get();
            
            $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->get();
           $header = "";
          
           $pdf->loadView("report.recurit.main.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
           return $pdf->download('allocationreport.pdf');                         

        }else{
            if($month != 0 ){
                $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)                       
                        ->whereMonth('created_at' , $month)
                        ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->whereMonth('created_at' , $month)
                        ->get();    
 
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $pdf->loadView("report.recurit.main.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
                return $pdf->download('allocationreport.pdf');                             

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();   

                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $quatername->quater_name ;
                    $pdf->loadView("report.recurit.main.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('allocationreport.pdf');                     

                }
                if ($quater == 2){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $quatername = Quater::where('quater_id',$quater)->first();                            
                    $header =  $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.main.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('allocationreport.pdf');                   

                }
                if ($quater == 3){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $quatername = Quater::where('quater_id',$quater)->first();                          
                    $header =  $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.main.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('allocationreport.pdf');                    

                }
                if ($quater == 4){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();  

                    $quatername = Quater::where('quater_id',$quater)->first();                         
                    $header =  $quatername->quater_name  ;
                    $pdf->loadView("report.recurit.main.allocation.pdfallocate" , [ 'employ' => $employ , 'resign' => $resign, 'department' => $department, 'setting' => $setting, 'header' =>  $header ]);
                    return $pdf->download('allocationreport.pdf');                                            
                }
            }
        }
    }

    public function ExportExcel($month,$quater){
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
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        if($month == 0 && $quater == 0){      
            $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)
                        ->get();
            
            $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->get();

            $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
            foreach( $department as $item ){
                $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                $numresign = $resign->where('resign_type',1)
                                    ->where('department_id' , $item->department_id)
                                    ->count()  ;              
                $numfire = $resign->where('resign_type',2)
                                ->where('department_id' , $item->department_id)
                                ->count() ;  
                $summary_array[] = array(
                    'section_name' => $item->department_name,
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
                $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)                       
                        ->whereMonth('created_at' , $month)
                        ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->whereMonth('created_at' , $month)
                        ->get();    
 
                $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
                foreach( $department as $item ){
                    $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                    $numresign = $resign->where('resign_type',1)
                                        ->where('department_id' , $item->department_id)
                                        ->count()  ;              
                    $numfire = $resign->where('resign_type',2)
                                    ->where('department_id' , $item->department_id)
                                    ->count() ;  
                    $summary_array[] = array(
                        'section_name' => $item->department_name,
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

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();   

                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)
                                            ->where('department_id' , $item->department_id)
                                            ->count()  ;              
                        $numfire = $resign->where('resign_type',2)
                                        ->where('department_id' , $item->department_id)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->department_name,
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

                }
                if ($quater == 2){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)
                                            ->where('department_id' , $item->department_id)
                                            ->count()  ;              
                        $numfire = $resign->where('resign_type',2)
                                        ->where('department_id' , $item->department_id)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->department_name,
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

                }
                if ($quater == 3){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)
                                            ->where('department_id' , $item->department_id)
                                            ->count()  ;              
                        $numfire = $resign->where('resign_type',2)
                                        ->where('department_id' , $item->department_id)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->department_name,
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

                }
                if ($quater == 4){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();  

                    $summary_array[] = array('หน่วยงาน','จำนวนจ้างงาน','ลาออก','ยกเลิกจ้างงาน');
                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)
                                            ->where('department_id' , $item->department_id)
                                            ->count()  ;              
                        $numfire = $resign->where('resign_type',2)
                                        ->where('department_id' , $item->department_id)
                                        ->count() ;  
                        $summary_array[] = array(
                            'section_name' => $item->department_name,
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
                }
            }
        }
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
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

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
            $header = "";
            $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
            $section->addText($header,'headerStyle', 'pStyle');
            $table = $section->addTable('Allocation');
            $table->addRow(50);
            $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
            $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
               
            $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)
                        ->get();
            $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->get();

            foreach( $department as $item ){
                $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() ;
                $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count();
                $table->addRow(10);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
            }   
            $table->addRow(15);
            $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->count() ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $resign->where('resign_type',1)->count() ),'headerStyle','pStyle');
            $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_type',2)->count()),'headerStyle','pStyle');
                                                           
        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  " เดือน " . $monthname->month_name . " " . $setting->setting_year ;
                $section->addText('ประจำปีงบประมาณ พ.ศ.' . $setting->setting_year ,'headerStyle', 'pStyle');
                $section->addText($header,'headerStyle', 'pStyle');
                $table = $section->addTable('Allocation');
                $table->addRow(50);
                $table->addCell(4000, $styleCell)->addText(htmlspecialchars('สำนักงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนจ้างงาน'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนลาออก'), 'headerStyle','pStyle');
                $table->addCell(2000, $styleCell)->addText(htmlspecialchars('จำนวนยกเลิกจ้างงาน'), 'headerStyle','pStyle');
                        
                $employ = Generate::where('project_id' , $project->project_id)
                        ->where('generate_category' , 1)
                        ->where('generate_status' , 1)                       
                        ->whereMonth('created_at' , $month)
                        ->get();

                $resign = Resign::where('project_id' , $project->project_id)
                        ->where('resign_status' , 1)
                        ->whereMonth('created_at' , $month)
                        ->get();    

                foreach( $department as $item ){
                    $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                    $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() ;
                    $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count();
        
                    $table->addRow(10);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                }   
    
                $table->addRow(15);
                $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->count() ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $resign->where('resign_type',1)->count() ),'headerStyle','pStyle');
                $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_type',2)->count()),'headerStyle','pStyle');
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $quatername->quater_name ;
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
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',10); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',11); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',12); });
                                    })
                                    ->get();   

                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count();
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                    
                    }   
        
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $resign->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_type',2)->count()),'headerStyle','pStyle');
                
                }
                if ($quater == 2){                   
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',1); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',2); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',3); });
                                    })
                                    ->get();

                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count();
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');           
                    }   
        
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $resign->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_type',2)->count()),'headerStyle','pStyle');
                                
                }
                if ($quater == 3){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',4); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',5); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',6); });
                                    })
                                    ->get(); 

                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count();
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle'); 
                    }   
        
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $resign->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_type',2)->count()),'headerStyle','pStyle');
                                

                }
                if ($quater == 4){
                    $employ = Generate::where('project_id' , $project->project_id)
                                    ->where('generate_category' , 1)
                                    ->where('generate_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get(); 

                    $resign = Resign::where('project_id' , $project->project_id)
                                    ->where('resign_status' , 1)
                                    ->where(function($query){
                                        $query->orWhere(function($query1){$query1->whereMonth('created_at',7); });
                                        $query->orWhere(function($query2){$query2->whereMonth('created_at',8); });
                                        $query->orWhere(function($query3){$query3->whereMonth('created_at',9); });
                                    })
                                    ->get();  
                    foreach( $department as $item ){
                        $numhired = $employ->where('department_id' , $item->department_id)->count() ;
                        $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() ;
                        $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count();
            
                        $table->addRow(10);
                        $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( $item->department_name ),'bodyStyle','pStyle2');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numhired ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numresign ),'bodyStyle','pStyle');
                        $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $numfire ),'bodyStyle','pStyle');
                    
                    }   
        
                    $table->addRow(15);
                    $table->addCell(4000, $styleCell2)->addText(htmlspecialchars( 'รวม' ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $employ->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars(  $resign->where('resign_type',1)->count() ),'headerStyle','pStyle');
                    $table->addCell(2000, $styleCell2)->addText(htmlspecialchars( $resign->where('resign_type',2)->count()),'headerStyle','pStyle');
                                                    
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
