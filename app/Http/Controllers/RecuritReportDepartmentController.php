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
use App\Model\Transfer;
use App\Model\Allocation;
use App\Model\Position;
use App\Model\Refund;

class RecuritReportDepartmentController extends Controller{

    public function Sum(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $section = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('generate_category' , 1);
        $employ = $q->get();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('department_id' , $auth->department_id);
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
        $q = $q->where('refund_type' , 2);
        $refund = $q->get();

        $q = Resign::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('resign_status' , 1);
        $resign = $q->get();

        $position = Position::where('department_id' , $auth->department_id)->get();

        return view('recurit.report.department.sum')->withProject($project)
        ->withEmploy($employ)
        ->withPosition($position)
        ->withSection($section)
        ->withTransfer($transfer)
        ->withPayment($payment)
        ->withAllocation($allocation)
        ->withRefund($refund)
        ->withGenerate($generate)
        ->withResign($resign);
    }

    public function PaymentView($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $id);
        $q = $q->where('payment_month' , Request::input('month'));
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_category' , 1);
        $payment = $q->get();

        return view('recurit.report.department.payment-view')->withPayment($payment)->withProject($project);
    }

    public function Payment(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_category' , 1);
        $q = $q->groupBy('payment_month');
        $payment = $q->get();

        return view('recurit.report.department.payment')->withPayment($payment)->withProject($project);
    }

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
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $section = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('generate_category' , 1);
        $employ = $q->get();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('department_id' , $auth->department_id);
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
        $q = $q->where('refund_type' , 2);
        $refund = $q->get();

        $q = Resign::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('resign_status' , 1);
        $resign = $q->get();

        $position = Position::where('department_id' , $auth->department_id)->get();

        return view('recurit.report.department.index')->withProject($project)
        ->withEmploy($employ)
        ->withPosition($position)
        ->withSection($section)
        ->withTransfer($transfer)
        ->withPayment($payment)
        ->withAllocation($allocation)
        ->withRefund($refund)
        ->withGenerate($generate)
        ->withResign($resign);
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


