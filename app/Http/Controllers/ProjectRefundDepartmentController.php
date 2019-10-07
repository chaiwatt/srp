<?php

namespace App\Http\Controllers;
use Auth;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Refund;
use Illuminate\Http\Request;


class ProjectRefundDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        
        $auth = Auth::user();
        $settingyear = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $settingyear->setting_year)->first();
        $sectionrefund = Refund::where('project_id' , $project->project_id)
                                    ->where('year_budget' , $settingyear->setting_year)
                                    ->where('department_id' , $auth->department_id)
                                    ->where('refund_type' , 2)
                                    ->get();
        return view('project.refund.department.index')->withSectionrefund($sectionrefund)
                                               ->withSettingyear($settingyear);
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
