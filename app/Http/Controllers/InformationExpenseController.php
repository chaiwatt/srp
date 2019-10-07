<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\InformationExpense;
use App\Model\Department;
use App\Model\Transfer;
use App\Model\DepartmentAllocation;
use App\Model\Refund;
use App\Model\LogFile;

class InformationExpenseController extends Controller{

	public function CreateSave(){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();
    	$department = Department::where('department_id' , $auth->department_id)->first();
		$expense = InformationExpense::where('project_id' , $project->project_id)->where('department_id' , $department->department_id)->get();

    	$q = Transfer::query();
    	$q = $q->where('project_id' , $project->project_id);
    	$q = $q->where('department_id' , $auth->department_id);
    	$q = $q->where('budget_id' , 2);
    	$q = $q->where('transfer_status' , 1);
    	$transfer = $q->get();

    	$sum = ( $expense->sum('expense_price') + Request::input('price') );
    	if( $sum > $transfer->sum('transfer_price') ){
    		return redirect()->back()->withError("ไม่สามารถเพิ่มค่าใช้จ่ายได้ประชาสัมพันธ์ได้ เนื่องจากเกินเงินตั้งต้น");
    	}

    	$new = new InformationExpense;
    	$new->department_id = $auth->department_id;
    	$new->project_id = $project->project_id;
    	$new->year_budget = $project->year_budget;
        $new->budget_id = 2;
    	$new->expense_name = Request::input('name');
    	$new->expense_type = Request::input('type');
    	$new->expense_amount = Request::input('amount');
    	$new->expense_price = Request::input('price');
    	$new->expense_outsource = Request::input('outsource');
    	$new->expense_description = Request::input('description');
    	$new->user_id = $auth->user_id;
		$new->save();
		
		$new = new LogFile;
        $new->loglist_id = 22;
        $new->user_id = $auth->user_id;
        $new->save();

    	return redirect("information/expense")->withSuccess("เพิ่มค่าใช้จ่ายประชาสัมพันธ์เรียบร้อยแล้ว");
    	
	}

	public function create(){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
		$auth = Auth::user();
		
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();
    	$department = Department::where('department_id' , $auth->department_id)->first();
		$expense = InformationExpense::where('project_id' , $project->project_id)->where('department_id' , $department->department_id)->sum('expense_price');
        
    	$q = Transfer::query();
    	$q = $q->where('project_id' , $project->project_id);
    	$q = $q->where('department_id' , $auth->department_id);
    	$q = $q->where('budget_id' , 2);
    	$q = $q->where('transfer_status' , 1);
    	$transfer = $q->sum('transfer_price');

    	if( $transfer == 0 ){
    		return redirect('information/expense')->withError("ไม่สามารถเพิ่มค่าใช้จ่ายได้ประชาสัมพันธ์ได้ เนื่องจากไม่มีเงินตั้งต้น");
    	}

		return view('information.expense.create')->withProject($project)->withDepartment($department)->withExpense($expense)->withTransfer($transfer);
	}

    public function Index(){
    	if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();
    	$department = Department::where('department_id' , $auth->department_id)->first();
    	$expense = InformationExpense::where('project_id' , $project->project_id)->where('department_id' , $department->department_id)->get();

        $transfer = Transfer::where('project_id' , $project->project_id)->where('department_id',$auth->department_id)->where('budget_id' , 2)->sum('transfer_price');
        $refund = Refund::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('budget_id' , 2)->where('refund_status' , 1)->sum('refund_price');

    	return view('information.expense.index')->withRefund($refund)->withTransfer($transfer)->withDepartment($department)->withExpense($expense)->withProject($project);
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


