<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use DB;
use Request;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Position;
use App\Model\Department;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\ReadinessSection;
use App\Model\Trainer;
use App\Model\Company;
use App\Model\Participate;
use App\Model\TrainingStatus;
use App\Model\ProjectReadinessOfficer;
use App\Model\ReadinessExpense;
use App\Model\ParticipateGroup;
use App\Model\Group;
use App\Model\Prefix;
use App\Model\ProjectParticipate;
use App\Model\Register;
use App\Model\Transfer;
use App\Model\LogFile;

class ReadinessRefundDepartmentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }         

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                ->where('department_id',$auth->department_id)
                                ->where('project_type',1)
                                ->get();
        
        $readinesssection = ReadinessSection::where('project_id' , $project->project_id)
                                ->where('department_id',$auth->department_id)
                                ->where('completed',1)
                                ->where('project_type',1)
                                ->get();
       
        return view('readiness.refund.department.index')->withProject($project)
                                                    ->withReadinesssection($readinesssection)
                                                    ->withReadiness($readiness);

    }

    public function Confirm($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }    
        ReadinessSection::where('readiness_section_id',$id)
                        ->update([ 
                            'refund_status' =>  1, 
                            ]);

        $auth = Auth::user(); 
        $new = new LogFile;
        $new->loglist_id = 85;
        $new->user_id = $auth->user_id;
        $new->save();

            return redirect('readiness/refund/department')->withSuccess("ยืนยันรับคืนเงินสำเร็จ");
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
