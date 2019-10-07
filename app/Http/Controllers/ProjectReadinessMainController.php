<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;
use App\Model\ProjectParticipate;
use App\Model\ParticipateGroup;



class ProjectReadinessMainController extends Controller
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
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                ->where('project_type',1)
                                ->get();

        return view('readiness.project.main.index')->withProject($project)
                                                    ->withReadiness($readiness);
    }

    public function Confirm(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
    	$setting = SettingYear::where('setting_status' , 1)->first();
        $readiness = ProjectReadiness::where('year_budget' , $setting->setting_year)
                                    ->where('project_type',1)
                                    ->get();

        return view('readiness.project.main.confirm')->withProject($project)
                                                    ->withReadiness($readiness);
    }


	public function Approve($id){
		if( $this->authsuperadmint() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        ProjectReadiness::where('project_readiness_id',$id)
                        ->where('project_type',1)
                        ->update([ 
                            'project_status' => 1 
                        ]);
        $projectreadiness = ProjectReadiness::where('project_readiness_id',$id)
                        ->where('project_type',1)
                        ->first();   
                        
        if(!Empty($projectreadiness)){
            $users = Users::where('department_id' , $projectreadiness->department_id)
                        ->where('permission',2)
                        ->get();
            if( $users->count() > 0 ){
                foreach( $users as $user ){
                    $new = new NotifyMessage;
                    $new->system_id = 1;
                    $new->project_id = $project->project_id;
                    $new->message_key = 1;
                    $new->message_title = "อนุมัติโครงการฝึกอบรม";
                    $new->message_content = "โครงการ" . $projectreadiness->project_readiness_name . " ได้รับการอนุมัติ";
                    $new->message_date = date('Y-m-d H:i:s');
                    $new->user_id = $user->user_id;
                    $new->save();
    
                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                    if(!Empty($linenotify)){
                        if ($linenotify->linetoken != ""){
                            $message = "โครงการ" . $projectreadiness->project_readiness_name . " ได้รับการอนุมัติ โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                            $linenotify->notifyme($message);
                        }
                    }
                }
            } 
        }                
               
        return redirect('readiness/project/main/confirm')->withSuccess("โครงการอบรมได้อนุมัติแล้ว");
    }
    
    public function Edit($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();       
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $readiness = ProjectReadiness::where('project_readiness_id',$id)
                                    ->where('project_type',1)
                                    ->first();

        return view('readiness.project.main.edit')->withProject($project)
                                                ->withReadiness($readiness);
    }


    public function EditSave(){
		if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $id = Request::input('id');

        $date = explode("/", Request::input('projectdate'));
        $projectdate = ($date[2]-543)."-".$date[1]."-".$date[0];

        ProjectReadiness::where('project_readiness_id',$id)
                    ->where('project_type',1)
                    ->update([ 
                        'targetparticipate' => Request::input('number'), 
                        'budget' => Request::input('budget'),
                        'project_readiness_desc' => Request::input('detail'),
                        'projectdate' => $projectdate,
                        ]);
        ProjectParticipate::where('project_readiness_id',$id)
                                ->update([ 
                                    'projectdate' => $projectdate,
                                ]);
        ParticipateGroup::where('project_readiness_id',$id)
                            ->update([ 
                                 'projectdate' => $projectdate,
                            ]);
                                                
        return redirect('readiness/project/main/confirm')->withSuccess("โครงการอบรมได้แก้ไขการจัดสรรแล้ว");

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
