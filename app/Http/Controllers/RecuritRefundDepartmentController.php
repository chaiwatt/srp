<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\ProjectBudget;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Transfer;
use App\Model\Refund;
use App\Model\Allocation;
use App\Model\AllocationTransaction;
use App\Model\AllocationWaiting;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;
use App\Model\Department;


class RecuritRefundDepartmentController extends Controller{

  public function ViewConfirm($id){
    if( $this->authdepartment() ){
        return redirect('logout');
    }
    $auth = Auth::user();

    $setting = SettingYear::where('setting_status' , 1)->first();
    $project = Project::where('year_budget' , $setting->setting_year)->first();

    $q = Refund::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('section_id' , $id);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('refund_type' , 2);
    $q = $q->where('refund_status' , 0);
    $refund = $q->get();

    if( count($refund) > 0 ){
      foreach( $refund as $item ){
        $q = Refund::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('refund_id' , $item->refund_id );
        $q = $q->where('budget_id' , 1);
        $q = $q->where('refund_type' , 2);
        $q = $q->where('refund_status' , 0);
        $refund = $q->first();

        $refund->refund_status = 1;
        $refund->save();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $refund->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->first();
        
        $q = AllocationTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $refund->section_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('transaction_type' , 2);
        $q = $q->orderBy('allocation_transaction_id' , 'desc');
        $transaction = $q->first();

        $new = new AllocationTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = $refund->section_id;
        $new->budget_id = 1;
        $new->transaction_cost = ($allocation->allocation_price);
        $new->transaction_income = 0;
        $new->transaction_outcome = $refund->refund_price;
        $new->transaction_balance = ($transaction->transaction_balance - $refund->refund_price);
        $new->transaction_type = 2;
        $new->save();
        /* transaction section */

        $allocation->allocation_price = ($allocation->allocation_price - $refund->refund_price);
        $allocation->save();

        $q = AllocationTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('transaction_type' , 1);
        $q = $q->orderBy('allocation_transaction_id' , 'desc');
        $transaction = $q->first();

        $new = new AllocationTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->budget_id = 1;
        $new->transaction_cost = $transaction->transaction_cost;
        $new->transaction_income = $refund->refund_price;
        $new->transaction_outcome = 0;
        $new->transaction_balance = ($transaction->transaction_balance + $refund->refund_price);
        $new->transaction_type = 1;
        $new->save();

        $new = new Transfer;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = $refund->section_id;
        $new->budget_id = 1;
        $new->transfer_amount = 0;
        $new->transfer_price = ($refund->refund_price * -1);
        $new->transfer_date = date('Y-m-d H:i:s');
        $new->transfer_status = 1;
        $new->transfer_type = 2;
        $new->transfer_refund = 1;
        $new->user_id = $auth->user_id;
        $new->save();
      }
    }
    else{
      return redirect()->back()->withError("ไม่พบข้อมูลการคืนเงิน");
    }

    return redirect()->back()->withSuccess("บันทึกยืนยันงบประมาณคืนเงินเรียบร้อยแล้ว");
  }

  public function View(){
    if( $this->authdepartment() ){
        return redirect('logout');
    }
    $auth = Auth::user();

    $setting = SettingYear::where('setting_status' , 1)->first();
    $project = Project::where('year_budget' , $setting->setting_year)->first();

    $q = Allocation::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('allocation_type' , 2);
    $allocation = $q->get();

    $q = Transfer::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('transfer_status' , 1);
    $q = $q->where('transfer_type' , 2);
    $transfer = $q->get();

    $q = Payment::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('payment_category' , 1);
    $q = $q->where('payment_status' , 1);
    $payment = $q->get();

    $q = Refund::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('refund_status' , 0);
    $q = $q->where('refund_type' , 2);
    $q = $q->groupBy('section_id');
    $section = $q->get();

    $q = Refund::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('refund_type' , 2);
    $q = $q->where('refund_status' , 0);
    $refund = $q->get();

    return view('recurit.refund.department.view')->withProject($project)->withTransfer($transfer)->withPayment($payment)->withAllocation($allocation)->withSection($section)->withRefund($refund);
  }

  public function confirm( $id ){
      if( $this->authdepartment() ){
          return redirect('logout');
      }
      $auth = Auth::user();

      $setting = SettingYear::where('setting_status' , 1)->first();
      $project = Project::where('year_budget' , $setting->setting_year)->first();

      $q = Refund::query();
      $q = $q->where('refund_id' , $id);
      $q = $q->where('department_id' , $auth->department_id);
      $q = $q->where('budget_id' , 1);
      $q = $q->where('refund_status' , 1);
      $q = $q->where('refund_type' , 2);
      $refund = $q->first();

      if( count($refund) == 0 ){
          return redirect()->back()->withError("ไม่พบข้อมูลการคืนงบประมาณจัดจ้าง");
      }

      $new = new Refund;
      $new->project_id = $project->project_id;
      $new->year_budget = $project->year_budget;
      $new->department_id = $auth->department_id;
      $new->section_id = 0;
      $new->budget_id = 1;
      $new->refund_price = $refund->refund_price;
      $new->refund_status = 1;
      $new->refund_type = 1;
      $new->user_id = $auth->user_id;
      $new->save();

      $refund->refund_status = 0;
      $refund->save();

      return redirect()->back()->withSuccess("คืนงบประมาณเรียบร้ยแล้ว");
  }

  public function IndexSave(){
    if( $this->authdepartment() ){
        return redirect('logout');
    }
    $auth = Auth::user();

    $setting = SettingYear::where('setting_status' , 1)->first();
    $project = Project::where('year_budget' , $setting->setting_year)->first();

    $allocation = Allocation::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('allocation_type' , 1)
                        ->first();

    $sumtransfer1 = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , 0)
                        ->where('budget_id' , 1 )
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 1)
                        ->sum('transfer_price'); 

    $sumtransfer2 = Transfer::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('budget_id' , 1)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 2)
                        ->sum('transfer_price'); 

    $balance = abs($sumtransfer1 - $sumtransfer2);

    if( Request::input('number') > $balance ){
      return redirect()->back()->withError("ไม่สามารถคืนงบประมาณได้ เนื่องจากไม่มีงบประมาณคงเหลือ");
    }

    $new = new Refund;
    $new->project_id = $project->project_id;
    $new->year_budget = $project->year_budget;
    $new->department_id = $auth->department_id;
    $new->section_id = 0;
    $new->budget_id = 1;
    $new->generate_id = 0;
    $new->refund_price = Request::input('number');
    $new->user_id = $auth->user_id;
    $new->refund_status = 1;
    $new->refund_type = 1;
    $new->save();

    $q = Allocation::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('section_id' , 0);
    $q = $q->where('budget_id' , 1);
    $q = $q->where('allocation_type' , 1);
    $allocation = $q->first();
    
    $q = AllocationTransaction::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('department_id' , $auth->department_id);
    $q = $q->where('section_id' , 0 );
    $q = $q->where('budget_id' , 1);
    $q = $q->where('transaction_type' , 1);
    $q = $q->orderBy('allocation_transaction_id' , 'desc');
    $transaction = $q->first();

    $new = new AllocationTransaction;
    $new->project_id = $project->project_id;
    $new->year_budget = $project->year_budget;
    $new->department_id = $auth->department_id;
    $new->section_id = 0;
    $new->budget_id = 1;
    $new->transaction_cost = ($transaction->transaction_cost);
    $new->transaction_income = 0;
    $new->transaction_outcome = Request::input('number');
    $new->transaction_balance = ($transaction->transaction_cost - Request::input('number') );
    $new->transaction_type = 1;
    $new->save();
    /* transaction section */

    $allocation->allocation_price = ($allocation->allocation_price - Request::input('number') );
    $allocation->save();

    $new = new Transfer;
    $new->project_id = $project->project_id;
    $new->year_budget = $project->year_budget;
    $new->department_id = $auth->department_id;
    $new->section_id = 0;
    $new->budget_id = 1;
    $new->transfer_amount = 0;
    $new->transfer_price = ( Request::input('number') * -1);
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
    $new->budget_id = 1;
    $new->waiting_price = Request::input('number');
    $new->waiting_price_view = Request::input('number');
    $new->waiting_status = 0;
    $new->save();

    $q = ProjectBudget::query();
    $q = $q->where('project_id' , $project->project_id);
    $q = $q->where('budget_id' , 1);
    $budget = $q->first();
    $budget->allocate = ($budget->allocate);
    $budget->save();

    $users = Users::where('permission' , 1)->get();
    $department = Department::where('department_id',$auth->department_id)
                        ->first();
    
    if(!Empty($department)){
        if( $users->count() > 0 ){
            foreach( $users as $user ){
                $new = new NotifyMessage;
                $new->system_id = 1;
                $new->project_id = $project->project_id;
                $new->message_key = 1;
                $new->message_title = "คืนเงินจ้างงาน";
                $new->message_content = "คืนเงินจ้างงาน " . $department->department_name ;
                $new->message_date = date('Y-m-d H:i:s');
                $new->user_id = $user->user_id;
                $new->save();
    
                $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                if(!Empty($linenotify)){
                    if ($linenotify->linetoken != ""){
                        $message = "คืนเงินจ้างงาน " . $department->department_name . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                        $linenotify->notifyme($message);
                    }
                }
            }
        }
    }

    return redirect()->back()->withSuccess("คืนงบประมาณเรียบร้อยแล้ว");
  }

  public function Index(){
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
      $q = $q->where('budget_id' , 1 );
      $q = $q->where('transfer_status' , 1);
      $q = $q->where('transfer_type' , 1);
      $sumtransfer1 = $q->sum('transfer_price'); 

      $q = Transfer::query();
      $q = $q->where('project_id' , $project->project_id);
      $q = $q->where('department_id' , $auth->department_id);
      $q = $q->where('budget_id' , 1);
      $q = $q->where('transfer_status' , 1);
      $q = $q->where('transfer_type' , 2);
      $sumtransfer2 = $q->sum('transfer_price'); 

      $balance = abs( $sumtransfer1 - $sumtransfer2 );

      return view('recurit.refund.department.index')->withProject($project)->withBalance($balance);
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


