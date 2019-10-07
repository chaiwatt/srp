<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use App\Controllers\ApiController;

use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\Project;
use App\Model\ProjectAllocation;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\DepartmentAllocation;
use App\Model\TransferDepartment;
use App\Model\Refund;
use App\Model\Payment;
use App\Model\InformationExpense;
use App\Model\AllocationWaiting;

class ProjectRefundController extends Controller{

    public function Index(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
     
        $settingyear = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $settingyear->setting_year)->first();

        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }

        $refundpending = AllocationWaiting::where('project_id' , $project->project_id)
                                ->where('waiting_status',0)
                                ->get();
        $sumbydept = AllocationWaiting::where('waiting_status',1)->where('year_budget' , $settingyear->setting_year)->groupBy('department_id')->selectRaw('*, sum(waiting_price) as sum')->get();                         

        return view('project.refund.main.index')->withProject($project)
                                                ->withRefundpending($refundpending)
                                                ->withSumbydept($sumbydept);
    }

    public function Confirm($id){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $refund = AllocationWaiting::where('waiting_id',$id)->first();
        $refund->waiting_status = 1;
        $refund->save();

        return redirect('project/refund/main')->withSuccess("บันทึกยืนยันการคืนเงินเรียบร้อยแล้ว");
    }

    public function EditSave($id){
        $newallocate = Request::input('number');
        $department_id = $id ;
        $sum = 0;
        $settingyear = SettingYear::where('setting_status' , 1)->first();
        $remainbudget = AllocationWaiting::where('department_id',$department_id)
                                ->where('year_budget',$settingyear->setting_year)
                                ->where('waiting_status',1)
                                ->get(); 
        if($remainbudget->sum('waiting_price') < $newallocate){
            return redirect()->route('project.refund')->withError("จำนวนเงินรอเปลี่ยนแปลงไม่เพียงพอ สำหรับจัดสรร");;
        }

        foreach($remainbudget as $item) {
            $sum = $sum + $item->waiting_price ;
            if ($sum >= $newallocate){
                $remain = $sum - $newallocate;
                AllocationWaiting::where('waiting_id',$item->waiting_id)->update(['waiting_price' => $remain]);
                break;
            }else{
                AllocationWaiting::where('waiting_id',$item->waiting_id)->update(['waiting_price' => 0]);
            }   
        }
        return redirect()->route('project.refund')->withSuccess("บันทึกเสร็จสิ้น");
    }

    public function Edit($id, $budget){
        $settingyear = SettingYear::where('setting_status' , 1)->first();
        return view('project.refund.main.edit')->withId($id)
                                            ->withBudget($budget)
                                            ->withSettingyear($settingyear);
    }

    public function View(){
        $settingyear = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $settingyear->setting_year)->first();

        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }


        $allrefund = AllocationWaiting::where('project_id' , $project->project_id)
                                    ->where('year_budget' , $settingyear->setting_year)
                                    ->get();
        return view('project.refund.main.view')->withAllrefund($allrefund)
                                               ->withSettingyear($settingyear);
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

    // public function Index(){
    //     if( $this->authadmin() ){
    //         return redirect('logout');
    //     }
        
    //     $auth = Auth::user();

    //     $setting = SettingYear::where('setting_status' , 1)->first();
    //     $project = Project::where('year_budget' , $setting->setting_year)->first();

    //     $q = Refund::query();
    //     $q = $q->where('project_id' , $project->project_id);
    //     $q = $q->where('refund_status' , 1);
    //     $q = $q->where('refund_type' , 1);
    //     $q = $q->groupBy('budget_id');
    //     $q = $q->groupBy('department_id');
    //     $refund = $q->get();

    //     $q = ProjectAllocation::query();
    //     $q = $q->where('project_id' , $project->project_id);
    //     $allocation = $q->get();

    //     $q = Transfer::query();
    //     $q = $q->where('project_id' , $project->project_id);
    //     $q = $q->where('transfer_status' , 1);
    //     $transfer = $q->get();

    //     $q = Payment::query();
    //     $q = $q->where('project_id' , $project->project_id);
    //     $q = $q->where('payment_status' , 1);
    //     $q = $q->where('payment_category' , 1);
    //     $q = $q->where('payment_type' , 2);
    //     $payment = $q->get();

    //     $q = InformationExpense::query();
    //     $q = $q->where('project_id' , $project->project_id);
    //     $expense = $q->get();

    //     return view('project.refund.main.index')->withProject($project)
    //     ->withAllocation($allocation)
    //     ->withTransfer($transfer)
    //     ->withRefund($refund)
    //     ->withPayment($payment)
    //     ->withExpense($expense);
    // }


}


