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
use App\Model\Transfer;
use App\Model\Refund;
use App\Model\Allocation;
use App\Model\LogFile;

class RecuritPaymentSectionController extends Controller{

	public function View($id){
		if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_id' , $id );
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('payment_status' , 1);
        $payment = $q->get();

        return view('recurit.payment.section.view')->withProject($project)->withPayment($payment);
	}

    public function DeleteSave($id){
        // return $id;
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('payment_id' , $id );
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $payment = $q->first();

        if( count($payment) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลการเบิกจ่าย");
        }

        // $payment->payment_status = 0;
        // $payment->save();

        $payment->delete();
        $new = new LogFile;
        $new->loglist_id = 43;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/payment/section/list')->withSuccess("ลบข้อมูลการเบิกจ่ายเรียบร้อยแล้ว");
    }

    public function EditSave(){

        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $date = explode("/", Request::input('date') );
        $editdate = ($date[2]-543)."-".$date[1]."-".$date[0];

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $payment = Payment::where('payment_id' , Request::input('payment'))->first();

        // if( ( Request::input('absence') + Request::input('salary') ) !=  $payment->position_salary ){
        //     return redirect()->back()->withError("ไม่สามารถบันทึกรายการเบิกจ่ายได้ เนื่องจากไม่เท่ากับเงินเดือนที่กำหนดไว้");
        // }

        $payment = Payment::where('payment_id' ,Request::input('payment'))
        ->update([ 
            'payment_date' =>  $editdate , 
            'payment_absence' =>  Request::input('absence'), 
            'payment_fine' => Request::input('fine'),
            'payment_salary' => Request::input('salary'),
            ]);


        $new = new LogFile;
        $new->loglist_id = 44;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/payment/section/list')->withSuccess("แก้ไขข้อมูลเบิกจ่ายเรียบร้อยแล้ว");
    }

    public function Edit($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('payment_id' , $id );
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('payment_status' , 1);
        $payment = $q->first();

        if( count($payment) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลการเบิกจ่าย");
        }

        return view('recurit.payment.section.edit')->withProject($project)->withPayment($payment);
    }

    public function CreateSave(){
        // return Request::input('salary') ;
        if( $this->authsection() ){
            return redirect('logout');
        }

        $date1 = explode("/", Request::input('date'));
        $date = ($date1[2]-543)."-".$date1[1]."-".$date1[0];
        $month = $date1[1];
        $year = $date1[2];
        
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
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

        $_payment = Payment::where('project_id' , $project->project_id)
                                ->where('generate_code' , $generate->generate_code)
                                ->where('payment_category' , 1)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->where('payment_month' , $month)
                                ->where('payment_year' , $year)
                                ->where('payment_status' , 1)->get();
                                
        $_salary = $_payment->sum('payment_salary') ;
        $_absence = $_payment->sum('payment_absence') ;

        if($_payment->count() > 0){
            if(($_salary + $_absence + Request::input('salary') + Request::input('absence')) > $_payment->first()->position_salary){
                return redirect()->back()->withError("ไม่สามารถเบิกจ่ายเงินได้ เนื่องจากเกินเงินเดือนของเดือนนี้");
            }
        }else{
            if((Request::input('salary') + Request::input('absence')) > $generate->positionsalary){
                return redirect()->back()->withError("ไม่สามารถเบิกจ่ายเงินได้ เนื่องจากเบิกจ่ายเกินเงินเดือน");
            }
        }

        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_code' , $generate->generate_code);
        $q = $q->where('payment_category' , 1);
        $q = $q->where('payment_status' , 1);
        $payment = $q->count();

        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่พอข้อมูลการจ้างงาน");
        }

        if( $payment >= 9 ){
            return redirect()->back()->withError("ไม่สามารถเบิกจ่ายเงินได้ เนื่องจากเกินจำนวนครั้งที่กำหนดไว้");
        }
        
        // if( ( Request::input('absence') + Request::input('salary') ) !=  $generate->positionsalary ){
        //     return redirect()->back()->withError("ไม่สามารถบันทึกรายการเบิกจ่ายได้ เนื่องจากไม่เท่ากับเงินเดือนที่กำหนดไว้");
        // }

        //---------------------------------------------------
        // $q = Payment::query();
        // $q = $q->where('project_id' , $project->project_id);
        // $q = $q->where('generate_id' , $generate->generate_id);
        // $q = $q->where('payment_category' , 2);
        // $q = $q->where('payment_status' , 1);
        // $paymeny = $q->where('payment_salary');
       
        $sum = ( Request::input('absence') + Request::input('fine') + Request::input('salary') ) ;
        if(  $sum > $generate->generate_allocation ){
            return redirect()->back()->withError("เกินงบประมาณที่จัดสรรไว้");
        }
        //-----------------------------------------------------
        
        if( $sum > $allocation->transferpaymentbalance  ){
            return redirect()->back()->withError("ไม่สามารถบันทึกรายเบิกจ่ายได้ จำนวนเงินไม่เพียงพอจ่าย");
        }

        if( Request::input('date') == "" ){
            return redirect()->back()->withError("กรุณากรอกวันที่เบิกจ่าย");
        }

        $payment = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_code' , $generate->generate_code);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('payment_month' , $month);
        $q = $q->where('payment_year' , $year);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('register_id' , $generate->register_id);
        $payment = $q->first();

        if( count($payment) > 0 ){
            return redirect()->back()->withError("ไม่สามารถบันทึกรายเบิกจ่ายได้ เนื่องจากได้จ่ายค่าจ้างให้ผู้รับจ้างเดือนนี้แล้ว");
        }
        //----------------------------------------------------
        $new = new Payment;
        $new->generate_id = $generate->generate_id;
        $new->budget_id = 1;
        $new->generate_code = $generate->generate_code;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $auth->department_id;
        $new->section_id = $auth->section_id;
        $new->payment_date = $date;
        $new->payment_month = $month;
        $new->payment_year = $year;
        $new->payment_absence = Request::input('absence');
        $new->payment_fine = Request::input('fine');
        $new->payment_salary = Request::input('salary');
        $new->position_salary = $generate->positionsalary;
        $new->register_id = $generate->register_id;
        $new->payment_category = 1;
        $new->payment_status = 1;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 42;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/payment/section')->withSuccess("บันทึกเบิกจ่ายเรียบร้อยแล้ว");

    }

    public function Create($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('generate_id' , $id);
        $q = $q->where('generate_status' , 1);
        $generate = $q->first();

        if( count($generate) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลการจ้างงาน");
        }

        return view('recurit.payment.section.create')->withProject($project)->withGenerate($generate);
    }

    public function Lists(){

        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('payment_category' , 1);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('budget_id' , 1);
        $payment = $q->get();

        return view('recurit.payment.section.list')->withPayment($payment);
    }

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		
        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('generate_category' , 1);
        $q = $q->where('generate_status' , 1);
        $generate = $q->get();

        return view('recurit.payment.section.index')->withProject($project)->withGenerate($generate);
    }

    public function authsection(){
        $auth = Auth::user();
        if( $auth->permission != 3 ){
            return true;
        }
        else{
            return false;
        }
    }

}


