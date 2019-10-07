<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\Allocation;
use App\Model\AllocationTransaction;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\TransferTransaction;
use App\Model\InformationExpense;
use App\Model\Payment;
use App\Model\Refund;
use App\Model\Survey;
use App\Model\ReadinessSection;
use App\Model\ProjectReadiness;
use App\Model\LogFile;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;


class ProjectAllocationDepartmentOccupation extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        $readiness = Request::input('readiness')==""?"":Request::input('readiness');

        $projectreadiness = ProjectReadiness::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('project_status',1)
                    ->where('department_id',$auth->department_id)
                    ->where('completed',0)
                    ->get();

        $readinesssection = ReadinessSection::where('project_id',$project->project_id)
                    ->where('department_id',$auth->department_id)
                    ->where('project_type',2)
                    ->where('project_readiness_id',$readiness)

                    ->where('status',1)
                    ->get();       

        $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , 0)
                    ->where('budget_id' , 5)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 1)
                    ->sum('transfer_price');

        $refund = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('refund');     
 
        $actualexpense = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('refund');                                

        $payment = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('budget'); 

        $allocation = Allocation::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('allocation_type' , 2)
                    ->where('budget_id' , 5)
                    ->get();
        
        return view('project.allocation.department.occupation.index')->withSearch($readiness)
                    ->withReadiness($readiness)
                    ->withProject($project)
                    ->withReadinesssection($readinesssection)
                    ->withTransfer($transfer)
                    ->withRefund($refund)
                    ->withPayment($payment)
                    ->withAllocation($allocation)
                    ->withProjectreadiness($projectreadiness);
        
    }

    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $sum = 0;
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $section = ReadinessSection::where('project_id',$project->project_id)
                ->where('project_readiness_id',Request::input('readiness_id'))
                ->where('project_type',2)
                ->where('status',1)
                ->groupBy('section_id')
                ->get();   
        $allocation = Allocation::where('project_id' , $project->project_id)
                ->where('department_id' , $auth->department_id)
                ->where('budget_id' , 5)
                ->where('allocation_type' , 1)
                ->first();
        
        $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , 0)
                    ->where('budget_id' , 5)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 1)
                    ->sum('transfer_price');

        $budget = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('budget');   

        $actualpayment = ReadinessSection::where('project_id',$project->project_id)
                    ->where('project_type',2)
                    ->where('department_id' , $auth->department_id)
                    ->where('status',1)
                    ->sum('actualexpense');  

        $sum = array_sum( Request::input('number') );
        
        if( $sum > ( $transfer - ($budget)) ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลรายการงบประมาณได้ เนื่องจากเกินวงเงินคงเหลือ");
        }
        
        if($section->count() !=0){
            foreach( $section as $value ){
                ReadinessSection::where('project_id',$project->project_id)
                        ->where('project_readiness_id',Request::input('readiness_id'))
                        ->where('section_id',$value->section_id )
                        ->where('project_type',2)
                        ->where('status',1)
                        ->update([ 
                            'budget' =>  Request::input('number')[$value->section_id] , 
                            ]);

                        $users = Users::where('section_id' , $value->section_id)->get();
                        $projectreadiness = ProjectReadiness::where('project_readiness_id',Request::input('readiness_id'))->first();
                        if( $users->count() > 0 ){
                            foreach( $users as $user ){
                                $new = new NotifyMessage;
                                $new->system_id = 1;
                                $new->project_id = $project->project_id;
                                $new->message_key = 1;
                                $new->message_title = "โอนเงินโครงการฝึกอบรม";
                                $new->message_content = "โครงการฝึกอบรม".$projectreadiness->project_readiness_name ." ปีงบประมาณ " . $project->year_budget;
                                $new->message_date = date('Y-m-d H:i:s');
                                $new->user_id = $user->user_id;
                                $new->save();
                
                                $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                                if(!Empty($linenotify)){
                                    if ($linenotify->linetoken != ""){
                                        $message = "โอนเงินโครงการฝึกอบรม". $projectreadiness->project_readiness_name ." ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                                        $linenotify->notifyme($message);
                                    }
                                }
                            }
                        }
            }
        }

        $new = new LogFile;
        $new->loglist_id = 24;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('project/allocation/department/occupation?readiness='. Request::input('readiness_id'))->withSuccess("โอนเงินสำเร็จ");
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

