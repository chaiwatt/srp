<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use App\Controllers\ApiController;

use App\Model\Department;
use App\Model\Budget;

use App\Model\Project;
use App\Model\Allocation;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\Section;
use App\Model\InformationExpense;
use App\Model\Survey;
use App\Model\TransferTransaction;
use App\Model\LogFile;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;


class TransferDepartmentController extends Controller
{


    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $allocation = Allocation::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('allocation_type' , 2)
                    ->get();

       
        // $sumbybudget = Transfer::where('project_id' , $project->project_id)
        // ->where('department_id' , $auth->department_id)
        // ->where('transfer_type' , 2)
        // ->where('budget_id' , 1)->sum('transfer_price');

        //  return $sumbybudget;
        

        return view('transfer.department.index')->withProject($project)->withAllocation($allocation);
    }

    public function DeleteSave($id){
        $auth = Auth::user();
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $q = Transfer::query();
        $q = $q->where('transfer_id' , $id);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $q = $q->where('transfer_refund' , 0);
        $transfer = $q->first();

        $project = Project::where('project_id' , $transfer->project_id)->first();
        $department = Department::where('department_id' , $transfer->department_id)->first();
        $budget = Budget::where('budget_id' , $transfer->budget_id)->first();
        $section = Section::where('section_id' , $transfer->section_id)->first();

        $q = TransferTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $department->department_id);
        $q = $q->where('section_id' , $section->section_id);
        $q = $q->where('budget_id' , $budget->budget_id);
        $q = $q->where('transaction_type' , 2);
        $q = $q->orderBy('transfer_transaction_id' , 'desc');
        $transaction = $q->first();

        $balance = $transaction->transaction_balance + $transfer->transfer_price;

        $transfer->transfer_status = 0;
        $transfer->save();

        $new = new TransferTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $department->department_id;
        $new->section_id = $section->section_id;
        $new->budget_id = $budget->budget_id;
        $new->transaction_cost = $transaction->transaction_balance;
        $new->transaction_income = $transfer->transfer_price;
        $new->transaction_outcome = 0;
        $new->transaction_balance = $balance;
        $new->transaction_type = 2;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 79;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect()->back()->withSuccess("ระบบลบรายการโอนงบประมาณเรียบร้อยแล้ว");
    }

    public function EditSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $q = Transfer::query();
        $q = $q->where('transfer_id' , Request::input('id') );
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $q = $q->where('transfer_refund' , 0);
        $transfer = $q->first();
        if(count($transfer) == 0){
            return redirect()->back();
        }

        $project = Project::where('project_id' , $transfer->project_id)->first();
        $department = Department::where('department_id' , $transfer->department_id)->first();
        $section = Section::where('section_id' , $transfer->section_id)->first();
        $budget = Budget::where('budget_id' , $transfer->budget_id)->first();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , $budget->budget_id);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $sumtransfer1 = $q->sum('transfer_price'); 

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , $budget->budget_id);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $q = $q->wherenotin('transfer_id' , [ Request::input('id') ]);
        $sumtransfer2 = $q->sum('transfer_price'); 

        $sum = Request::input('number') + $sumtransfer2;

        if( $sum > $sumtransfer1 ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากงบประมาณไม่เพียงพอ");
        }

        $q = TransferTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $department->department_id);
        $q = $q->where('section_id' , $section->section_id);
        $q = $q->where('budget_id' , $budget->budget_id);
        $q = $q->where('transaction_type' , 2);
        $q = $q->orderBy('transfer_transaction_id' , 'desc');
        $transaction = $q->first();

        $balance = $transaction->transaction_balance + $transfer->transfer_price;

        $new = new TransferTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $department->department_id;
        $new->section_id = $section->section_id;
        $new->budget_id = $budget->budget_id;
        $new->transaction_cost = $transaction->transaction_balance;
        $new->transaction_income = $transfer->transfer_price;
        $new->transaction_outcome = 0;
        $new->transaction_balance = $balance;
        $new->transaction_type = 2;
        $new->save();

        if(  Request::input('number') > $balance ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้");
        }
        
        $transfer->transfer_price = Request::input('number');
        $transfer->save();

        $cost = $balance;
        $balance = $balance - Request::input('number');

        $new = new TransferTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $department->department_id;
        $new->section_id = $section->section_id;
        $new->budget_id = $budget->budget_id;
        $new->transaction_cost = $cost;
        $new->transaction_income = 0;
        $new->transaction_outcome = Request::input('number');
        $new->transaction_balance = $balance;
        $new->transaction_type = 2;
        $new->save();

        return redirect('transfer/department')->withSuccess("แก้ไขรายการโอนงบประมาณเรียบร้อยแล้ว");
    }

    public function Edit($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $transfer = Transfer::where('transfer_id' , $id)->where('transfer_type' , 2)->where('transfer_refund' , 0)->where('transfer_status' , 1)->first();
        if(count($transfer) == 0){
            return redirect()->back();
        }

        $project = Project::where('project_id' , $transfer->project_id)->first();
        $department = Department::where('department_id' , $transfer->department_id)->first();
        $section = Section::where('section_id' , $transfer->section_id)->first();
        $budget = Budget::where('budget_id' , $transfer->budget_id)->first();

        return view('transfer.department.edit')->withSection($section)->withTransfer($transfer)->withProject($project)->withDepartment($department)->withBudget($budget);
    }

    public function View($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('allocation_type' , 2);
        $q = $q->where('allocation_id' , $id);
        $allocation = $q->first();

        if( count($allocation) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูล");
        }

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $allocation->section_id);
        $q = $q->where('budget_id' , $allocation->budget_id);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $transfer = $q->get();
        
        $budget = Budget::where('budget_id' , $allocation->budget_id)->first();

        return view('transfer.department.view')->withProject($project)->withTransfer($transfer)->withAllocation($allocation)->withBudget($budget);
    }

    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $sum = 0;

        $q = Survey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $section = $q->get();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , Request::input('id'));
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $sumtransfer1 = $q->sum('transfer_price'); 

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , Request::input('id'));
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $sumtransfer2 = $q->sum('transfer_price'); 
       
        $sum = array_sum( Request::input('number') ) + $sumtransfer2;

        if( $sum > $sumtransfer1 ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากงบประมาณไม่เพียงพอ");
        }   

        if( count( $section ) > 0 ){
            foreach( $section as $item ){
                $checkfornotify = 0;
                if( @Request::input('number')[$item->section_id] != "" &&  @Request::input('number')[$item->section_id] != 0){

                	$q = Transfer::query();
                	$q = $q->where('project_id' , $project->project_id);
                    $q = $q->where('department_id' , $auth->department_id);
                    $q = $q->where('section_id' , 0);
                    $q = $q->where('budget_id' , Request::input('id'));
                    $q = $q->where('transfer_status' , 1);
                    $q = $q->where('transfer_type' , 1);
                    $sumtransfer1 = $q->sum('transfer_price'); 

                    $q = Transfer::query();
                    $q = $q->where('project_id' , $project->project_id);
                    $q = $q->where('department_id' , $auth->department_id);
                    $q = $q->where('budget_id' , Request::input('id'));
                    $q = $q->where('transfer_status' , 1);
                    $q = $q->where('transfer_type' , 2);
                    $sumtransfer2 = $q->sum('transfer_price'); 

                    $q = Transfer::query();
                    $q = $q->where('project_id' , $project->project_id);
                    $q = $q->where('department_id' , $auth->department_id);
                    $q = $q->where('section_id' , $item->section_id);
                    $q = $q->where('budget_id' , Request::input('id'));
                    $q = $q->where('transfer_status' , 1);
                    $q = $q->where('transfer_type' , 2);
                    $q = $q->where('transfer_refund', 0);
                    $transfer = $q->get();

                    $q = TransferTransaction::query();
                    $q = $q->where('project_id' , $project->project_id);
                    $q = $q->where('department_id' , $auth->department_id);
                    $q = $q->where('section_id' , $item->section_id);
                    $q = $q->where('budget_id' , Request::input('id'));
                    $q = $q->where('transaction_type' , 2);
                    $q = $q->orderBy('transfer_transaction_id' , 'desc');
                    $transaction = $q->first();

                    $sum = Request::input('number')[$item->section_id] + $sumtransfer2;

                    if( $sum > $sumtransfer1 ){
                    	return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากงบประมาณไม่เพียงพอ");
                    }

                    if( count($transaction) > 0 ){
                        if( @Request::input('number')[$item->section_id] > $transaction->transaction_balance ){
                            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
                        }

                        if( @Request::input('number')[$item->section_id] > $sumtransfer1 ){
                            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
                        }

                        $cost = $transaction->transaction_balance;
                    }
                    else{

                        $q = Allocation::query();
                        $q = $q->where('project_id' , $project->project_id);
                        $q = $q->where('department_id' , $auth->department_id);
                        $q = $q->where('section_id' , $item->section_id);
                        $q = $q->where('budget_id' , Request::input('id'));
                        $q = $q->where('allocation_type' , 2);
                        $allocation = $q->first();

                        if( @Request::input('number')[$item->section_id] > $allocation->allocation_price ){
                            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
                        }

                        if( @Request::input('number')[$item->section_id] > $sumtransfer1 ){
                            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
                        }

                        
                        $cost = $allocation->allocation_price;
                    }
                   
                    $checkfornotify++ ;
                    $new = new Transfer;
                    $new->project_id = $project->project_id;
                    $new->year_budget = $project->year_budget;
                    $new->department_id = $auth->department_id;
                    $new->section_id = $item->section_id;
                    $new->budget_id = Request::input('id');
                    $new->transfer_amount = $transfer->count() + 1;
                    $new->transfer_price = Request::input('number')[$item->section_id];
                    $new->transfer_date = date('Y-m-d H:i:s');
                    $new->transfer_status = 1;
                    $new->transfer_type = 2;
                    $new->user_id = $auth->user_id;
                    $new->save();

                    $new = new TransferTransaction;
                    $new->project_id = $project->project_id;
                    $new->year_budget = $project->year_budget;
                    $new->department_id = $auth->department_id;
                    $new->section_id = $item->section_id;
                    $new->budget_id = Request::input('id');
                    $new->transaction_cost = $cost;
                    $new->transaction_income = 0;
                    $new->transaction_outcome = Request::input('number')[$item->section_id];
                    $new->transaction_balance = $cost - Request::input('number')[$item->section_id];
                    $new->transaction_type = 2;
                    $new->save();

                }
                if ($checkfornotify > 0){
                    $users = Users::where('section_id' , $item->section_id)->get();
                    if( $users->count() > 0 ){
                        foreach( $users as $user ){
                            $new = new NotifyMessage;
                            $new->system_id = 1;
                            $new->project_id = $project->project_id;
                            $new->message_key = 1;
                            $new->message_title = "โอนเงินงบประมาณจ้างงาน";
                            $new->message_content = "โอนเงินงบประมาณจ้างงาน ปีงบประมาณ " . $project->year_budget;
                            $new->message_date = date('Y-m-d H:i:s');
                            $new->user_id = $user->user_id;
                            $new->save();
            
                            $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                            if(!Empty($linenotify)){
                                if ($linenotify->linetoken != ""){
                                    $message = "โอนเงินงบประมาณจ้างงาน ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                                    $linenotify->notifyme($message);
                                }
                            }
                        }
                    }
                }
            }
        }

        $new = new LogFile;
        $new->loglist_id = 76;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('transfer/department')->withSuccess("บันทึกรายการโอนงบประมาณเรียบร้อยแล้ว");

    }

    public function AttachSave(){
        // if( $this->authdepartment() ){
        //     return redirect('logout');
        // }
        $extension_doc = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png','doc','docx','xls','xlsx','pdf','txt','csv','zip','rar');
        if(count(Request::file('document', [])) > 0){
            foreach( Request::file('document', []) as $key => $file ){
                        if( in_array($file->getClientOriginalExtension(), $extension_doc) ){
                        $new_name = str_random(10).".".$file->getClientOriginalExtension();
                        $file->move('storage/uploads/transfer/document' , $new_name);
                        Transfer::where('transfer_id', $key)
                        ->update([ 
                            'document_name' =>  $file->getClientOriginalName(), 
                            'document_file' => "storage/uploads/transfer/document/".$new_name,
                            ]);
                    }
            }
            return redirect()->back()->withSuccess("เพิ่มเอกสารแนบเรียบร้อยแล้ว");
        }else{
            return redirect()->back()->withError("ไม่พบเอกสารแนบ");
        }
    }

    public function DeleteFile($id){
        $auth = Auth::user();
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $document = Transfer::where('transfer_id' , $id)->first();
        if( count($document) == 0 ){
            return redirect()->back();
        }

        @unlink( $document->document_file );
        Transfer::where('transfer_id', $id)
        ->update([ 
            'document_name' =>  "", 
            'document_file' => "",
            ]);

            $new = new LogFile;
            $new->loglist_id = 78;
            $new->user_id = $auth->user_id;
            $new->save();          

        return redirect()->back()->withSuccess("ลบไฟล์เอกสารเรียบร้อยแล้ว"); 
    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $search = 1 ;// Request::input('search')==""?"":Request::input('search');

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $budget = Budget::where('budget_id' , $search)->where('budget_status' , 1)->first();

        $q = Survey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $section = $q->get();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , $search);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->get();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , 0);
        $q = $q->where('budget_id' , $search );
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $sumtransfer1 = $q->sum('transfer_price'); 

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , $search );
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 2);
        $sumtransfer2 = $q->sum('transfer_price'); 

        $sum = $sumtransfer1 - $sumtransfer2;

        return view('transfer.department.create')->withProject($project)
        ->withAllocation($allocation)
        ->withSearch($search)
        ->withBudget($budget)
        ->withSection($section)
        ->withSum($sum);
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


