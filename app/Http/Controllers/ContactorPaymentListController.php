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

class ContactorPaymentListController extends Controller
{

    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        $q = Payment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('payment_category' , 2);
        $q = $q->where('payment_status' , 1);
        $q = $q->where('budget_id' , 6);
        $payment = $q->get();

        return view('contractor.payment.list.index')->withPayment($payment);
    }

    public function Edit($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        $payment = Payment::where('payment_id' , $id)->first();

         return view('contractor.payment.list.edit')->withPayment($payment);
    }

    public function EditSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $payment = Payment::where('payment_id' , Request::input('payment_id'))->first();

        if( ( Request::input('absence') + Request::input('salary') ) !=  $payment->position_salary ){
            return redirect()->back()->withError("ไม่สามารถบันทึกรายเบิกจ่ายได้ เนื่องจากไม่เท่ากับเงินเดือนที่กำหนดไว้");
        }

        $payment = Payment::where('payment_id' ,Request::input('payment_id'))
                ->update([ 
                    'payment_absence' =>  Request::input('absence'), 
                    'payment_fine' => Request::input('fine'),
                    'payment_salary' => Request::input('salary'),
                    ]);

        return redirect('contractor/payment/list')->withSuccess("แก้ไขสำเร็จ");  

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
