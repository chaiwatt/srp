<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Resign;
use App\Model\Reason;
use App\Model\LogFile;

class RecuritCancelSectionController extends Controller{

    public function DeleteSave($id){
        $q = Resign::query();
        $q = $q->where('resign_id' , $id);
        $q = $q->where('resign_type' , 2);
        $resign = $q->first();
        $resign->resign_status = 0;
        $resign->save();

        $new = new LogFile;
        $new->loglist_id = 39;
        $new->user_id = Auth::user()->user_id;
        $new->save();

        return redirect()->back()->withSuccess("ลบข้อมูลเรียบร้อยแล้ว");
    }

    public function CreateSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_id' , Request::input('generate'));
        $q = $q->where('generate_category' , 1);
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
        $new->resign_category = 1;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = $auth->section_id;
        $new->generate_id = $generate->generate_id;
        $new->generate_code = $generate->generate_code;
        $new->register_id = $generate->register_id;
        $new->position_id = $generate->position_id;
        $new->reason_id = Request::input('reason');
        $new->resign_date = $date;
        $new->resign_type = 2;
        $new->resign_status = 1;
        $new->save();

        $generate->generate_status = 0;
        $generate->register_id = null;
        $generate->save();

        $new = new LogFile;
        $new->loglist_id = 38;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/cancel/section')->withSuccess("บันทึกข้อมูลการยกเลิกจ้างงานเรียบร้อยแล้ว");
    }

    public function Create(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        $q = Reason::query();
        $q = $q->where('reason_type' , 2);
        $reason = $q->get();

        return view('recurit.cancel.section.create')->withProject($project)->withGenerate($generate)->withReason($reason);

    }

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		
        $q = Resign::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('resign_category' , 1);
        $q = $q->where('resign_status' , 1);
        $q = $q->where('resign_type' , 2);
        $resign = $q->get();

        return view('recurit.cancel.section.index')->withProject($project)->withResign($resign);
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


