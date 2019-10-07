<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Budget;
use App\Model\LogFile;

class SettingBudgetController extends Controller{

	public function DeleteSave($id){
		$auth = Auth::user();
		$budget = Budget::where('budget_id' , $id )->first();
		$budget->budget_status = 0;
		$budget->save();

		$new = new LogFile;
        $new->loglist_id = 55;
        $new->user_id = $auth->user_id;
		$new->save();

		return redirect('setting/budget')->withSuccess("ลบรายการค่าใช้จ่ายเรียบร้อยแล้ว");
	}

	public function EditSave(){
		$auth = Auth::user();
		$budget = Budget::where('budget_id' , Request::input('id') )->first();
		$budget->budget_name = Request::input('name');
		$budget->save();

		$new = new LogFile;
        $new->loglist_id = 54;
        $new->user_id = $auth->user_id;
		$new->save();
		
		return redirect('setting/budget')->withSuccess("แก้ไขรายการค่าใช้จ่ายเรียบร้อยแล้ว");
	}

	public function Edit($id){
		$budget = Budget::where('budget_id' , $id)->first();
		if( count($budget) == 0 ){
			return redirect()->back()->withError("ไม่พบรายการค่าใช้จ่าย");
		}

		return view('setting.budget.edit')->withBudget($budget);
	}

	public function CreateSave(){

		if( Request::input('name') == "" ){
			return redirect()->back()->withError("กรุณากรอก ชื่อรายการค่าใช้จ่าย");
		}
		$auth = Auth::user();
		$new = new Budget;
		$new->budget_name = Request::input('name');
		$new->save();

		$new = new LogFile;
        $new->loglist_id = 53;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/budget');
	}

	public function Create(){
		return view('setting.budget.create');
	}

    public function Index(){
    	$budget = Budget::where('budget_status' , 1)->get();
    	return view('setting.budget.index')->withBudget($budget);
    }

}


