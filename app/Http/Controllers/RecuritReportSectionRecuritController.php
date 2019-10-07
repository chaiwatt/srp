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
use App\Model\RegisterEducation;

class RecuritReportSectionRecuritController extends Controller
{
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $employ = collect();
    	$auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $month = Request::input('month')==""?"":Request::input('month');
        $quater = Request::input('quater')==""?"":Request::input('quater');
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $education = RegisterEducation::get();  

        $register = Register::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('register_type',1)
                    ->get();  

        if($month == 0 && $quater == 0){  
            $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->get();

        }else{
            if($month != 0 ){
                $employ = Generate::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('generate_category',1)
                        ->where('generate_status',1)
                        ->whereMonth('updated_at' , $month)
                        ->get();

            }
            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',12); });
                    })->get();
                }
                if ($quater == 2){
                    $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',3); });
                    })->get();
                }
                if ($quater == 3){
                    $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',6); });
                    })->get();
                }
                if ($quater == 3){
                    $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',9); });
                    })->get();
                }
            }
        }
                                  
        return view('recurit.report.section.recurit.index')->withProject($project)
                        ->withQuatername($quatername)
                        ->withMonthname($monthname)
                        ->withQuater($quater)
                        ->withMonth($month)
                        ->withEmploy($employ)
                        ->withEducation($education)
                        ->withRegister($register);

    }


    public function ExportPDF($month,$quater){
            if( $this->authsection() ){
                return redirect('logout');
            }

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true, 
                'isRemoteEnabled' => true , 
                'logOutputFile' => storage_path('logs/log.htm'),
                'tempDir' => storage_path('logs/')
            ]);

            $employ = collect();
            $auth = Auth::user();
            $setting = SettingYear::where('setting_status' , 1)->first();
            $project = Project::where('year_budget' , $setting->setting_year)->first();
            $quatername = Quater::where('quater_id',$quater)->first();
            $monthname = Month::where('month_id',$month)->first();
            $education = RegisterEducation::get();  
    
            $register = Register::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('register_type',1)
                        ->get();  

            $section = Section::where('section_id',$auth->section_id)->first();
       
            if($month == 0 && $quater == 0){      
                $header = $section->section_name;
                $employ = Generate::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('generate_category',1)
                        ->where('generate_status',1)
                        ->get();             

        }else{
            if($month != 0 ){
                $monthname = Month::where('month',$month)->first();                            
                $header =  $section->section_name . " เดือน " . $monthname->month_name ;  
                $employ = Generate::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('generate_category',1)
                        ->where('generate_status',1)
                        ->whereMonth('updated_at' , $month)
                        ->get();                         
            }
            if($quater !=0 && $quater != ""){
                $quatername = Quater::where('quater_id',$quater)->first();                          
                $header =  $section->section_name . " " . $quatername->quater_name ;
                if ($quater == 1){
                            $employ = Generate::where('project_id',$project->project_id)
                            ->where('department_id',$auth->department_id)
                            ->where('section_id',$auth->section_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('updated_at',10); });
                                $query->orWhere(function($query2){$query2->whereMonth('updated_at',11); });
                                $query->orWhere(function($query3){$query3->whereMonth('updated_at',12); });
                            })->get();
                }
                if ($quater == 2){
                    $employ = Generate::where('project_id',$project->project_id)
                            ->where('department_id',$auth->department_id)
                            ->where('section_id',$auth->section_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('updated_at',1); });
                                $query->orWhere(function($query2){$query2->whereMonth('updated_at',2); });
                                $query->orWhere(function($query3){$query3->whereMonth('updated_at',3); });
                            })->get();
                }
                if ($quater == 3){
                    $employ = Generate::where('project_id',$project->project_id)
                            ->where('department_id',$auth->department_id)
                            ->where('section_id',$auth->section_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('updated_at',4); });
                                $query->orWhere(function($query2){$query2->whereMonth('updated_at',5); });
                                $query->orWhere(function($query3){$query3->whereMonth('updated_at',6); });
                            })->get();
                }
                if ($quater == 4){
                    $employ = Generate::where('project_id',$project->project_id)
                            ->where('department_id',$auth->department_id)
                            ->where('section_id',$auth->section_id)
                            ->where('generate_category',1)
                            ->where('generate_status',1)
                            ->where(function($query){
                                $query->orWhere(function($query1){$query1->whereMonth('updated_at',7); });
                                $query->orWhere(function($query2){$query2->whereMonth('updated_at',8); });
                                $query->orWhere(function($query3){$query3->whereMonth('updated_at',9); });
                            })->get();
                }

            }
        }

        $pdf->loadView("recurit.report.section.recurit.pdfrecurit" , [ 'register' => $register , 'employ' => $employ , 'education' => $education, 'setting' => $setting, 'header' =>  $header ])->setPaper('a4', 'landscape');
        return $pdf->download('recuritreport.pdf');   
    }  

    public function ExportExcel($month,$quater){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $employ = collect();
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $quatername = Quater::where('quater_id',$quater)->first();
        $monthname = Month::where('month_id',$month)->first();
        $education = RegisterEducation::get();  

        $register = Register::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('register_type',1)
                    ->get();  
                   
        if($month == 0 && $quater == 0){      
            $employ = Generate::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('generate_category',1)
                        ->where('generate_status',1)
                        ->get();    

        }else{
            if($month != 0 ){ 
                $employ = Generate::where('project_id',$project->project_id)
                        ->where('department_id',$auth->department_id)
                        ->where('section_id',$auth->section_id)
                        ->where('generate_category',1)
                        ->where('generate_status',1)
                        ->whereMonth('updated_at' , $month)
                        ->get();  
            }

            if($quater !=0 && $quater != ""){
                if ($quater == 1){
                    $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',10); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',11); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',12); });
                    })->get();
        }
        if ($quater == 2){
            $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',1); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',2); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',3); });
                    })->get();
        }
        if ($quater == 3){
            $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',4); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',5); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',6); });
                    })->get();
        }
        if ($quater == 4){
            $employ = Generate::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('section_id',$auth->section_id)
                    ->where('generate_category',1)
                    ->where('generate_status',1)
                    ->where(function($query){
                        $query->orWhere(function($query1){$query1->whereMonth('updated_at',7); });
                        $query->orWhere(function($query2){$query2->whereMonth('updated_at',8); });
                        $query->orWhere(function($query3){$query3->whereMonth('updated_at',9); });
                    })->get();
        }

            }
         
        }

        $summary_array[] = array('คำนำหน้า','ชื่อ','นามสกุล','เลขประจำตัว','การศึกษา','อายุ','เลขที่จ้างงาน','ตำแหน่ง','เริ่มจ้าง','สิ้นสุดจ้าง'); 
        if(count($employ) > 0){
            foreach( $employ as $item ){
                $_register = $register->where('register_id', $item->register_id)->first();
               if (count($_register) !=0 ){
                    $_education = $education->where('register_id',$_register->register_id)
                                ->where('register_education_name','!=',"")
                                ->last();
                    $summary_array[] = array(
                        'prefixx' => $_register->prefixname  ,
                        'name' => $_register->name,
                        'lastname' => $_register->lastname ,
                        'personid' => $_register->person_id ,
                        'educate' => $_education->register_education_name ,
                        'age' => $_register->ageyear ,
                        'empno' => $_register->department_id . $_register->section_id . $_register->position_id . $_register->register_id ."-". $_register->year_budget ,
                        'position' => $_register->positionname ,
                        'starthire' =>  $_register->starthiredateinput ,
                        'endhire' =>   $_register->endhiredateinput ,
                    );
                }
            }    
        }

        $excelfile = Excel::create("recuritreport", function($excel) use ($summary_array){
            $excel->setTitle("ผลการจ้างงานรายบุคคล");
            $excel->sheet('ผลการจ้างงานรายบุคคล', function($sheet) use ($summary_array){
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
