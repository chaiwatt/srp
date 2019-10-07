<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\Department;
use App\Model\Employ;

class RecuritEmployController extends Controller{

    public function EmploySave(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $employ = Employ::where('project_id' , $project->project_id)->get();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->get();

        if( count($department) > 0 ){
            foreach( $department as $item ){
                $value = $employ->where('department_id' , $item->department_id)->first();
                if( count($value) > 0 ){
                    $update = Employ::where('project_id' , $project->project_id)->where('department_id' , $item->department_id)->first();
                    $update->employ_amount = Request::input('amount')[$item->department_id];
                    $update->save();
                }
                else{
                    $new = new Employ;
                    $new->project_id = $project->project_id;
                    $new->year_budget = $project->year_budget;
                    $new->department_id = $item->department_id;
                    $new->employ_amount = Request::input('amount')[$item->department_id];
                    $new->save();
                }
            }
        }

        return redirect()->back()->withSuccess("บันทึกข้อมูลกรอบจ้างงานเรียบร้อยแล้ว");
    }

    public function Index(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }

        $employ = Employ::where('project_id' , $project->project_id)->get();
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->orderBy('department_id', 'ASC')->get();

    	return view('recurit.employ.index')->withDepartment($department)->withProject($project)->withEmploy($employ);
    }

    public function authsuperadmin(){
        $auth = Auth::user();
        if( $auth->permission != 1 ){
             return true;
        }
        else{
            return false;
        }
    }

}


