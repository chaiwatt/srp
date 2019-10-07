<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Transfer;
use App\Model\Allocation;
use App\Model\Refund;
use App\Model\AllocationTransaction;
use App\Model\AllocationWaiting;
use App\Model\ProjectBudget;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;
use App\Model\Department;

class ContractorRefundController extends Controller
{
    public function Index(){
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
        $q = $q->where('generate_category' , 2);
        $q = $q->where('generate_refund' , 0);
        $generate = $q->get();

        return view('contractor.refund.index')->withProject($project)->withGenerate($generate);
    }


    public function confirm($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    
        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , 6 );
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $sumtransfer1 = $q->sum('transfer_price'); 

        $q = Generate::query();
        $q = $q->where('generate_id' , $id);
        $q = $q->where('generate_refund' , 0);
        $generate = $q->first();

        $totalrefund = $generate->paymentbalance;

        if(count($generate) > 0){
            if( $generate->generate_status == 1){
                return redirect()->back()->withError("ไม่สามารถคืนงบประมาณได้ เนื่องจากยังไม่ได้ทำเรื่องลาออกหรือยกเลิกจ้างงาน");
            }
        }
       
        if(  $totalrefund > ( $sumtransfer1 ) ){
        	return redirect()->back()->withError("ไม่สามารถคืนงบประมาณได้ เนื่องงานไม่มีงบประมาณเพียงพอ");
        }

        $generate->generate_refund = 1;
        $generate->save();

        $new = new Refund;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->refund_price = $totalrefund;
        $new->refund_status = 0;
        $new->refund_type = 1;
        $new->generate_id = $id;
        $new->user_id = $auth->user_id;
        $new->save();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 6);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->first();
    
        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , 6);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->first();
        
        $q = AllocationTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0 );
        $q = $q->where('budget_id' , 6);
        $q = $q->where('transaction_type' , 1);
        $q = $q->orderBy('allocation_transaction_id' , 'desc');
        $transaction = $q->first();
    
        $new = new AllocationTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->transaction_cost = ($transaction->transaction_cost);
        $new->transaction_income = 0;
        $new->transaction_outcome = $totalrefund;
        $new->transaction_balance = ($transaction->transaction_cost - $totalrefund );
        $new->transaction_type = 1;
        $new->save();
        /* transaction section */
    
        $allocation->allocation_price = ($allocation->allocation_price - $totalrefund );
        $allocation->save();
    
        $new = new Transfer;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->transfer_amount = 0;
        $new->transfer_price = ( $totalrefund * -1);
        $new->transfer_date = date('Y-m-d H:i:s');
        $new->transfer_status = 1;
        $new->transfer_type = 1;
        $new->transfer_refund = 1;
        $new->user_id = $auth->user_id;
        $new->save();
    
        $new = new AllocationWaiting;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->waiting_price =$totalrefund;
        $new->waiting_price_view = $totalrefund;
        $new->waiting_status = 0;
        $new->save();
    
        $q = ProjectBudget::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 6);
        $budget = $q->first();

        $budget->allocate = ($budget->allocate);
        $budget->save();

        $users = Users::where('permission' , 1)->get();
        $department = Department::where('department_id',$auth->department_id)->first();
        
        if(!Empty($department)){
            if( $users->count() > 0 ){
                foreach( $users as $user ){
                    $new = new NotifyMessage;
                    $new->system_id = 1;
                    $new->project_id = $project->project_id;
                    $new->message_key = 1;
                    $new->message_title = "คืนเงินจ้างเหมา";
                    $new->message_content = "คืนเงินจ้างเหมา " . $department->department_name ;
                    $new->message_date = date('Y-m-d H:i:s');
                    $new->user_id = $user->user_id;
                    $new->save();
        
                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                    if(!Empty($linenotify)){
                        if ($linenotify->linetoken != ""){
                            $message = "คืนเงินจ้างเหมา " . $department->department_name . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                            $linenotify->notifyme($message);
                        }
                    }
                }
            }
        }
    
        return redirect()->back()->withSuccess("คืนงบประมาณเรียบร้อยแล้ว");
    }
    
    public function confirmanual($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

       
    
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
    
        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , 6 );
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $sumtransfer1 = $q->sum('transfer_price'); 

        Generate::where('generate_id', $id)
        ->update([ 
            'generate_status' => 0
            ]);

        $q = Generate::query();
        $q = $q->where('generate_id' , $id);
        $q = $q->where('generate_refund' , 0);
        $generate = $q->first();

        $totalrefund = $generate->paymentbalance;

        if(count($generate) > 0){
            if( $generate->generate_status == 1){
                return redirect()->back()->withError("ไม่สามารถคืนงบประมาณได้ เนื่องจากยังไม่ได้ทำเรื่องลาออกหรือยกเลิกจ้างงาน");
            }
        }
     
        if(  $totalrefund > ( $sumtransfer1 ) ){
        	return redirect()->back()->withError("ไม่สามารถคืนงบประมาณได้ เนื่องงานไม่มีงบประมาณเพียงพอ");
        }

        $generate->generate_refund = 1;
        $generate->save();

        $new = new Refund;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->refund_price = $totalrefund;
        $new->refund_status = 0;
        $new->refund_type = 1;
        $new->generate_id = $id;
        $new->user_id = $auth->user_id;
        $new->save();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 6);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->first();
    
        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , 6);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->first();
        
        $q = AllocationTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0 );
        $q = $q->where('budget_id' , 6);
        $q = $q->where('transaction_type' , 1);
        $q = $q->orderBy('allocation_transaction_id' , 'desc');
        $transaction = $q->first();
    
        $new = new AllocationTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->transaction_cost = ($transaction->transaction_cost);
        $new->transaction_income = 0;
        $new->transaction_outcome = $totalrefund;
        $new->transaction_balance = ($transaction->transaction_cost - $totalrefund );
        $new->transaction_type = 1;
        $new->save();
        /* transaction section */
    
        $allocation->allocation_price = ($allocation->allocation_price - $totalrefund );
        $allocation->save();
    
        $new = new Transfer;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->transfer_amount = 0;
        $new->transfer_price = ( $totalrefund * -1);
        $new->transfer_date = date('Y-m-d H:i:s');
        $new->transfer_status = 1;
        $new->transfer_type = 1;
        $new->transfer_refund = 1;
        $new->user_id = $auth->user_id;
        $new->save();
    
        $new = new AllocationWaiting;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 6;
        $new->waiting_price =$totalrefund;
        $new->waiting_price_view = $totalrefund;
        $new->waiting_status = 0;
        $new->save();
    
        $q = ProjectBudget::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 6);
        $budget = $q->first();

        $budget->allocate = ($budget->allocate);
        $budget->save();

        $users = Users::where('permission' , 1)->get();
        $department = Department::where('department_id',$auth->department_id)->first();
        
        if(!Empty($department)){
            if( $users->count() > 0 ){
                foreach( $users as $user ){
                    $new = new NotifyMessage;
                    $new->system_id = 1;
                    $new->project_id = $project->project_id;
                    $new->message_key = 1;
                    $new->message_title = "คืนเงินจ้างเหมา";
                    $new->message_content = "คืนเงินจ้างเหมา " . $department->department_name ;
                    $new->message_date = date('Y-m-d H:i:s');
                    $new->user_id = $user->user_id;
                    $new->save();
        
                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                    if(!Empty($linenotify)){
                        if ($linenotify->linetoken != ""){
                            $message = "คืนเงินจ้างเหมา " . $department->department_name . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                            $linenotify->notifyme($message);
                        }
                    }
                }
            }
        }
    
        return redirect()->back()->withSuccess("คืนงบประมาณเรียบร้อยแล้ว");
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
