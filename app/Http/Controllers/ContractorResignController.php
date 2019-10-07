<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\Contractor;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Resign;
use App\Model\Reason;
use App\Model\LogFile;

class ContractorResignController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Resign::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('resign_category' , 2);
        $q = $q->where('resign_status' , 1);
        $q = $q->where('resign_type' , 1);
        $resign = $q->get();

        return view('contractor.resign.index')->withProject($project)->withResign($resign);
    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('generate_category' , 2);
        $q = $q->where('section_id' , 0);
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        $q = Reason::query();
        $q = $q->where('reason_type' , 1);
        $reason = $q->get();

        return view('contractor.resign.create')->withProject($project)->withGenerate($generate)->withReason($reason);

    }

    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('generate_id' , Request::input('generate'));
        $q = $q->where('generate_category' , 2);
        $q = $q->where('generate_status' , 1);
        $generate = $q->first();

        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลการจ้างงาน");
        }

        if( Request::input('date') == "" ){
            return redirect()->back()->withError("กรุณากรอกวันที่เบิกจ่าย");
        }

        $date1 = explode("/", Request::input('date'));
        $date = ($date1[2]-543)."-".$date1[1]."-".$date1[0];

        $new = new Resign;
        $new->resign_category = 2;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->generate_id = $generate->generate_id;
        $new->generate_code = $generate->generate_code;
        $new->register_id = $generate->register_id;
        $new->position_id = $generate->position_id;
        $new->reason_id = Request::input('reason');
        $new->resign_date = $date;
        $new->resign_status = 1;
        $new->resign_type = 1;
        $new->save();

        $generate->generate_status = 0;
        $generate->register_id = null;
        $generate->save();

        $new = new LogFile;
        $new->loglist_id = 15;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('contractor/resign')->withSuccess("บันทึกข้อมูลการลาออกเรียบร้อยแล้ว");
    }

    public function DeleteSave($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $q = Resign::query();
        $q = $q->where('resign_id' , $id);
        $q = $q->where('resign_type' , 1);
        $resign = $q->first();
        $resign->resign_status = 0;
        $resign->save();

        $new = new LogFile;
        $new->loglist_id = 16;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect()->back()->withSuccess("ลบข้อมูลเรียบร้อยแล้ว");
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
