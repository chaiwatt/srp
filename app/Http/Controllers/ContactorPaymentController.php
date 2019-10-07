<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Project;
use App\Model\Department;
use App\Model\Contractor;
use App\Model\ContractorEmploy;
use App\Model\ContractorPosition;
use App\Model\SettingYear;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Allocation;
use App\Model\Transfer;
use App\Model\LogFile;

class ContactorPaymentController extends Controller
{
    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		
        $generate = Generate::where('project_id' , $project->project_id)
                        ->where('department_id' , $auth->department_id)
                        ->where('section_id' , 0)
                        ->where('generate_category' , 2)
                        ->where('generate_status' , 1)
                        ->get();

        return view('contractor.payment.index')->withProject($project)->withGenerate($generate);
    }

    public function Create($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $generate= Generate::where('project_id' , $project->project_id)
                        ->where('generate_id' , $id)
                        ->where('generate_status' , 1)
                        ->first();

        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลการจ้างงาน");
        }

        return view('contractor.payment.create')->withProject($project)->withGenerate($generate);

    }

    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_id' , Request::input('generate'));
        $q = $q->where('generate_status' , 1);
        $q = $q->where('generate_refund' , 0);
        $generate = $q->first();
        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่สามารถเบิกจ่ายเงินได้ เนื่องจากทำการคืนงบประมาณไปแล้ว");
        }
        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_code' , $generate->generate_code);
        $q = $q->where('payment_category' , 2);
        $q = $q->where('payment_status' , 1);
        $payment = $q->count();

        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่พอข้อมูลการจ้างงาน");
        }

        if( $payment >= 9 ){
            return redirect()->back()->withError("ไม่สามารถเบิกจ่ายเงินได้ เนื่องจากเกินจำนวนครั้งที่กำหนดไว้");
        }

        if( ( Request::input('absence') + Request::input('salary') ) !=  $generate->contractorPositionsalary ){
            return redirect()->back()->withError("ไม่สามารถบันทึกรายเบิกจ่ายได้ เนื่องจากไม่เท่ากับเงินเดือนที่กำหนดไว้");
        }

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_id' , $generate->generate_id);
        $q = $q->where('payment_category' , 2);
        $q = $q->where('payment_status' , 1);
        $paymeny = $q->where('payment_salary');

        $sum = ( Request::input('absence') + Request::input('fine') + Request::input('salary') ) + $payment ;

        if(  $sum > $generate->generate_allocation ){
            return redirect()->back()->withError("เกินงบประมาณที่จัดสรรไว้");
        }


        $payment = Payment::where('project_id' , $project->project_id)
                    ->where('department_id' ,  $auth->department_id)
                    ->where('section_id' , 0)
                    ->where('budget_id' , 6)
                    ->where('payment_status' , 1)
                    ->sum('payment_salary');

        $transfer = Transfer::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , 0)
                    ->where('budget_id' , 6)
                    ->where('transfer_type' , 1)
                    ->where('transfer_status' , 1)
                    ->sum('transfer_price');

        // return $transfer . "  " .  $payment;

        if( $sum > ($transfer  -  $payment )  ){
            return redirect()->back()->withError("ไม่สามารถบันทึกรายเบิกจ่ายได้ จำนวนเงินไม่เพียงพอจ่าย");
        }
        
        if( Request::input('date') == "" ){
            return redirect()->back()->withError("กรุณากรอกวันที่เบิกจ่าย");
        }
        $date1 = explode("/", Request::input('date'));
        
        $date = ($date1[2]-543)."-".$date1[1]."-".$date1[0];
        $month = $date1[1];
        $year = $date1[2];

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_code' , $generate->generate_code);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('payment_month' , $month);
        $q = $q->where('payment_year' , $year);
        $q = $q->where('payment_status' , 1);
        $payment = $q->first();

        if( count($payment) > 0 ){
            return redirect()->back()->withError("ไม่สามารถบันทึกรายเบิกจ่ายได้ เนื่องจ่ายเดือนนี้ได้เคยมีการบันทึกจ่ายเบิกแล้ว");
        }
      
        $new = new Payment;
        $new->generate_id = $generate->generate_id;
        $new->budget_id = 6;
        $new->generate_code = $generate->generate_code;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = 0;
        $new->payment_date = $date;
        $new->payment_month = $month;
        $new->payment_year = $year;
        $new->payment_absence = Request::input('absence');
        $new->payment_fine = Request::input('fine');
        $new->payment_salary = Request::input('salary');
        $new->position_salary = $generate->contractorPositionsalary;
        $new->register_id = $generate->register_id;
        $new->payment_category = 2;
        $new->payment_status = 1;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 8;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('contractor/payment')->withSuccess("บันทึกเบิกจ่ายเรียบร้อยแล้ว");

    }

	public function View($id){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_id' , $id );
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('payment_status' , 1);
        $payment = $q->get();

        return view('contractor.payment.view')->withProject($project)
        ->withPayment($payment);
    }

    public function History($id){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $payment = Payment::where('project_id' , $project->project_id)
                ->where('generate_id' , $id )
                ->where('department_id' , $auth->department_id)
                ->where('section_id' , 0)
                // ->where('payment_status' , 1)
                ->groupBy('register_id')
                ->get();

        return view('contractor.payment.history')->withProject($project)
        ->withPayment($payment);
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
