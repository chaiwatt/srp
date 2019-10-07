<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\Department;
use App\Model\ContractorEmploy;
use App\Model\Allocation;
use App\Model\ContractorPosition;
use App\Model\Generate;
use App\Model\LogFile;

class ContractorEmployMainController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $deptallocation = Allocation::where('project_id' , $project->project_id)
                                ->where('budget_id' , 6)
                                ->Where('allocation_type' , 1)
                                ->orderBy('department_id')
                                ->get();

        $position = ContractorPosition::get();
        $employ = ContractorEmploy::where('project_id', $project->project_id )->get();
        $generate = Generate::where('project_id' , $project->project_id)
                                ->where('generate_category' , 2)
                                ->get();

        if($deptallocation->count() == 0){
            return redirect('project/allocation')->withError('ยังไม่ได้จัดสรรโครงการ');
        }

        return view('contractor.main.employ.index')->withSetting($setting)
                                ->withProject($project)
                                ->withPosition($position)
                                ->withDeptallocation($deptallocation)
                                ->withGenerate($generate)
                                ->withEmploy($employ);

    }
    public function CreateSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $sumsalary = 0;
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $employ = ContractorEmploy::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->sum('employ_amount');
        $position = ContractorPosition::where('position_status' , 1)->get();
        $number = array();

        $department = Allocation::where('project_id' , $project->project_id)
                            ->where('budget_id' , 6)
                            ->Where('allocation_type' , 1)
                            ->orderBy('department_id')
                            ->get();


        if( count( $department ) > 0  ){
        	foreach( $department as $item ){
            echo ($item->departmentname) . "<br>";

        		$employsection = Generate::where('project_id' , $project->project_id)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('generate_category' , 2)
                                    ->count();

                $allocation = Allocation::where('project_id' , $project->project_id)
                                    ->where('budget_id' , 6)
                                    ->Where('allocation_type' , 1)
                                    ->sum('allocation_price');

		        if( count($position) > 0 ){
		            foreach( $position as $value ){
                         $num = Request::input('number')[$item->department_id][$value->position_id];


                        unset( $number );

                        for( $i=1; $i <= $num; $i++  ){
                            $yearth = substr ( (date('Y')+543) , 2 , 4 );
                            $code = $yearth.str_pad( ($item->department_id) , 2 ,"0",STR_PAD_LEFT).str_pad( (0) , 5 ,"0",STR_PAD_LEFT).str_pad( ($value->position_id) , 2 ,"0",STR_PAD_LEFT).str_pad( ($i) , 4 ,"0",STR_PAD_LEFT);
                            $generate = Generate::where('project_id',$project->project_id)
                                                ->where('department_id' , $item->department_id)
                                                ->where('generate_category' , 2)
                                                ->where('generate_code' , $code)
                                                ->first();
                            $number[] = $code;   
                            
                            if( count($generate) == 0 ){
                                $new = new Generate;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $item->department_id;
                                $new->section_id = 0;
                                $new->position_id = $value->position_id;
                                $new->generate_code = $code;
                                $new->generate_category = 2;
                                $new->generate_allocation = (($value->position_salary) * 9);
                                $new->generate_refund = 0;
                                $new->save();
                            }

                                $generate = Generate::where('project_id',$project->project_id)
                                                ->where('section_id' , 0 )
                                                ->where('generate_category' , 2)
                                                ->where('position_id' , $value->position_id)
                                                ->count();

                                if( $num < $generate  ){
                                    Generate::where('project_id',$project->project_id)
                                                ->where('generate_category' , 2)
                                                ->where('section_id' , 0 )
                                                ->where('position_id' , $value->position_id)
                                                ->wherenotin( 'generate_code' , $number )
                                                ->delete();
                                }

                        }
                        
		            }
		        }
        	}
        }
        $new = new LogFile;
        $new->loglist_id = 11;
        $new->user_id = $auth->user_id;
        $new->save();
        return redirect()->back()->withSuccess("บันทึกรายการจัดสรรการจ้างงานเรียบร้อยแล้ว");
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
