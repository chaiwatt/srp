<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\Register;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Resign;
use App\Model\Transfer;
use App\Model\Position;
use App\Model\Refund;
use App\Model\Section;
use App\Model\Allocation;

class RecuritReportController extends Controller{

    public function PaymentSection($id){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Section::query();
        $q = $q->where('section_id' , $id);
        $q = $q->where('section_status' , 1);
        $section = $q->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $section->department_id);
        $q = $q->where('section_id' , $section->section_id  );
        $q = $q->where('payment_month' , Request::input('month'));
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_category' , 1);
        $payment = $q->get();

        return view('recurit.report.payment-section')->withPayment($payment)->withProject($project)->withDepartment($section->department_id)->withMonth( Request::input('month') );
    }

    public function PaymentDepartment($id){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_category' , 1);
        $q = $q->where('payment_month' , Request::input('month'));
        $q = $q->groupBy('section_id');
        $payment = $q->get();

        return view('recurit.report.payment-department')->withPayment($payment)->withProject($project)->withDepartment($id);
    }

    public function Payment(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return redirect('project/allocation')->withError("ยังไม่ได้กำหนดโครงการ");
        }
        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('payment_category' , 1);
        $q = $q->groupBy('department_id');
        $q = $q->groupBy('payment_month');
        $payment = $q->get();

        return view('recurit.report.payment')->withPayment($payment)->withProject($project);
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
        $q = SettingDepartment::query();
        $q = $q->where('setting_year' , $project->year_budget);
        $department = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_category' , 1);
        $employ = $q->get();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->get();
        
        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $transfer = $q->get();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('payment_category' , 1);
        $q = $q->where('payment_status' , 1);
        $payment = $q->get();

        $q = Refund::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('refund_type' , 1);
        $refund = $q->get();

        $q = Resign::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('resign_status' , 1);
        $resign = $q->get();

        if( count($department) > 0 ){
            foreach( $department as $item ){
                $position[$item->department_id] = Position::where('department_id' , $item->department_id)->get();
            }            
        }
        else{
            $position = array();
        }

        if($allocation->count() == 0){
            return redirect('project/allocation')->withError('ยังไม่ได้จัดสรรโครงการ');
        }

        return view('recurit.report.index')->withProject($project)
                                        ->withEmploy($employ)
                                        ->withPosition($position)
                                        ->withTransfer($transfer)
                                        ->withPayment($payment)
                                        ->withAllocation($allocation)
                                        ->withRefund($refund)
                                        ->withGenerate($generate)
                                        ->withResign($resign)
                                        ->withDepartment($department);
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


