<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use App\Controllers\ApiController;

use App\Model\Project;
use App\Model\Department;
use App\Model\Budget;
use App\Model\Allocation;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\TransferTransaction;
use App\Model\LogFile;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;
use App\Model\Generate;
use App\Model\ContractorPosition;


class TransferController extends Controller{

	public function DeleteSave($id){
        $auth = Auth::user();
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
		$q = Transfer::query();
        $q = $q->where('transfer_id' , $id);
        $q = $q->where('transfer_type' , 1);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->first();

        $project = Project::where('project_id' , $transfer->project_id)->first();
        $department = Department::where('department_id' , $transfer->department_id)->first();
        $budget = Budget::where('budget_id' , $transfer->budget_id)->first();

        $q = TransferTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $department->department_id);
        $q = $q->where('budget_id' , $budget->budget_id);
        $q = $q->where('transaction_type' , 1);
        $q = $q->orderBy('transfer_transaction_id' , 'desc');
        $transaction = $q->first();

        $balance = $transaction->transaction_balance + $transfer->transfer_price;

		$transfer->transfer_status = 0;
		$transfer->save();

        $new = new TransferTransaction;
        $new->project_id = $transfer->project_id;
        $new->year_budget = $transfer->year_budget;
        $new->department_id = $transfer->department_id;
        $new->section_id = 0;
        $new->budget_id = $transfer->budget_id;
        $new->transaction_cost = $transaction->transaction_balance;
        $new->transaction_income = $transfer->transfer_price;
        $new->transaction_outcome = 0;
        $new->transaction_balance = $balance;
        $new->transaction_type = 1;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 79;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect()->back()->withSuccess("ระบบลบรายการโอนงบประมาณเรียบร้อยแล้ว");
	}

    public function EditSave(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $q = Transfer::query();
        $q = $q->where('transfer_id' , Request::input('id') );
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' , 1);
        $transfer = $q->first();
        if(count($transfer) == 0){
            return redirect()->back();
        }

        $project = Project::where('project_id' , $transfer->project_id)->first();
        $department = Department::where('department_id' , $transfer->department_id)->first();
        $budget = Budget::where('budget_id' , $transfer->budget_id)->first();
        
        $q = TransferTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $department->department_id);
        $q = $q->where('budget_id' , $budget->budget_id);
        $q = $q->where('transaction_type' , 1);
        $q = $q->orderBy('transfer_transaction_id' , 'desc');
        $transaction = $q->first();

        $balance = $transaction->transaction_balance + $transfer->transfer_price;

        $new = new TransferTransaction;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->department_id = $department->department_id;
        $new->section_id = 0;
        $new->budget_id = $budget->budget_id;
        $new->transaction_cost = $transaction->transaction_balance;
        $new->transaction_income = $transfer->transfer_price;
        $new->transaction_outcome = 0;
        $new->transaction_balance = $balance;
        $new->transaction_type = 1;
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
        $new->section_id = 0;
        $new->budget_id = $budget->budget_id;
        $new->transaction_cost = $cost;
        $new->transaction_income = 0;
        $new->transaction_outcome = Request::input('number');
        $new->transaction_balance = $balance;
        $new->transaction_type = 1;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 77;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('transfer/list');
    }

    public function Edit($id){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        
        $transfer = Transfer::where('transfer_id' , $id)->where('transfer_type' , 1)->where('transfer_status' , 1)->first();
        if(count($transfer) == 0){
            return redirect()->back();
        }

        $project = Project::where('project_id' , $transfer->project_id)->first();
        $department = Department::where('department_id' , $transfer->department_id)->first();
        $budget = Budget::where('budget_id' , $transfer->budget_id)->first();

        return view('transfer.edit')->withTransfer($transfer)->withProject($project)->withDepartment($department)->withBudget($budget);
    }

	public function View($id){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
		$transferfirst = Transfer::where('transfer_id' , $id)->first();
		$project = Project::where('project_id' , $transferfirst->project_id)->first();

		$q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('budget_id' , $transferfirst->budget_id);
        $q = $q->where('department_id' , $transferfirst->department_id);
        $q = $q->where('transfer_status' , 1);
        $q = $q->where('transfer_type' ,1);
        $q = $q->orderBy('transfer_id' , 'asc');
        $transfer = $q->get();

		return view('transfer.view')->withTransfer($transfer)->withProject($project);
	}

    public function CreateSave(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $project = Project::where('project_id' , Request::input('id'))->first();
        if(count($project) == 0){
            return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
        }
        $department = SettingDepartment::where('setting_year' , $project->year_budget)->where('setting_department_status' , 1)->get();
        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->get();
        $cost = 0;
        $balance = 0;
        if( count($budget) > 0 ){
            foreach( $budget as $item ){
                if( count($department) > 0 ){
                    foreach( $department as $value ){
                        $checkfornotify = 0;
                        if( @Request::input('number')[$item->budget_id][$value->department_id] != "" && @Request::input('number')[$item->budget_id][$value->department_id] != 0){
                            $number = @Request::input('number')[$item->budget_id][$value->department_id];
                            // งบจัสรร
                            $q = Allocation::query();
                            $q = $q->where('project_id' , $project->project_id);
                            $q = $q->where('department_id' , $value->department_id);
                            $q = $q->where('budget_id' , $item->budget_id);
                            $q = $q->where('allocation_type' , 1);
                            $allocation = $q->first();

                            //รายการโอน
                            $q = TransferTransaction::query();
                            $q = $q->where('project_id' , $project->project_id);
                            $q = $q->where('department_id' , $value->department_id);
                            $q = $q->where('budget_id' , $item->budget_id);
                            $q = $q->where('transaction_type' , 1);
                            $q = $q->orderBy('transfer_transaction_id' , 'desc');
                            $transaction = $q->first();

                            //โอน
                            $q = Transfer::query();
                            $q = $q->where('project_id' , $project->project_id);
                            $q = $q->where('department_id' , $value->department_id);
                            $q = $q->where('budget_id' , $item->budget_id);
                            $q = $q->where('transfer_status' , 1);
                            $q = $q->where('transfer_type' , 1);
                            $transfer = $q->get();

                            if( count($allocation) == 0 ){
                                return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากไม่พบข้อมูลในระบบ");
                            }

                            if( count( $transaction ) > 0 ){
                                if( $number >  $transaction->transaction_balance ){
                                    return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
                                }
                                $cost = $transaction->transaction_balance;
                                $balance = $transaction->transaction_balance;
                            }
                            else{
                                if( $number > $allocation->allocation_price ){
                                    return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลโอนงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
                                }
                                $cost = $allocation->allocation_price;
                                $balance = $allocation->allocation_price;
                            }
                            $checkfornotify ++;
                            $new = new Transfer;
                            $new->project_id = $project->project_id;
                            $new->year_budget = $project->year_budget;
                            $new->department_id = $value->department_id;
                            $new->section_id = 0;
                            $new->budget_id = $item->budget_id;
                            $new->transfer_amount = $transfer->count() + 1;
                            $new->transfer_price = Request::input('number')[$item->budget_id][$value->department_id];
                            $new->transfer_date = date('Y-m-d H:i:s');
                            $new->transfer_status = 1;
                            $new->transfer_type = 1;
                            $new->user_id = $auth->user_id;
                            $new->save();

                            $new = new TransferTransaction;
                            $new->project_id = $project->project_id;
                            $new->year_budget = $project->year_budget;
                            $new->department_id = $value->department_id;
                            $new->section_id = 0;
                            $new->budget_id = $item->budget_id;
                            $new->transaction_cost = $cost;
                            $new->transaction_income = 0;
                            $new->transaction_outcome = Request::input('number')[$item->budget_id][$value->department_id];
                            $new->transaction_balance = $balance - Request::input('number')[$item->budget_id][$value->department_id];
                            $new->transaction_type = 1;
                            $new->save();

                        }
                        if ($checkfornotify > 0){
                            $users = Users::where('department_id' , $value->department_id)
                            ->where('permission',2)->get();
                            if( $users->count() > 0 ){
                                foreach( $users as $user ){
                                    $new = new NotifyMessage;
                                    $new->system_id = 1;
                                    $new->project_id = $project->project_id;
                                    $new->message_key = 1;
                                    $new->message_title = "ผู้บริหารโครงการโอนเงินค่าใช้จ่าย";
                                    $new->message_content = "โอนเงินค่าใช้จ่าย" . $item->budget_name . " ปีงบประมาณ " . $project->year_budget;
                                    $new->message_date = date('Y-m-d H:i:s');
                                    $new->user_id = $user->user_id;
                                    $new->save();
                    
                                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                                    if(!Empty($linenotify)){
                                        if ($linenotify->linetoken != ""){
                                            $message = "โอนเงินค่าใช้จ่าย" . $item->budget_name . " ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                                            $linenotify->notifyme($message);
                                        }
                                    }
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

        return redirect('transfer/list')->withSuccess("บันทึกรายการโอนงบประมาณเรียบร้อยแล้ว");

    }


    public function AttachSave(){
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
        }
        return redirect('transfer/list')->withSuccess("เพิ่มเอกสารแนบเรียบร้อยแล้ว");

    }

    public function DeleteFile($id){
        $auth = Auth::user();
        if( $this->authsuperadmin() ){
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

        return redirect('transfer/list' )->withSuccess("ลบไฟล์เอกสารเรียบร้อยแล้ว"); 
    }

    public function Create(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $setting = SettingYear::where('setting_status' , 1)->first();
        
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        
        if(count($project) == 0){
            return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
        }

        $department = SettingDepartment::where('setting_year' , $project->year_budget)->where('setting_department_status' , 1)->orderBy('department_id')->get();
        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->orderBy('budget_id')->get();
        
        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('allocation_type' , 1);
        $allocation = $q->get();
        
        $q = TransferTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('transaction_type' , 1);
        $transaction = $q->get();
        
        $generate = Generate::where('project_id' , $project->project_id)
        ->where('generate_category' , 2)
        ->get();

        $_transfer = Transfer::where('project_id' , $project->project_id)
        ->where('budget_id' , 6)
        ->where('transfer_type' , 1)
        ->where('transfer_status' , 1)
        ->sum('transfer_price');

        if($generate->count() > 0){
            $contractorposition = ContractorPosition::where('position_id',$generate->first()->position_id)->first();
            $maxremain = ($generate->count() * $contractorposition->position_salary * 9) - $_transfer;
        }else{
            $maxremain = 0;
        }            
        
        return view('transfer.create')->withDepartment($department)
                                ->withBudget($budget)
                                ->withProject($project)
                                ->withAllocation($allocation)
                                ->withMaxremain($maxremain)
                                ->withTransaction($transaction);
    }

    public function TransferList(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
    	$budget = Request::input('budget')==""?"0":Request::input('budget');
        $setting = SettingYear::where('setting_status' , 1)->first();


        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(count($project) == 0){
            return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
        }

        $transfer = Transfer::where('project_id' , $project->project_id)
                        ->where('transfer_status' , 1)
                        ->where('transfer_type' , 1)
                        ->get();

        $department = Transfer::where('project_id' , $project->project_id)
                    ->where('transfer_status' , 1)
                    ->where('transfer_type' , 1)
                    ->groupBy('department_id')
                    ->get();

        // $budgetlist = Budget::get();
        $allocation = Allocation::where('project_id' , $project->project_id)
                                ->where('allocation_type' , 1)
                                ->get();

        $budgetlist = Transfer::where('project_id' , $project->project_id)
                            ->where('transfer_status' , 1)
                            ->where('transfer_type' , 1)
                            ->groupBy('budget_id')
                            ->get();

        return view('transfer.list')->withProject($project)
                        ->withTransfer($transfer)
                        ->withDepartment($department)
                        ->withAllocation($allocation)
                        ->withBudgetlist($budgetlist);
    }

    public function Index(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        $project = Project::orderBy('year_budget' , 'desc')->paginate(10);
        return view('transfer.index')->withProject($project);
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


